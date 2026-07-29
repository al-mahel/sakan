@extends('layouts.app')

@section('title', 'تسجيل الدخول | سكن')
@section('meta_description', 'سجّل دخولك إلى منصة سكن الطلابية')

@section('content')

    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block">
                    <span class="text-4xl font-black text-navy">سكن</span>
                </a>
                <h1 class="text-xl font-bold text-gray-700 mt-2">أهلاً بعودتك </h1>
                <p class="text-gray-500 text-sm mt-1">سجّل دخولك للمتابعة</p>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-8">

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            البريد الإلكتروني
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="search-input @error('email') border-red-400 @enderror"
                            placeholder="example@email.com"
                            autofocus
                        >
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">
                            كلمة المرور
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="search-input @error('password') border-red-400 @enderror"
                            placeholder="••••••••"
                        >
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember"
                                   class="w-4 h-4 text-navy rounded border-gray-300">
                            <span class="text-sm text-gray-600">تذكرني</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary w-full text-center">
                        تسجيل الدخول
                    </button>

                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-500 text-sm">
                        مش عندك حساب؟
                        <a href="{{ route('register') }}" class="text-navy font-bold hover:underline">
                            سجّل الآن
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>

@endsection
