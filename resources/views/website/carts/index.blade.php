@extends('layouts.website.app')

@section('head_title')
    {{ __('Cart') }}
@endsection
@section('content')
    <section class="wrapper bg-light">
        @livewire('cart')
    </section>
@endsection

