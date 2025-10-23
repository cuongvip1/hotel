@extends('layouts.app')
@section('title', 'Danh sách bài đăng')
@section('content')
    <form method="get" class="grid">
        <div class="grid">
            <label>Giá từ (₫)<input type="number" name="min" value="{{ $filters['min'] ?? '' }}"></label>
            <label>Đến (₫)<input type="number" name="max" value="{{ $filters['max'] ?? '' }}"></label>
        </div>
        <button>Lọc</button>
    </form>

    <div class="grid" style="grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px">
        @foreach($data['data'] as $item)
            <article class="card">
                <img src="{{ $item['anh'][0]['url'] ?? '/placeholder.jpg' }}" alt=""
                    style="height:160px;object-fit:cover;width:100%">
                <div class="container">
                    <h5 class="contrast">{{ $item['tieu_de'] }}</h5>
                    <p>{{ \Illuminate\Support\Str::limit($item['mo_ta'], 80) }}</p>
                    <strong>{{ number_format($item['gia_niem_yet'], 0, ',', '.') }}₫</strong>
                    <footer><a href="/bai-dang/{{ $item['id'] }}">Xem chi tiết</a></footer>
                </div>
            </article>
        @endforeach
    </div>

    <nav aria-label="Pagination" class="grid" style="grid-auto-flow:column;justify-content:center;margin-top:16px">
        @if($data['prev_page_url'])
            <a href="{{ $data['prev_page_url'] }}">« Trước</a>
        @endif
        <span>Trang {{ $data['current_page'] }} / {{ $data['last_page'] }}</span>
        @if($data['next_page_url'])
            <a href="{{ $data['next_page_url'] }}">Sau »</a>
        @endif
    </nav>
@endsection