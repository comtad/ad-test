@php
    $currentCategory = $currentCategory ?? null;
    $categories      = $categories ?? [];
@endphp

<header class="header">
    <div class="topbar">
        <div class="container d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center flex-wrap">
                <div class="contact-item mr-3">
                    <span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span class="d-none d-md-inline">Москва</span>
                </div>
                <div class="sep d-none d-sm-block"></div>
                <a href="tel:88005553535" class="contact-item">
                    <span class="contact-icon"><i class="fas fa-phone"></i></span>
                    <span>8-800-555-35-35</span>
                </a>
            </div>
            <div class="d-flex align-items-center">
                <a href="#" class="contact-item mr-3">
                    <span class="contact-icon"><i class="fas fa-user"></i></span>
                    <span class="d-none d-md-inline">Войти</span>
                </a>
                <a href="#" class="contact-item">
                    <span class="contact-icon"><i class="fas fa-heart"></i></span>
                    <span class="d-none d-md-inline">Избранное</span>
                </a>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-light navbar-expand-lg">
        <div class="container d-flex align-items-center">
            <button id="menuToggle" class="navbar-toggler d-lg-none" type="button"
                    aria-controls="mainNav" aria-expanded="false" aria-label="Меню">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand brand order-lg-1" href="{{ url('/') }}">
                <div class="logo-mark"><span>P</span></div>
                <div class="logo-text">
                    <span class="logo-main">PAST & PLAY</span>
                    <span class="logo-sub">Vintage Collection</span>
                </div>
            </a>

            <div id="mainNav" class="navbar-collapse ml-lg-3 mr-lg-auto">
                <button class="close-menu d-lg-none" aria-label="Закрыть меню"><i class="fas fa-times"></i></button>

                @php
                    $homeUrl = \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/');
                    $categoryUrl = function($cat) {
                        return \Illuminate\Support\Facades\Route::has('category.show')
                            ? route('category.show', $cat->slug)
                            : url('/category/'.$cat->slug);
                    };
                    $isCatalogActive = request()->is('category/*') || request()->is('catalog');
                @endphp

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ $homeUrl }}">Главная</a>
                    </li>

                    <li class="nav-item dropdown {{ $isCatalogActive ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="catalogLink" data-toggle="dropdown" aria-expanded="false">
                            Каталог
                        </a>
                        <div class="dropdown-menu" aria-labelledby="catalogLink">
                            @forelse($categories as $cat)
                                <a class="dropdown-item {{ optional($currentCategory)->id === $cat->id ? 'is-current' : '' }}"
                                   href="{{ $categoryUrl($cat) }}">
                                    {{ $cat->name }}
                                </a>
                            @empty
                                <span class="dropdown-item text-muted small">Нет категорий</span>
                            @endforelse

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ $homeUrl }}">Все товары</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">О нас</a>
                    </li>
                </ul>

                <div class="mobile-auth d-lg-none mt-4 pt-4 border-top">
                    <a href="#" class="d-block py-2 text-dark"><i class="fas fa-user mr-2"></i> Войти</a>
                    <a href="#" class="d-block py-2 text-dark"><i class="fas fa-heart mr-2"></i> Избранное</a>
                </div>
            </div>

            <div class="cart-btn-wrapper ml-2 ml-md-3">
                <button class="btn cart-btn">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    <span class="d-none d-md-inline">Корзина</span>
                    <span class="cart-count">3</span>
                </button>
            </div>
        </div>
    </nav>
</header>
