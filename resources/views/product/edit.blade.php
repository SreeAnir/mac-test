@extends('layout.default')
@section('content') 
<div class="container p-2">
    <h1 class="d-flex justify-content-between">{{ __('Edit Product')}} <a href="{{ route('products.index')}}" class="btn btn-secondary"> Go to Products</a></h1>
    {{-- {{ dd($product->sizes)}} --}}
    @php
     $product_sizes  =  $product->sizes->pluck('id')->toArray(); 
     $product_colors = $product->colors->pluck('id')->toArray();;
    @endphp
  @include('product.partials.form')
 @endsection
 