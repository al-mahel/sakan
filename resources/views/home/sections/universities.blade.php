<section class="py-16 max-w-7xl mx-auto px-4">

    <div class="text-center mb-10">
        <h2 class="section-title"> الجامعات المتاحة</h2>
        <p class="section-subtitle">ابحث عن سكن قريب من جامعتك</p>
    </div>

    <div class="relative px-10 md:px-12">

        <div class="swiper universities-swiper overflow-hidden">
            <div class="swiper-wrapper pb-16">
                @foreach($universities as $university)
                    <div class="swiper-slide">
                        <a href="{{ route('properties.index', ['university' => $university->name]) }}"
                           class="block group">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl
                                transition-all duration-300 hover:-translate-y-1">

                                <div class="relative overflow-hidden h-44">
                                    <img
                                        src="{{ $university->image ? asset('storage/' . $university->image) : asset('images/university-placeholder.webp') }}"
                                        alt="{{ $university->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        loading="lazy"
                                    >
                                    <div class="absolute inset-0 bg-navy/40 group-hover:bg-navy/30 transition"></div>
                                    <div class="absolute bottom-3 right-3">
                                        <span class="bg-white/90 text-navy text-xs font-bold px-3 py-1 rounded-full">
                                            {{ $university->city }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4 text-center">
                                    <h3 class="font-black text-navy text-sm leading-tight mb-2">
                                        {{ $university->name }}
                                    </h3>
                                    @if($university->description)
                                        <p class="text-gray-500 text-xs line-clamp-2">
                                            {{ $university->description }}
                                        </p>
                                    @endif
                                    <div class="mt-3 inline-flex items-center gap-1 text-xs text-navy font-bold group-hover:gap-2 transition-all">
                                        عرض العقارات
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
        </div>

        {{-- الأسهم خارج الـ swiper --}}
        <div class="swiper-button-prev-uni"></div>
        <div class="swiper-button-next-uni"></div>

    </div>
</section>
