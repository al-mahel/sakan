{{-- ═══════════════════════════════════════════ --}}
{{-- HERO --}}
{{-- ═══════════════════════════════════════════ --}}
<section class="relative bg-navy overflow-hidden" style="min-height: 580px;">

    {{-- Background pattern --}}
    <div class="absolute inset-0 opacity-10">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 py-24 text-center">

        <span class="badge bg-white/20 text-white mb-4 inline-block text-sm px-4 py-1.5 rounded-full">
            🏠 {{ number_format($totalCount) }}+ عقار متاح
        </span>

        <h1 class="text-4xl md:text-6xl font-black text-white mb-4 leading-tight">
            ابحث عن
            <span class="text-navy-200">سكنك المثالي</span>
        </h1>

        <p class="text-navy-200 text-lg md:text-xl mb-10 max-w-2xl mx-auto">
            آلاف العقارات من شقق وغرف واستوديوهات في أفضل المناطق
        </p>

        {{-- Quick Search Box --}}
        <div class="bg-white rounded-2xl shadow-2xl p-4 max-w-4xl mx-auto">
            <form action="{{ route('properties.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                    <input
                        type="text"
                        name="keyword"
                        placeholder="🔍 ابحث عن عقار..."
                        class="search-input md:col-span-2"
                        value="{{ request('keyword') }}"
                    >

                    <select name="type" class="search-input">
                        <option value="">كل الأنواع</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>

                    <select name="city" class="search-input">
                        <option value="">كل المدن</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>

                </div>
                <button type="submit" class="btn-primary w-full mt-3 text-lg">
                    بحث عن العقارات
                </button>
            </form>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════ --}}
{{-- STATS BAR --}}
{{-- ═══════════════════════════════════════════ --}}
<section class="bg-navy-800 text-white py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div>
                <div class="text-2xl font-black text-navy-200">{{ number_format($totalCount) }}+</div>
                <div class="text-sm text-gray-300">عقار مسجل</div>
            </div>
            <div>
                <div class="text-2xl font-black text-navy-200">{{ $cities->count() }}+</div>
                <div class="text-sm text-gray-300">مدينة</div>
            </div>
            <div>
                <div class="text-2xl font-black text-navy-200">{{ $types->count() }}</div>
                <div class="text-sm text-gray-300">نوع عقار</div>
            </div>
            <div>
                <div class="text-2xl font-black text-navy-200">100%</div>
                <div class="text-sm text-gray-300">موثوق</div>
            </div>
        </div>
    </div>
</section>
