@extends('layouts.app')

@section('title', 'الجامعات | سكن')
@section('meta_description', 'تصفح كل الجامعات المصرية وابحث عن سكن قريب منها')

@section('content')

    <div class="bg-navy text-white py-10">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-3xl font-black mb-1">🎓 الجامعات</h1>
            <p class="text-navy-200">{{ $universities->total() }} جامعة مسجلة</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- Filter by type --}}
        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('universities.index') }}"
               class="px-4 py-2 rounded-xl text-sm font-bold border-2 transition
                  {{ !request('type') ? 'bg-navy text-white border-navy' : 'border-gray-200 text-gray-600 hover:border-navy' }}">
                الكل
            </a>
            @foreach(['حكومية', 'أهلية', 'خاصة'] as $type)
                <a href="{{ route('universities.index', ['type' => $type]) }}"
                   class="px-4 py-2 rounded-xl text-sm font-bold border-2 transition
                  {{ request('type') === $type ? 'bg-navy text-white border-navy' : 'border-gray-200 text-gray-600 hover:border-navy' }}">
                    {{ $type }}
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($universities as $university)
                <a href="{{ route('universities.show', $university) }}"
                   class="group bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">

                    <div class="relative overflow-hidden h-44">
                        <img
                            src="{{ $university->image ? asset('storage/'.$university->image) : asset('images/university-placeholder.webp') }}"
                            alt="{{ $university->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-navy/40 group-hover:bg-navy/30 transition"></div>
                        <div class="absolute top-3 left-3">
                    <span class="text-xs font-bold px-2 py-1 rounded-full
                        {{ $university->type === 'حكومية' ? 'bg-green-500 text-white' :
                           ($university->type === 'أهلية' ? 'bg-yellow-500 text-white' : 'bg-blue-500 text-white') }}">
                        {{ $university->type }}
                    </span>
                        </div>
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
                            <p class="text-gray-500 text-xs line-clamp-2 mb-3">
                                {{ $university->description }}
                            </p>
                        @endif
                        <div class="flex items-center justify-center gap-3 text-xs text-gray-400">
                            <span>🏠 {{ $university->properties_count }} عقار</span>
                            @if($university->comments_count ?? 0)
                                <span>💬 {{ $university->comments_count }} رأي</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10 flex justify-center">
            {{ $universities->links() }}
        </div>
    </div>

@endsection
