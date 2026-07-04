{{-- ═══════════════════════════════════════════ --}}
{{-- LATEST PROPERTIES --}}
{{-- ═══════════════════════════════════════════ --}}
@if($latest->count())
    <section class="py-16 max-w-7xl mx-auto px-4">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="section-title"> أحدث العقارات</h2>
                <p class="section-subtitle">عقارات أضيفت مؤخراً</p>
            </div>
            <a href="{{ route('properties.index') }}" class="btn-outline hidden md:inline-block text-sm">
                عرض الكل
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latest as $property)
                @include('properties._card', ['property' => $property])
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('properties.index') }}" class="btn-primary inline-block">
                عرض كل العقارات
            </a>
        </div>

    </section>
@endif
