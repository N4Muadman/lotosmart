@extends('layout')

@section('content')
<div class="bg-[#ddeceb] min-h-screen py-8">
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 px-2">

    {{-- Main content --}}
    <div class="lg:col-span-9">
      {{-- Breadcrumb --}}
      <nav class="text-gray-500 text-sm mb-4">
        <a href="{{ route('home') }}" class="hover:underline">Trang chủ</a>
        <span class="mx-1">›</span>
        <a href="{{ route('news.index') }}" class="hover:underline">Tin tức</a>
        <span class="mx-1">›</span>
        <span class="text-blue-900 font-semibold">{{ $news->title }}</span>
      </nav>
      <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3 leading-tight">{{ $news->title }}</h1>
      <div class="mb-4 text-gray-600 text-base">
        @if($news->author)
          &nbsp;|&nbsp;<span class="font-medium">{{ $news->author }}</span>
        @endif
      </div>
      @if($news->summary)
        <div class="mb-4 text-lg text-gray-700 font-medium">{{ $news->summary }}</div>
      @endif
      @if($news->image)
        <img src="{{ asset('uploads/news/'.$news->image) }}" class="w-full rounded-xl shadow mb-6 object-cover max-h-[400px]">
      @endif
      <div class="prose max-w-none text-gray-800 text-lg leading-relaxed mb-8">
        {!! $news->content !!}
      </div>
      <a href="{{ route('news.index') }}" class="inline-block mt-2 text-blue-700 hover:underline font-semibold">
        ← Quay lại trang tin tức
      </a>
    </div>

    {{-- Related news sidebar --}}
    <aside class="lg:col-span-3 mt-12 lg:mt-0">
      <div class="bg-white rounded-2xl p-5 shadow-md">
        <h2 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Tin liên quan</h2>
        @php
          $related = $relatedNews ?? \App\Models\News::where('id', '!=', $news->id)->latest()->take(4)->get();
        @endphp
        @foreach($related as $item)
          <div class="mb-6 last:mb-0 bg-[#ddeceb] rounded-xl p-3 hover:shadow transition">
            <a href="{{ route('news.show', $item->slug) }}">
              <img src="{{ $item->image ? asset('uploads/news/'.$item->image) : 'https://source.unsplash.com/400x250/?news' }}"
                   class="w-full h-32 object-cover rounded-xl mb-2">
            </a>
            <div class="flex items-center text-xs text-gray-500 mb-2">
              <span class="mr-2">
                <svg class="inline w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 10a4 4 0 100-8 4 4 0 000 8zM2 18a8 8 0 0116 0H2z" /></svg>
                {{ $item->author ?? 'Admin' }}
              </span>
              <span>
                {{ \Carbon\Carbon::parse($item->created_at ?? $item->date)->format('d-m-Y') }}
              </span>
            </div>
            <a href="{{ route('news.show', $item->slug) }}" class="block font-semibold text-base text-gray-800 leading-tight mb-1 line-clamp-2">
              {{ $item->title }}
            </a>

          </div>
        @endforeach
      </div>
    </aside>
  </div>
</div>
@endsection
