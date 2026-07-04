{{-- ═══════════════════════════════════════════ --}}
{{-- ABOUT SAKAN --}}
{{-- ═══════════════════════════════════════════ --}}
<section class="py-16 max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

        <div>
            <span class="badge badge-navy mb-4 inline-block">من نحن</span>
            <h2 class="text-3xl md:text-4xl font-black text-navy mb-6 leading-tight">
                سكن — البيت الحقيقي<br>
                <span class="text-navy-400">لكل طالب في مصر</span>
            </h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                <strong class="text-navy">سكن</strong> هو أكثر من مجرد منصة لإيجاد الشقق —
                هو بيت حقيقي لكل طالب. نؤمن بأن الطالب يستحق بيئة مريحة وآمنة
                تساعده على التفرغ لدراسته وتحقيق أحلامه الأكاديمية.
            </p>
            <p class="text-gray-600 leading-relaxed mb-4">
                بدأنا برؤية بسيطة: ربط الطلاب بسكن مناسب قريب من جامعاتهم.
                لكن سرعان ما تطورنا لنصبح <strong class="text-navy">منصة متكاملة</strong>
                تخدم الطالب في كل جانب من جوانب حياته الجامعية.
            </p>
            <p class="text-gray-600 leading-relaxed mb-6">
                من <strong>تبادل المواد الدراسية</strong> إلى <strong>بيع وشراء مستلزمات السكن</strong>،
                ومن <strong>مشاركة خبرات الكليات</strong> إلى <strong>بناء مجتمع طلابي</strong> نابض —
                سكن هو رفيق رحلتك الجامعية بالكامل.
            </p>

            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="text-center p-4 bg-navy-50 rounded-xl">
                    <div class="text-2xl font-black text-navy">{{ number_format($totalCount) }}+</div>
                    <div class="text-xs text-gray-500">عقار</div>
                </div>
                <div class="text-center p-4 bg-navy-50 rounded-xl">
                    <div class="text-2xl font-black text-navy">{{ $universities->count() }}+</div>
                    <div class="text-xs text-gray-500">جامعة</div>
                </div>
                <div class="text-center p-4 bg-navy-50 rounded-xl">
                    <div class="text-2xl font-black text-navy">{{ $cities->count() }}+</div>
                    <div class="text-xs text-gray-500">مدينة</div>
                </div>
            </div>

            <a href="{{ route('properties.index') }}" class="btn-primary inline-block">
                ابدأ البحث الآن
            </a>
        </div>

        <div class="relative">
            <div class="bg-navy rounded-3xl p-8 text-white">
                <h3 class="text-xl font-black mb-6">لماذا سكن؟</h3>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="shrink-0 text-green-400 mt-0.5">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                        </span>
                        <div>
                            <div class="font-bold mb-1">متخصص في الطلاب</div>
                            <div class="text-navy-200 text-sm">عقارات مختارة بعناية بالقرب من الجامعات</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="shrink-0 text-green-400 mt-0.5">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                        </span>
                        <div>
                            <div class="font-bold mb-1">مجاني تماماً</div>
                            <div class="text-navy-200 text-sm">لا رسوم على البحث أو التواصل</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="shrink-0 text-green-400 mt-0.5">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                        </span>
                        <div>
                            <div class="font-bold mb-1">معلومات تفصيلية</div>
                            <div class="text-navy-200 text-sm">صور حقيقية، أسعار واضحة، خريطة دقيقة</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="shrink-0 text-green-400 mt-0.5">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                        </span>
                        <div>
                            <div class="font-bold mb-1">تواصل مباشر</div>
                            <div class="text-navy-200 text-sm">واتساب وهاتف بدون وسيط</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="shrink-0 text-green-400 mt-0.5">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                        </span>
                        <div>
                            <div class="font-bold mb-1">مجتمع طلابي</div>
                            <div class="text-navy-200 text-sm">تبادل خبرات وتواصل مع زملاء الجامعة</div>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Decorative element --}}
            <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-navy-200 rounded-2xl -z-10"></div>
            <div class="absolute -top-4 -right-4 w-16 h-16 bg-navy-100 rounded-xl -z-10"></div>
        </div>

    </div>
</section>
