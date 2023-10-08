@extends('layout.default')
@section('content') 
<div class="container p-2">
    <h1 class="d-flex justify-content-between">{{ __('Products')}} <a href="{{ route('products.create')}}" class="btn btn-primary"> New Product</a></h1>
    <h3>{{ __('Products List') }} </h3>

    <table class="table">
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Sizes') }}</th>
                <th>{{ __('Colors') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Image') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->title }}</td>
                <td>
                    sizes
                </td>
                <td>
                   colors
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
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}  

</div>
@endsection
