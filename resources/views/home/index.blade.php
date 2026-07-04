@extends('layouts.app')

@section('title', 'سكن | ابحث عن عقارك المثالي')
@section('meta_description', 'سكن - منصة البحث عن العقارات والشقق والغرف السكنية في مصر بأفضل الأسعار')

@section('content')

    @include('home.sections.hero')

    @include('home.sections.about')

    @include('home.sections.featured-properties')

    @include('home.sections.property-types')

    @include('home.sections.universities')

    @include('home.sections.services')

    @include('home.sections.latest-properties')

    @include('home.sections.cta')

    @push('scripts')
        <script>
            const uniSwiper = new Swiper('.universities-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.universities-swiper .swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next-uni',
                    prevEl: '.swiper-button-prev-uni',
                },
                breakpoints: {
                    640:  { slidesPerView: 2 },
                    768:  { slidesPerView: 3 },
                    1024: { slidesPerView: 4 },
                },
            });
    </script>
    @endpush

@endsection
