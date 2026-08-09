{{-- Footer --}}
<footer class="relative bg-[#172F4F] text-white border-t border-[#315A88]/70">

    {{-- Subtle top highlight --}}
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#4A78A8] to-transparent"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">

        {{-- Footer Main Content --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 lg:gap-16">

            {{-- Sakan --}}
            <div>
                <h3 class="text-2xl font-black mb-3 text-white">
                    سكن
                </h3>

                <p class="text-[#AFC1D6] text-sm leading-relaxed max-w-sm">
                    منصتك الموثوقة للبحث عن العقارات والشقق والغرف في مصر.
                </p>
            </div>


            {{-- Quick Links --}}
            <div>
                <h4 class="font-bold mb-4 text-lg text-white">
                    روابط سريعة
                </h4>

                <ul class="space-y-2.5 text-[#AFC1D6] text-sm">

                    <li>
                        <a
                            href="{{ route('home') }}"
                            class="hover:text-white hover:translate-x-1 inline-block transition-all duration-200"
                        >
                            الرئيسية
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('properties.index') }}"
                            class="hover:text-white hover:translate-x-1 inline-block transition-all duration-200"
                        >
                            كل العقارات
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('universities.index') }}"
                            class="hover:text-white hover:translate-x-1 inline-block transition-all duration-200"
                        >
                            كل الجامعات
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('properties.index', ['type' => 'شقة']) }}"
                            class="hover:text-white hover:translate-x-1 inline-block transition-all duration-200"
                        >
                            الشقق
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('properties.index', ['type' => 'غرفة']) }}"
                            class="hover:text-white hover:translate-x-1 inline-block transition-all duration-200"
                        >
                            الغرف
                        </a>
                    </li>

                </ul>
            </div>


            {{-- Contact --}}
            <div>
                <h4 class="font-bold mb-4 text-lg text-white">
                    تواصل معنا
                </h4>

                <div class="space-y-3 text-sm">

                    <a
                        href="mailto:info@sakan.com"
                        class="flex items-center gap-3 text-[#AFC1D6] hover:text-white transition-colors"
                    >
                        <span
                            class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#10243D] border border-[#294B72]"
                        >
                            <svg
                                width="15"
                                height="15"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="text-[#4B91E8]"
                            >
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                        </span>

                        info@sakan.com
                    </a>

                </div>
            </div>

        </div>


        {{-- Footer Bottom --}}
        <div class="mt-12 pt-6 border-t border-[#294B72]/70">

            <div class="flex flex-col xl:flex-row items-center justify-between gap-6">

                {{-- Copyright --}}
                <p class="text-[#8FA8C2] text-[11px] sm:text-xs font-medium text-center order-2 xl:order-1">
                    سكن — جميع الحقوق محفوظة © {{ date('Y') }}
                </p>


                {{-- Developer & Contact --}}
                <div
                    class="inline-flex flex-wrap items-center justify-center gap-3 md:gap-4
                           px-6 py-3
                           rounded-full
                           border border-[#294B72]
                           bg-[#10243D]
                           shadow-[0_4px_20px_rgba(0,0,0,0.12)]
                           text-sm text-[#8FA8C2]
                           order-1 xl:order-2"
                    dir="ltr"
                >

                    <span>
                        Designed &amp; Developed by
                    </span>


                    {{-- RoQix --}}
                    <div class="flex items-center gap-2 text-white font-semibold text-lg">

                        <div class="w-1.5 h-1.5 rounded-full bg-[#3B82F6]"></div>

                        RoQix Tech

                    </div>


                    <span class="text-[#294B72] hidden md:block">
                        |
                    </span>


                    {{-- Email --}}
                    <a
                        href="mailto:info@roqixtech.com"
                        class="flex items-center gap-2 text-[#AFC1D6] hover:text-white transition-colors"
                    >

                        <svg
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-[#3B82F6]"
                        >
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </svg>

                        info@roqixtech.com

                    </a>


                    <span class="text-[#294B72] hidden md:block">
                        |
                    </span>


                    {{-- Phone --}}
                    <a
                        href="tel:+201108787979"
                        class="flex items-center gap-2 text-[#AFC1D6] hover:text-white transition-colors"
                    >

                        <svg
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-[#3B82F6]"
                        >
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>

                        <span dir="ltr">
                            +20 11 08787979
                        </span>

                    </a>

                </div>

            </div>

        </div>

    </div>

</footer>
