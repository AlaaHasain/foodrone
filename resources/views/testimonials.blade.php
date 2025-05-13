@extends('layouts.app')

@section('title', 'tesimonials')

@section('content')
{{-- Header --}}
@include('layouts.partials.header')

{{-- Testimonial Form --}}
@include('layouts.partials.testimonial-form')

{{-- Footer --}}
@include('layouts.partials.footer')
@endsection
