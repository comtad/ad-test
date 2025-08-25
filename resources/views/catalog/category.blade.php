@extends('layouts.app')
@section('title', $currentCategory->name.' — PAST & PLAY')

@section('content')
    <div class="container px-4 py-3">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $currentCategory->name }}</li>
            </ol>
        </nav>

        @if($products->count())
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                @foreach($products as $p)
                    <div class="col">
                        @include('partials.product-card', ['p' => $p])
                    </div>
                @endforeach
            </div>
            <div class="pagination-wrapper mt-4">
                {{ $products->onEachSide(1)->links() }}
            </div>
        @else
            <div class="alert alert-light border">В этой категории пока пусто.</div>
        @endif
    </div>
@endsection
