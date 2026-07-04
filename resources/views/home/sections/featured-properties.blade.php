{{-- ═══════════════════════════════════════════ --}}
{{-- FEATURED PROPERTIES --}}
{{-- ═══════════════════════════════════════════ --}}
@if($featured->count())
    <section class="py-16 max-w-7xl mx-auto px-4">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="section-title"> العقارات المميزة</h2>
                <p class="section-subtitle">عقارات مختارة بعناية لك</p>
            </div>
            <a href="{{ route('properties.index', ['featured' => 1]) }}"
               class="btn-outline hidden md:inline-block text-sm">
                عرض الكل
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featured as $property)
                @include('properties._card', ['property' => $property])
            @endforeach
        </div>

    </section>
@endif
