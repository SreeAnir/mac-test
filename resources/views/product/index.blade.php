@extends('layout.default')
@section('content') 
<div class="container p-2">
    <h1 class="d-flex justify-content-between pb-2">{{ __('Products List')}} <a href="{{ route('products.create')}}" class="btn btn-primary"> New Product</a></h3>


    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Sizes') }}</th>
                <th>{{ __('Colors') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Image') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td >{{ $product->title }}</td>
                <td>
                    @foreach ($product->sizes as $size)
                        {{ $size->name }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($product->colors as $color)
                        {{ $color->name }}<br>
                    @endforeach
                </td>
                <td>
                    
                        {{ @$product->description }}<br>
                </td>
                
                <td>
                    @if ($product->main_image)
                        <a target="_blank">
                            <img src="{{ asset('uploads/products/' . $product->main_image) }}" alt="Product Image" width="100">
                        </a>
                    @else
                        {{ __('No Image Available')}}
                    @endif
                </td>
                <td style="10%">
                    <div class="d-flex justify-content-around">

                        <a target="_blank" href="{{ route('products.edit',[$product->id])}}"  type="button" class="btn btn-secondary btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button  onclick="return confirmDelete()" type="submit"  type="button" class="btn btn-danger btn-sm" class="btn  sm-btn btn-danger">Delete</button>
                        </form>
                    </div>
                                            
                </td>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}  

</div>
@endsection

@section('scripts')
<script> 
 function confirmDelete() {
            return confirm('Are you sure you want to delete this item?');
    }
</script>
@endsection
