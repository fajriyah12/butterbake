@extends('layouts.app')

@section('content')

<div class="admin-main">

    <div class="inventory-header">

        <div>

            <h1>Add Category</h1>

            <p class="inventory-subtitle">
                Create a new product category.
            </p>

        </div>

    </div>

    <form action="{{ route('admin.categories.store') }}"
          method="POST">

        @csrf

        <div class="form-box">

            <div class="form-group">

                <label>Category Name</label>

                <input type="text"
                       name="name"
                       placeholder="e.g Bread"
                       required>

            </div>

        </div>

        <div class="btn-group">

            <a href="{{ route('admin.categories.index') }}"
               class="cancel">

                Back

            </a>

            <button type="submit"
                    class="save">

                Save Category

            </button>

        </div>

    </form>

</div>

@endsection