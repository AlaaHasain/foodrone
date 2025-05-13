@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

{{-- Header --}}
@include('layouts.partials.header')


{{-- contect --}}
@include('layouts.partials.contact-form')

{{-- Footer --}}
@include('layouts.partials.footer')

@endsection

@section('scripts')

@endsection
