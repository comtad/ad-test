@extends('layouts.app')
@section('title', $product->name.' — PAST & PLAY')

@section('content')
    <div class="container px-4 py-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">

                @php
                    $bc = [['label' => 'Главная', 'url' => route('home')]];
                    if ($product->category) {
                      $bc[] = ['label' => $product->category->name, 'url' => route('category.show', $product->category->slug)];
                    }
                    $bc[] = ['label' => $product->name];
                @endphp

                @include('partials.breadcrumbs', ['items' => $bc])

                <div class="row align-items-stretch">
                    <div class="col-md-6 d-flex">
                        <div class="w-100">
                            @if($product->image)
                                <div class="product-image-container rounded overflow-hidden mb-3">
                                    <img src="{{ asset($product->image) }}" class="img-fluid w-100 product-main-image" alt="{{ $product->name }}">
                                </div>
                            @else
                                <div class="bg-light border rounded d-flex align-items-center justify-content-center mb-3" style="height:360px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 d-flex">
                        <div class="d-flex flex-column w-100 h-100">
                            <h1 class="h3 mb-2 fw-bold product-title">{{ $product->name }}</h1>

                            @if(!is_null($product->price))
                                <div class="h3 mb-4" style="color: var(--peach, #FAC579); font-weight: 800;">
                                    {{ number_format((float)$product->price, 0, ',', ' ') }} ₽
                                </div>
                            @endif

                            @if($product->description)
                                <div class="product-description mb-4">
                                    <h6 class="fw-bold mb-2">Описание</h6>
                                    <div class="text-muted lh-base">{!! nl2br(e($product->description)) !!}</div>
                                </div>
                            @endif

                            <div class="mt-auto mb-3">
                                <button
                                    id="buyBtn-{{ $product->id }}"
                                    class="btn w-100 py-3 shadow-sm"
                                    style="background: var(--lilac,#C07EB2); color:#fff; border-radius:12px; font-size:1.15rem; font-weight:800;"
                                    data-product-id="{{ $product->id }}"
                                    data-cart-btn
                                >
                                    <i class="fas fa-shopping-cart me-2"></i> Добавить в корзину
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .product-image-container{
            position:relative; overflow:hidden; border-radius:12px; background:#f8f9fa; min-height:360px;
        }
        .product-main-image{ transition:transform .3s ease; }
        .product-main-image:hover{ transform:scale(1.03); }
        .product-title{ color:#333; line-height:1.3; }

        #buyBtn-{{ $product->id }}{
            transition: transform .15s ease, box-shadow .2s ease, background .2s ease !important;
            box-shadow: 0 4px 10px rgba(192,126,178,.25) !important;
        }
        #buyBtn-{{ $product->id }}:hover{
            background:#b370a8 !important;
            box-shadow:0 6px 14px rgba(192,126,178,.35) !important;
            color:#fff !important;
            transform:none !important;
            text-decoration:none !important;
        }
        #buyBtn-{{ $product->id }}:active{
            transform:translateY(1px) !important;
        }
        @keyframes addToCart { 0%{transform:scale(1)} 50%{transform:scale(1.06)} 100%{transform:scale(1)} }
        #buyBtn-{{ $product->id }}.added-to-cart{ animation:addToCart .4s ease; }
    </style>
@endsection
