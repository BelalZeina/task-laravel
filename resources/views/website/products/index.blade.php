@extends('layouts.website.app')
@section('content')

    <livewire:product-search :initialCategoryId="@$categoryId" />

@endsection



