{{-- ═══════════════════════════════════════════ --}}
{{-- BROWSE BY TYPE --}}
{{-- ═══════════════════════════════════════════ --}}
<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="section-title text-center">تصفح حسب النوع</h2>
        <p class="section-subtitle text-center">اختر ما يناسبك</p>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mt-8">
            @php
                $typeIcons = [
                    'شقة'        => '🏢',
                    'غرفة'       => '🛏️',
                    'استوديو'    => '🏠',
                    'فيلا'       => '🏡',
                    'دوبلكس'     => '🏘️',
                    'وحدة سكنية' => '🏗️',
                ];
            @endphp

            @foreach($types as $type)
                <a href="{{ route('properties.index', ['type' => $type]) }}"
                   class="bg-white rounded-2xl p-5 text-center shadow hover:shadow-lg
                      hover:-translate-y-1 transition-all duration-200 group">
                    <div class="text-3xl mb-2">{{ $typeIcons[$type] ?? '🏠' }}</div>
                    <div class="font-bold text-navy group-hover:text-navy-500 text-sm">{{ $type }}</div>
                </a>
            @endforeach
        </div>

    </div>
</section>
