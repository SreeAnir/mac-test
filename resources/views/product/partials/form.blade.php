 
   
    <div class="card">
        
        <div class="card-body">
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
    <div class="col-lg-9 m-auto">   
    <form method="POST"
     action="{{ (@$product == "" ? route('products.store')  : route('products.update',$product) ) }}" enctype="multipart/form-data">

        @csrf
        @if(@$product!=null) 
        @method('PUT')
        @endif
        <div class="form-group mt-2">
          <label for="title">Product Name</label>
          <input required type="text" value="{{ old('title') ?? $product->title ?? '' }}" class="form-control mt-2" name="title" id="title" placeholder="Product Name">
        </div>
        <div class="form-group mt-2">
            <label for="description">Product Description</label>
            <textarea required  rows="3" id="description" name="description" id="description" class="form-control mt-2" required>{{ old('description') ?? $product->description ?? '' }}</textarea>
          </div>
        <div class="form-group mt-2">
          <label for="sizes">Product Size Variant</label>  
          <select multiple class="form-control mt-2" id="sizes" name="sizes[]">
            @foreach ($sizes as $size)
            <option 
            {{ is_array(old('sizes')) && in_array($size->id, old('sizes')) ?   'selected'   :( is_array(@$product_sizes) &&   in_array($size->id, @$product_sizes) ?   'selected' : '')  }}
            value="{{ $size->id }}">{{ $size->name }}</option>
             @endforeach
          </select>
        </div>
        <div class="form-group mt-2">
          <label for="exampleFormControlSelect2">Product Color Variant</label>
          <select multiple class="form-control mt-2"  id="colors" name="colors[]">
            @foreach ($colors as $color)
            <option 
            {{ is_array(old('colors')) && in_array($color->id, old('colors')) ?   'selected'   :( is_array(@$product_colors) &&   in_array($color->id, @$product_colors) ?   'selected' : '')  }}
            value="{{ $size->id }}">{{ $size->name }}</option>
            >{{ $color->name }}
        </option>
             @endforeach
          </select>
        </div>

        <div class="form-group mt-2">
            <input type="hidden" id="main_image_file_name" name="main_image_file_name" >
            <div class="d-flex justify-content-start">
                <div class="pr-4">
                <label for="main_image">Main Image</label>
                @if (@$product!=null && @$product->main_image)
                <input type="hidden" value="{{  @$product->main_image }}" name="main_image" />
                @endif

            <input  type="file" id="img_upload" name=""  class="form-control mt-2-file" accept="image/*"  
              {{ (@$product==null ||  @$product->main_image ==null ? 'required' : '')}}  >
                </div>
                <img 
                @if (@$product!=null && @$product->main_image)
                    src="{{ asset('uploads/products/' . $product->main_image) }}" alt="Product Image"   style="max-width: 200px; margin-top: 10px;"
                    @else 
                    style="display:none;max-width: 200px; margin-top: 10px;"
                 @endif
                id="image_preview" src="#" alt="Image Preview" >

            </div>

            

        </div>

    </div>

        <div class="card-footer text-muted">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Cancel</button>

          </div>
      </form>
        </div>
</div>
</div>


@section('scripts')
<script>
   
$(document).ready(function() {
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });

    $('#img_upload').change(function() {

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
        formData.append('file', $('#img_upload')[0].files[0]);

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



