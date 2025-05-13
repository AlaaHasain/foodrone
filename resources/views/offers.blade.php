@extends('layouts.app')

@section('title', 'Offers')

@section('content')
{{-- Header --}}
@include('layouts.partials.header')

{{-- Offer Section --}}
@include('layouts.partials.offer-section')

{{-- Footer --}}
@include('layouts.partials.footer')
@endsection
