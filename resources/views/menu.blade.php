@extends('layouts.app')

@section('title', 'menu')

@section('content')
{{-- Header --}}
@include('layouts.partials.header')

{{-- Food Section --}}
@include('layouts.partials.food-section')

{{-- Footer --}}
@include('layouts.partials.footer')
@endsection
