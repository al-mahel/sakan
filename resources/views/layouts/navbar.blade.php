{{-- Navbar --}}
<nav class="bg-navy shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/Skntalaba -02.png') }}" alt="سكن طلاب" class="h-30 w-auto">
            </a>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}"
                   class="text-white hover:text-navy-200 font-medium transition
                              {{ request()->routeIs('home') ? 'border-b-2 border-white pb-1' : '' }}">
                    الرئيسية
                </a>
                <a href="{{ route('properties.index') }}"
                   class="text-white hover:text-navy-200 font-medium transition
                              {{ request()->routeIs('properties.*') ? 'border-b-2 border-white pb-1' : '' }}">
                    العقارات
                </a>
                <a href="{{ route('universities.index') }}"
                   class="text-white hover:text-navy-200 font-medium transition
                        {{ request()->routeIs('universities.*') ? 'border-b-2 border-white pb-1' : '' }}">
                    الجامعات
                </a>
            </div>

            {{-- Auth Links --}}
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 text-white hover:text-navy-200 font-medium transition">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm font-black">
                            {{ mb_substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="hidden md:block">{{ auth()->user()->name }}</span>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}"
                       class="text-white hover:text-navy-200 font-medium transition text-sm">
                        دخول
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-white text-navy font-bold px-4 py-2 rounded-xl text-sm hover:bg-navy-50 transition">
                        إنشاء حساب
                    </a>
                </div>
            @endauth
            {{-- Mobile menu button --}}
            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <a href="{{ route('home') }}"
               class="block text-white py-2 hover:text-navy-200 font-medium">الرئيسية</a>
            <a href="{{ route('properties.index') }}"
               class="block text-white py-2 hover:text-navy-200 font-medium">العقارات</a>
            <a href="{{ route('universities.index') }}"
               class="block text-white py-2 hover:text-navy-200 font-medium">الجامعات</a>

            {{-- Auth Links --}}
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 text-white hover:text-navy-200 font-medium transition">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm font-black">
                            {{ mb_substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="hidden md:block">{{ auth()->user()->name }}</span>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}"
                       class="text-white hover:text-navy-200 font-medium transition text-sm">
                        دخول
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-white text-navy font-bold px-4 py-2 rounded-xl text-sm hover:bg-navy-50 transition">
                        إنشاء حساب
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
