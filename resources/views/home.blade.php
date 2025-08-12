@extends('layouts.app')

@section('title', 'SegurosPro - Gestión de Siniestros')

@push('styles')
<!-- Estilos específicos del home si los necesitas -->
@endpush

@section('content')
    <!-- Hero Section -->
    @include('components.sections.hero')

    <!-- Stats Section -->
    @include('components.sections.stats')

    <!-- Features Section -->
    @include('components.sections.features')

    <!-- How it Works -->
    @include('components.sections.how-it-works')

    <!-- Testimonials -->
    @include('components.sections.testimonials')

    <!-- CTA Section -->
    @include('components.sections.cta')
@endsection

@push('scripts')
<!-- Scripts específicos del home si los necesitas -->
@endpush
