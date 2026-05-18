@extends('layouts.app')

@section('content')

<div class="admin-main">

    <div class="inventory-header">
        <div>
            <h1>Add New Product</h1>
            <p class="inventory-subtitle">Fill in the details below to add a new product.</p>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="form-box">

            <!-- LEFT SIDE -->
            <div>

                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="e.g. Artisanal Sourdough Croissant"
                           required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"
                              placeholder="Describe the texture, ingredients, and baking process...">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Ingredients</label>
                    <textarea name="ingredients"
                              placeholder="e.g. Flour, butter, eggs, sea salt...">{{ old('ingredients') }}</textarea>
                </div>

                <div class="row">

                    <div class="form-group">
                        <label>Price (Rp)</label>
                        <div class="price-wrapper">
                            <span class="price-prefix">Rp</span>
                            <input type="number"
                                   name="price"
                                   value="{{ old('price') }}"
                                   placeholder="45000"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Initial Stock Quantity</label>
                        <input type="number"
                               name="stock"
                               value="{{ old('stock') }}"
                               placeholder="0"
                               required>
                    </div>

                </div>

                <div class="row">

                    <div class="form-group">
                        <label>Rating (0.0 – 5.0)</label>
                        <input type="number"
                               name="rating"
                               value="{{ old('rating', 0) }}"
                               placeholder="4.5"
                               step="0.1"
                               min="0"
                               max="5">
                    </div>

                    <div class="form-group">
                        <label>Review Count</label>
                        <input type="number"
                               name="review_count"
                               value="{{ old('review_count', 0) }}"
                               placeholder="0"
                               min="0">
                    </div>

                </div>

                <div class="form-group">
                    <label>Category</label>
                    <div class="select-wrapper">
                        <select name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <p class="section-label" style="margin-top:8px;">Visibility Settings</p>

                <label class="toggle-card">
                    <div class="toggle-card-text">
                        <strong>Featured Product</strong>
                        <span>Highlight this on the storefront homepage.</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="is_featured"
                               {{ old('is_featured') ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </label>

                <label class="toggle-card">
                    <div class="toggle-card-text">
                        <strong>Active Product</strong>
                        <span>Make this product visible to customers.</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="is_active" checked>
                        <span class="slider"></span>
                    </label>
                </label>

            </div>

            <!-- RIGHT SIDE -->
            <div class="right-col">

                <p class="section-label">Product Photography</p>

                <div class="upload-zone" id="uploadZone" onclick="document.getElementById('imageInput').click()">

                    <input type="file"
                           id="imageInput"
                           name="image"
                           accept="image/*"
                           style="display:none;"
                           onchange="previewImage(event)">

                    <img id="imagePreview"
                         src=""
                         alt="Preview"
                         style="display:none; width:100%; height:220px; object-fit:cover; border-radius:10px; margin-bottom:8px;">

                    <div id="uploadPlaceholder">
                        <div class="upload-icon">
                            <i class="fa-regular fa-camera"></i>
                        </div>
                        <p>Drop your imagery here</p>
                        <small>High-resolution JPG or PNG.<br>Natural lighting preferred for an artisanal aesthetic.</small>
                    </div>

                    <div id="changePhotoLabel" style="display:none; margin-top:6px;">
                        <small style="color:#888;"><i class="fa-solid fa-rotate"></i> Click to change photo</small>
                    </div>

                </div>

                <div class="quality-card">
                    <div class="qc-title">
                        <i class="fa-solid fa-circle-info"></i>
                        Quality Standard
                    </div>
                    <p>"Every product added to Butter Bake must reflect our commitment to slow fermentation and premium Grade-A ingredients."</p>
                </div>

            </div>

        </div>

        <!-- BUTTONS -->
        <div class="btn-group">
            <a href="{{ route('admin.products.index') }}" class="cancel">Discard</a>
            <button type="submit" class="save">Save Product</button>
        </div>

    </form>

    @if ($errors->any())
        <div class="error-box">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
            document.getElementById('uploadPlaceholder').style.display = 'none';
            document.getElementById('changePhotoLabel').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
</script>

@endsection