@extends('layouts.app')

@section('content')

<div class="admin-main">

    <h1>Edit Product</h1>

    <form action="{{ route('admin.products.update', $product->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-box">

            <!-- LEFT SIDE -->
            <div>

                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $product->name) }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Ingredients</label>
                    <textarea name="ingredients">{{ old('ingredients', $product->ingredients) }}</textarea>
                </div>

                <div class="row">

                    <div class="form-group">
                        <label>Price</label>
                        <input type="number"
                               name="price"
                               value="{{ old('price', $product->price) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number"
                               name="stock"
                               value="{{ old('stock', $product->stock) }}"
                               required>
                    </div>

                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" required>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox"
                               name="is_featured"
                               {{ $product->is_featured ? 'checked' : '' }}>
                        Featured Product
                    </label>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox"
                               name="is_active"
                               {{ $product->is_active ? 'checked' : '' }}>
                        Active Product
                    </label>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div>

                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         class="preview"
                         width="200">
                @endif

                <div class="form-group">
                    <label>Change Product Image</label>
                    <input type="file"
                           name="image"
                           accept="image/*">
                </div>

            </div>

        </div>

        <!-- BUTTONS -->
        <div class="btn-group">

            <a href="{{ route('admin.products.index') }}"
               class="cancel">
                Cancel
            </a>

            <button type="submit" class="save">
                Update Product
            </button>

        </div>

    </form>

    <!-- ERROR VALIDATION -->
    @if ($errors->any())

        <div style="margin-top:20px; color:red;">

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

</div>

@endsection