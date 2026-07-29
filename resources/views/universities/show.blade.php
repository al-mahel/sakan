@extends('layouts.app')

@section('title', $university->name . ' | سكن')
@section('meta_description', $university->description ?: 'تفاصيل ' . $university->name . ' والعقارات القريبة منها')

@section('content')

    {{-- Header --}}
    <div class="relative bg-navy text-white overflow-hidden" style="min-height: 320px;">
        @if($university->image)
            <img src="{{ asset('storage/'.$university->image) }}"
                 alt="{{ $university->name }}"
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="relative max-w-7xl mx-auto px-4 py-16">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-navy-200 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition">الرئيسية</a>
                <span>/</span>
                <a href="{{ route('universities.index') }}" class="hover:text-white transition">الجامعات</a>
                <span>/</span>
                <span class="text-white">{{ $university->name }}</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end gap-6">
                <div class="flex-1">
                    <div class="flex flex-wrap gap-2 mb-3">
                    <span class="text-xs font-bold px-3 py-1 rounded-full
                        {{ $university->type === 'حكومية' ? 'bg-green-500' :
                           ($university->type === 'أهلية' ? 'bg-yellow-500' : 'bg-blue-500') }}">
                        {{ $university->type }}
                    </span>
                        <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">
                        {{ $university->city }}
                    </span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-black mb-2">{{ $university->name }}</h1>
                    @if($university->description)
                        <p class="text-navy-200 text-lg max-w-2xl">{{ $university->description }}</p>
                    @endif
                </div>

                <div class="flex flex-col gap-3">
                    @if($university->website)
                        <a href="{{ $university->website }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 bg-white text-navy font-bold
                          px-5 py-3 rounded-xl hover:bg-navy-50 transition shadow">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            الموقع الرسمي
                        </a>
                    @endif
                    <a href="{{ route('properties.index', ['university' => $university->name]) }}"
                       class="inline-flex items-center gap-2 bg-white/20 text-white font-bold
                          px-5 py-3 rounded-xl hover:bg-white/30 transition text-center justify-center">
                        🏠 {{ $relatedProperties->count() }}+ عقار قريب
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="flex flex-col lg:flex-row gap-10">

            {{-- ════════ MAIN ════════ --}}
            <div class="flex-1 min-w-0">

                {{-- Related Properties --}}
                @if($relatedProperties->count())
                    <div class="mb-10">
                        <h2 class="text-xl font-black text-navy mb-5">
                            🏠 عقارات قريبة من {{ $university->name }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($relatedProperties as $property)
                                @include('properties._card', ['property' => $property])
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('properties.index', ['university' => $university->name]) }}"
                               class="btn-outline inline-block text-sm">
                                عرض كل العقارات القريبة
                            </a>
                        </div>
                    </div>
                @endif

                {{-- ════════ COMMENTS ════════ --}}
                <div id="comments">
                    <h2 class="text-xl font-black text-navy mb-2">
                        💬 آراء الطلاب
                        <span class="text-gray-400 font-normal text-base">
                        ({{ $university->comments->count() }})
                    </span>
                    </h2>

                    @if($university->avg_rating > 0)
                        <div class="flex items-center gap-2 mb-5">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-xl {{ $i <= round($university->avg_rating) ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                                @endfor
                            </div>
                            <span class="font-bold text-navy">{{ number_format($university->avg_rating, 1) }}</span>
                            <span class="text-gray-400 text-sm">/ 5</span>
                        </div>
                    @endif

                    {{-- Add Comment --}}
                    @auth
                        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
                            <h3 class="font-bold text-navy mb-4">✍️ شارك رأيك</h3>

                            @if(session('success'))
                                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-3 mb-4 text-sm">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('universities.comments.store', $university) }}" method="POST">
                                @csrf

                                {{-- Rating --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">التقييم</label>
                                    <div class="flex gap-1" x-data="{ rating: 0, hover: 0 }">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button"
                                                    @click="rating = {{ $i }}"
                                                    @mouseenter="hover = {{ $i }}"
                                                    @mouseleave="hover = 0"
                                                    class="text-3xl transition-transform hover:scale-110 focus:outline-none">
                                                <span :class="(hover || rating) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-200'">★</span>
                                            </button>
                                            <input type="hidden" name="rating" :value="rating">
                                        @endfor
                                    </div>
                                </div>

                                <textarea
                                    name="body"
                                    rows="4"
                                    class="search-input resize-none mb-4 @error('body') border-red-400 @enderror"
                                    placeholder="شارك تجربتك مع {{ $university->name }}..."
                                >{{ old('body') }}</textarea>

                                @error('body')
                                <p class="text-red-500 text-xs mb-3">{{ $message }}</p>
                                @enderror

                                <button type="submit" class="btn-primary">
                                    نشر الرأي ✓
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-navy-50 rounded-2xl p-6 mb-6 text-center">
                            <p class="text-navy font-bold mb-3">سجّل دخولك لمشاركة رأيك</p>
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('login') }}" class="btn-primary text-sm">تسجيل الدخول</a>
                                <a href="{{ route('register') }}" class="btn-outline text-sm">إنشاء حساب</a>
                            </div>
                        </div>
                    @endauth

                    {{-- Comments List --}}
                    @if($university->comments->count())
                        <div class="space-y-4">
                            @foreach($university->comments as $comment)
                                <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">

                                    {{-- Comment Header --}}
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-navy rounded-full flex items-center justify-center text-white font-black text-sm shrink-0">
                                                {{ mb_substr($comment->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-navy text-sm">{{ $comment->user->name }}</div>
                                                <div class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                        @if($comment->rating)
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="text-sm {{ $i <= $comment->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                                                @endfor
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Comment Body --}}
                                    <p class="text-gray-700 text-sm leading-relaxed mb-4">
                                        {{ $comment->body }}
                                    </p>

                                    {{-- Replies --}}
                                    @if($comment->replies->count())
                                        <div class="border-r-2 border-navy-100 pr-4 space-y-3 mb-4">
                                            @foreach($comment->replies as $reply)
                                                <div class="flex items-start gap-3">
                                                    <div class="w-8 h-8 bg-navy-100 rounded-full flex items-center justify-center text-navy font-black text-xs shrink-0">
                                                        {{ mb_substr($reply->user->name, 0, 1) }}
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <span class="font-bold text-navy text-xs">{{ $reply->user->name }}</span>
                                                            <span class="text-gray-400 text-xs">{{ $reply->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <p class="text-gray-600 text-sm">{{ $reply->body }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Reply Form --}}
                                    @auth
                                        <div x-data="{ showReply: false }">
                                            <button @click="showReply = !showReply"
                                                    class="text-xs text-navy font-bold hover:underline flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                                </svg>
                                                رد
                                            </button>

                                            <div x-show="showReply" x-transition class="mt-3">
                                                <form action="{{ route('comments.reply', $comment) }}" method="POST">
                                                    @csrf
                                                    <div class="flex gap-2">
                                        <textarea
                                            name="body"
                                            rows="2"
                                            class="search-input resize-none flex-1 text-sm"
                                            placeholder="اكتب ردك..."
                                        ></textarea>
                                                        <button type="submit"
                                                                class="bg-navy text-white px-4 rounded-xl text-sm font-bold hover:bg-navy-800 transition shrink-0">
                                                            إرسال
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endauth

                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-400">
                            <div class="text-5xl mb-3">💬</div>
                            <p>لا توجد آراء بعد — كن أول من يشارك رأيه!</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- ════════ SIDEBAR ════════ --}}
            <aside class="w-full lg:w-72 shrink-0">
                <div class="bg-white rounded-2xl shadow-md p-6 sticky top-24">
                    <h3 class="font-black text-navy mb-4">📊 معلومات الجامعة</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-500">النوع</span>
                            <span class="font-bold text-navy">{{ $university->type }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-500">المدينة</span>
                            <span class="font-bold text-navy">{{ $university->city }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-500">العقارات القريبة</span>
                            <span class="font-bold text-navy">{{ $relatedProperties->count() }}+</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-50">
                            <span class="text-gray-500">آراء الطلاب</span>
                            <span class="font-bold text-navy">{{ $university->comments->count() }}</span>
                        </div>
                        @if($university->avg_rating > 0)
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-500">متوسط التقييم</span>
                                <span class="font-bold text-yellow-500">
                            ★ {{ number_format($university->avg_rating, 1) }}
                        </span>
                            </div>
                        @endif
                    </div>

                    @if($university->website)
                        <a href="{{ $university->website }}" target="_blank" rel="noopener"
                           class="btn-primary w-full text-center mt-5 block text-sm">
                            🌐 الموقع الرسمي
                        </a>
                    @endif

                    <a href="{{ route('properties.index', ['university' => $university->name]) }}"
                       class="btn-outline w-full text-center mt-3 block text-sm">
                        🏠 عرض العقارات القريبة
                    </a>
                </div>
            </aside>

        </div>
    </div>

@endsection
