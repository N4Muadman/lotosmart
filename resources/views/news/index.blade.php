@extends('layout')

@section('content')
<div class="bg-gray-50 py-8 px-2">
  <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-6">
    <!-- Sidebar -->
    <aside class="md:col-span-1">
      <div class="bg-white rounded-2xl shadow p-4 mb-6">
        <h2 class="text-lg font-semibold mb-3">Danh mục tin</h2>
        <div>
          <a href="{{ route('news.index') }}"
             class="block w-full text-left px-3 py-2 rounded-xl mb-1 hover:bg-gray-100 {{ request('cat') ? '' : 'bg-blue-100 font-bold' }}">
             Tất cả
          </a>
          @foreach($categories as $cat)
            <a href="{{ route('news.index', ['cat' => $cat->id] + request()->only('search')) }}"
               class="block w-full text-left px-3 py-2 rounded-xl mb-1 hover:bg-gray-100 {{ request('cat') == $cat->id ? 'bg-blue-100 font-bold' : '' }}">
              {{ $cat->name }}
            </a>
          @endforeach
        </div>
      </div>
      <div class="bg-white rounded-2xl shadow p-4">
        <h2 class="text-lg font-semibold mb-3 border-b pb-2">Tin nổi bật</h2>
        @foreach($newsList->take(3) as $item)
          <a href="{{ route('news.show', $item->slug) }}" class="flex items-center gap-3 py-2 border-b last:border-b-0 hover:bg-gray-50 rounded-xl transition">
            <img src="{{ $item->image ? asset('uploads/news/'.$item->image) : 'https://source.unsplash.com/600x400/?news' }}"
                 alt="{{ $item->title }}"
                 class="w-16 h-12 object-cover rounded-xl flex-shrink-0 border" />
            <div class="flex-1">
              <div class="text-sm font-medium leading-tight line-clamp-2">{{ $item->title }}</div>
              <div class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</div>
            </div>
          </a>
        @endforeach
      </div>
    </aside>

    <!-- News list -->
    <main class="md:col-span-3">
      <!-- Search -->
      <form action="{{ route('news.index') }}" method="get" class="flex flex-col md:flex-row items-center gap-4 mb-4">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="Tìm kiếm..."
          class="w-full md:w-1/2 px-4 py-2 rounded-xl border"
        />
        @if(request('cat'))
          <input type="hidden" name="cat" value="{{ request('cat') }}">
        @endif
        <button type="submit"
                class="px-4 py-2 rounded-xl border border-blue-300 bg-blue-50 flex items-center justify-center focus:outline-none">
          <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="7" stroke="currentColor"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-linecap="round"/>
          </svg>
        </button>
      </form>

      <div id="article-list" class="grid md:grid-cols-3 gap-6">
        @forelse($newsList as $a)
          <div class="bg-white rounded-2xl border border-blue-200 p-0 flex flex-col hover:shadow transition">
            <a href="{{ route('news.show', $a->slug) }}">
              <img src="{{ $a->image ? asset('uploads/news/'.$a->image) : 'https://source.unsplash.com/600x400/?news' }}"
                   alt="{{ $a->title }}"
                   class="rounded-t-2xl h-44 w-full object-cover border-b border-blue-100" />
            </a>
            <div class="p-4 flex-1 flex flex-col">
              <div class="text-blue-500 text-xs font-semibold mb-1">
                  {{ $a->category ? $a->category->name : '---' }}
              </div>
              <a href="{{ route('news.show', $a->slug) }}"><h3 class="font-bold text-base my-1 line-clamp-2">{{ $a->title }}</h3></a>
              <p class="text-gray-600 mb-3 line-clamp-2">{{ $a->summary }}</p>
              <div class="mt-auto flex items-center justify-between text-xs text-gray-500">
                <span>
                  <svg class="inline-block w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 10a4 4 0 100-8 4 4 0 000 8zM2 18a8 8 0 0116 0H2z" /></svg>
                  {{ $a->author ?? 'Admin' }}
                </span>
                <span>{{ \Carbon\Carbon::parse($a->created_at)->format('d/m/Y') }}</span>
              </div>
            </div>
          </div>
        @empty
          <div class="col-span-3 text-center py-8 text-gray-400">Không tìm thấy bài viết nào.</div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="mt-6 flex justify-center">
        {{ $newsList->links() }}
      </div>
    </main>
  </div>
</div>
@endsection
