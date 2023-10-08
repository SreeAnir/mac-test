@extends('layout.default')
@section('content') 
<div class="container p-2">
    <h1 class="d-flex justify-content-between">{{ __('Create new Product')}} <a href="{{ route('products.index')}}" class="btn btn-secondary"> Go to Products</a></h1>
  
    {{ @$error}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group mt-2">
          <label for="title">Product Name</label>
          <input type="text" class="form-control mt-2" name="title" id="title" placeholder="Product Name">
        </div>
        <div class="form-group mt-2">
            <label for="description">Product Description</label>
            <textarea  rows="3" id="description" name="description" id="description" class="form-control mt-2" required></textarea>
          </div>
        <div class="form-group mt-2">
          <label for="sizes">Product Size Variant</label>
          <select multiple class="form-control mt-2" id="sizes" name="sizes[]">
            @foreach ($sizes as $size)
            <option value="{{ $size->id }}">{{ $size->name }}</option>
             @endforeach
          </select>
        </div>
        <div class="form-group mt-2">
          <label for="exampleFormControlSelect2">Product Color Variant</label>
          <select multiple class="form-control mt-2"  id="colors" name="colors[]">
            @foreach ($colors as $size)
            <option value="{{ $size->id }}">{{ $size->name }}</option>
             @endforeach
          </select>
        </div>

        <div class="form-group mt-2">
            <input type="hidden1" id="main_image_file_name" name="main_image_file_name" >

            <label for="main_image">Main Image</label>
            <input type="file" id="main_image"  class="form-control mt-2-file" accept="image/*" required>

            <img id="image_preview" src="#" alt="Image Preview" style="display: none; max-width: 400px; margin-top: 10px;">
        </div>

        <button type="submit" class="btn btn-secondary text-dark">Submit</button>

         
      </form>

 
</div>
@endsection


@section('scripts')
<script>
   
$(document).ready(function() {
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });

    $('#main_image').change(function() {

            let input = this;
            if (input.files && input.files[0]) {
            var file = input.files[0];
            
            var allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
            if (allowedTypes.indexOf(file.type) === -1) {
                alert("Please select a valid image file (jpeg, png, jpg, gif).");
                return;  
            }else{


            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image_preview').attr('src', e.target.result);
                $('#image_preview').css('display', 'block');
            };

            reader.readAsDataURL(file);
        
        var formData = new FormData();
        formData.append('file', $('#main_image')[0].files[0]);

        $.ajax({
            url: '{{ route("upload") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('File uploaded successfully:', response.file_name);
                $('#main_image_file_name').val(response.file_name);
            },
            error: function() {
                console.error('File upload failed.');
            }
        });
    }
        
        }
    });
});

</script>
@endsection
<style>
    /* CSS for the image preview */
#image_preview {
    max-width: 100%;
    margin-top: 10px;
}

</style>



