@extends('layout.default')
@section('content') 
<div class="container p-2">
    <h1 class="d-flex justify-content-between">{{ __('Create new Product')}} <a href="{{ route('products.index')}}" class="btn btn-secondary"> Go to Products</a></h1>
  @include('product.partials.form')
  {{-- resources\views\product\partials\form.blade.php --}}
@endsection
 