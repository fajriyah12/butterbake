@extends('layouts.app')

@section('content')

<div class="admin-main">

    {{-- SUCCESS TOAST --}}
    @if(session('success'))

    <div class="success-toast" id="successToast">

        <div class="toast-icon">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <div class="toast-content">
            <h4>{{ session('title', 'Success') }}</h4>

            <p>{{ session('message', session('success')) }}</p>
        </div>

        <button class="toast-close"
                onclick="closeToast()">

            <i class="fa-solid fa-xmark"></i>

        </button>

    </div>

    @endif

    {{-- HEADER --}}
    <div class="inventory-header">

        <div>
            <h1>Categories</h1>

            <p class="inventory-subtitle">
                Manage your product categories.
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="save">

            <i class="fa-solid fa-plus"></i>
            Add Category

        </a>

    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">

        <table class="inventory-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Category Name</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($categories as $category)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td class="category-name">
                            {{ $category->name }}
                        </td>

                        <td>
                            {{ $category->created_at->format('d M Y') }}
                        </td>

                        <td>

                            <div class="action-group">

                                {{-- EDIT --}}
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="btn-edit">

                                    <i class="fa-solid fa-pen"></i>
                                    Edit

                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete \'{{ $category->name }}\'? This cannot be undone.')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn-delete">

                                        <i class="fa-solid fa-trash"></i>
                                        Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="empty-state">

                            <i class="fa-regular fa-folder-open"></i>

                            <p>No categories found.</p>

                            <a href="{{ route('admin.categories.create') }}"
                               class="save">

                                Add your first category

                            </a>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- AUTO CLOSE TOAST --}}
<script>

function closeToast(){

    const toast = document.getElementById('successToast');

    if(toast){
        toast.style.display = 'none';
    }
}

setTimeout(() => {
    closeToast();
}, 4000);

</script>

@endsection