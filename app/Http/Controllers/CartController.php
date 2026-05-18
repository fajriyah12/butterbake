<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Ambil atau buat cart berdasarkan user yang login.
     * Kalau sudah login → pakai user_id.
     * Kalau belum login → tidak akan sampai sini karena route sudah dilindungi middleware auth.
     */
    private function getOrCreateCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    /**
     * Tampilkan halaman keranjang.
     * Route GET /cart boleh diakses siapa saja (publik).
     */
    public function index()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())
                ->with('items.product.category')
                ->first();

            if (!$cart) {    
                $cart = new Cart();
                $cart->setRelation('items', collect());
            }
                
        } else {
            // Kalau belum login, tampilkan keranjang kosong
            $cart = new Cart();
            $cart->setRelation('items', collect());
        }

        return view('cart.cart', compact('cart'));
    }

    /**
     * Tambah produk ke keranjang.
     * Route POST /cart/add — wajib login (middleware auth di web.php).
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek stok
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $cart = $this->getOrCreateCart();

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            // Sudah ada di keranjang → tambah quantity
            $newQty = $item->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok tersedia.');
            }
            $item->update(['quantity' => $newQty]);
        } else {
            // Belum ada → buat baru
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', '"' . $product->name . '" berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update quantity item di keranjang.
     * Route PATCH /cart/{item} — wajib login.
     */
    public function update(Request $request, CartItem $item)
    {
        // Pastikan item milik user yang login
        $this->authorizeItem($item);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $item->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Hapus item dari keranjang.
     * Route DELETE /cart/{item} — wajib login.
     */
    public function remove(CartItem $item)
    {
        $this->authorizeItem($item);

        $item->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    /**
     * Pastikan CartItem milik user yang sedang login.
     * Cegah user lain hapus/ubah keranjang orang lain.
     */
    private function authorizeItem(CartItem $item): void
    {
        $cart = Cart::where('id', $item->cart_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }
}