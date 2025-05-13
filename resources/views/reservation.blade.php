@extends('layouts.app')

@section('title', 'reservation')

@section('content')

{{-- Header --}}
@include('layouts.partials.header')

{{-- Reservation Section --}}
@include('layouts.partials.reservation-section')

{{-- Footer --}}
@include('layouts.partials.footer')

@endsection
