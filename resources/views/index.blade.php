@extends('layouts.app')
@section('title', (isset($currentCategory) && $currentCategory ? $currentCategory->name : 'Все товары').' — PAST & PLAY')

@section('content')
    <div class="container px-4 py-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">

                @php
                    $homeUrl   = \Illuminate\Support\Facades\Route::has('home') ? route('home') : url('/');
                    $lastLabel = (isset($currentCategory) && $currentCategory) ? $currentCategory->name : 'Все товары';

                    $crumbs = [
                        ['label' => 'Главная', 'url' => $homeUrl],
                        ['label' => $lastLabel],
                    ];
                @endphp

                @include('partials.breadcrumbs', ['items' => $crumbs])

                @if($products->count())
                    <div class="row">
                        @foreach($products as $p)
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                @include('partials.product-card', ['p' => $p])
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination-wrapper mt-3">
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                @else
                    <div class="alert alert-light border mb-0">Товаров пока нет.</div>
                @endif

            </div>
        </div>
    </div>
    </div>
    <style>
        .pagination-wrapper .pagination{
            --pp-turquoise: var(--turquoise, #59C4C6);
            --pp-turquoise-dark: var(--turquoise-dark, #46a8aa);
            --pp-dark: var(--dark, #2d3748);
            --pp-bg: #fff;

            display:flex; flex-wrap:wrap; justify-content:center;
            gap:.5rem;
            padding:.25rem 0;
            margin: 0;
        }

        .pagination-wrapper .page-item{ margin: 0; }

        .pagination-wrapper .page-link{
            border:0;
            background:var(--pp-bg);
            color:var(--pp-dark);
            font-weight:700;
            padding:.55rem .9rem;
            min-width:42px; text-align:center;
            border-radius:12px !important;
            box-shadow:0 4px 12px rgba(0,0,0,.06);
            transition:background .2s ease, color .2s ease, transform .12s ease, box-shadow .2s ease;
        }

        .pagination-wrapper .page-link:hover{
            background:rgba(89,196,198,.10);
            color:var(--pp-dark);
            transform:translateY(-1px);
            box-shadow:0 8px 18px rgba(0,0,0,.08);
            text-decoration: none;
        }

        .pagination-wrapper .page-item.active .page-link{
            background:var(--pp-turquoise);
            color:#fff;
            box-shadow:0 6px 16px rgba(89,196,198,.35);
        }

        .pagination-wrapper .page-item.disabled .page-link{
            background:#f1f5f9;
            color:#94a3b8;
            box-shadow:none;
        }

        .pagination-wrapper .page-link:focus{
            outline:0;
            box-shadow:0 0 0 .2rem rgba(89,196,198,.25);
        }

        @media (max-width: 575.98px){
            .pagination-wrapper .pagination{ gap:.35rem; }
            .pagination-wrapper .page-link{ min-width:38px; padding:.5rem .75rem; }
        }
    </style>
    <script>
        (function(){
            const LOCK_VALUE = '120px';
            const header = document.querySelector('.header');

            function lock() {
                document.body.style.setProperty('padding-top', LOCK_VALUE, 'important');
            }

            lock();

            new MutationObserver(muts => {
                for (const m of muts) {
                    if (m.type === 'attributes' && m.attributeName === 'style') {
                        lock();
                    }
                }
            }).observe(document.body, { attributes:true, attributeFilter:['style'] });

            if (header) {
                new MutationObserver(() => {
                    header.style.setProperty('margin-bottom', '0px', 'important');
                }).observe(header, { attributes:true, attributeFilter:['style','class'] });
            }

            addEventListener('load', lock, { passive:true });
            addEventListener('resize', lock, { passive:true });
            addEventListener('orientationchange', lock, { passive:true });

            const sheet = document.createElement('style');
            sheet.id = 'pad-hard-override-runtime';
            sheet.textContent =
                `body{padding-top:${LOCK_VALUE}!important}` +
                `@media (max-width:100000px){body{padding-top:${LOCK_VALUE}!important}}` +
                `.header{margin-bottom:0!important}`;
            document.head.appendChild(sheet);
        })();
    </script>

@endsection
