@extends('layouts.app')

@section('title', 'إنشاء حساب | سكن')
@section('meta_description', 'انضم لمنصة سكن الطلابية وابدأ رحلتك الجامعية')

@section('content')

    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <span class="text-4xl font-black text-navy">سكن</span>
                </a>
                <h1 class="text-xl font-bold text-gray-700 mt-2">انضم لمجتمع سكن </h1>
                <p class="text-gray-500 text-sm mt-1">أنشئ حسابك مجاناً</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-8">

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            الاسم الكامل <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="search-input @error('name') border-red-400 @enderror"
                            placeholder="اسمك الكامل"
                            autofocus
                        >
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            البريد الإلكتروني <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="search-input @error('email') border-red-400 @enderror"
                            placeholder="example@email.com"
                        >
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            كلمة المرور <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="search-input @error('password') border-red-400 @enderror"
                            placeholder="8 أحرف على الأقل"
                        >
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            تأكيد كلمة المرور <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="search-input"
                            placeholder="أعد كتابة كلمة المرور"
                        >
                    </div>

                    <button type="submit" class="btn-primary w-full text-center">
                        إنشاء الحساب
                    </button>

                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-500 text-sm">
                        عندك حساب بالفعل؟
                        <a href="{{ route('login') }}" class="text-navy font-bold hover:underline">
                            سجّل دخولك
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>

@endsection
