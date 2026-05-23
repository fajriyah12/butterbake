@extends('layouts.app')

@section('content')

<div class="admin-main">

    <div class="inventory-header">
        <div>
            <h1>Edit Category</h1>
            <p class="inventory-subtitle">Update the category details below.</p>
        </div>
    </div>

    <form action="{{ route('admin.categories.update', $category->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="form-box-simple">

            <div class="form-group">
                <label>Category Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $category->name) }}"
                       placeholder="e.g. Croissants & Pastries"
                       required>
            </div>

        </div>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="btn-group">
            <a href="{{ route('admin.categories.index') }}" class="cancel">Discard</a>
            <button type="submit" class="save">Save Changes</button>
        </div>

    </form>

</div>

<script>
    const nameInput = document.querySelector('input[name="name"]');

    nameInput.addEventListener('input', function () {

    });
</script>

@endsection