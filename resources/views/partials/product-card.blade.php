@php
    $link   = route('products.show', $p->slug);
    $imgUrl = $p->image ? asset($p->image) : null;
@endphp

<style>
    .product-card-{{ $p->id }}{
        border:none;border-radius:12px;overflow:hidden;background:#fff;
        box-shadow:0 4px 15px rgba(0,0,0,.08);
        transition:transform .3s ease, box-shadow .3s ease; margin-bottom:18px;
    }
    .product-card-{{ $p->id }}:hover{ transform:translateY(-4px); box-shadow:0 10px 24px rgba(0,0,0,.14) }

    .product-image-wrap-{{ $p->id }}{
        height:260px; position:relative; overflow:hidden;
        display:flex; align-items:center; justify-content:center;
        background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%);
    }
    .product-image-wrap-{{ $p->id }}::before{
        content:""; position:absolute; inset:-10%;
        background-image: var(--img);
        background-size: cover; background-position: center;
        filter: blur(28px) saturate(1.2);
        opacity:.55; transform: scale(1.12);
        z-index:0;
    }
    .product-image-{{ $p->id }}{
        position:relative; z-index:1;
        max-height:100%; width:auto; object-fit:cover; transition:transform .45s ease
    }
    .product-card-{{ $p->id }}:hover .product-image-{{ $p->id }}{ transform:scale(1.05) }

    .title-link-{{ $p->id }}{ text-decoration:none; color:#2d3748 }
    .title-link-{{ $p->id }}:hover{ color:#4a5568; text-decoration:none }

    .title-{{ $p->id }}{
        font-weight:600;
        font-size:1.15rem;
        line-height:1.25;
        margin:0 0 8px 0;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .price-{{ $p->id }}{
        font-weight:800;
        font-size:1.4rem;
        line-height:1.1;
        color:var(--peach,#FAC579);
        letter-spacing:-.4px;
        margin-bottom:28px;
        font-variant-numeric: tabular-nums;
    }

    .buy-{{ $p->id }}{ margin-top:auto }

    .btn-cart-{{ $p->id }}{
        display:inline-flex; align-items:center; justify-content:center; width:100%;
        border:none; border-radius:10px; padding:10px 18px; font-weight:700; font-size:1rem;
        background:var(--lilac,#C07EB2); color:#fff;
        transition:transform .15s ease, box-shadow .2s ease, background .2s ease;
        box-shadow:0 4px 10px rgba(192,126,178,.25);
    }
    .btn-cart-{{ $p->id }} i{ margin-right:.5rem }
    .btn-cart-{{ $p->id }}:hover{ background:#b370a8; box-shadow:0 6px 14px rgba(192,126,178,.35); color:#fff }
    .btn-cart-{{ $p->id }}:active{ transform:translateY(1px) }

    .no-image-{{ $p->id }}{ position:relative; z-index:1; color:#cbd5e0; font-size:3.2rem }
</style>

<div class="card h-100 product-card-{{ $p->id }}">
    <a href="{{ $link }}">
        <div class="product-image-wrap-{{ $p->id }}" @if($imgUrl) style="--img:url('{{ $imgUrl }}')" @endif>
            @if($imgUrl)
                <img src="{{ $imgUrl }}" class="product-image-{{ $p->id }}" alt="{{ e($p->name) }}">
            @else
                <div class="no-image-{{ $p->id }}"><i class="fas fa-image"></i></div>
            @endif
        </div>
    </a>

    <div class="card-body d-flex flex-column">
        <a href="{{ $link }}" class="title-link-{{ $p->id }}">
            <h6 class="title-{{ $p->id }}">{{ $p->name }}</h6>
        </a>

        <div class="buy-{{ $p->id }}">
            @if(!is_null($p->price))
                <div class="price-{{ $p->id }}">{{ number_format((float)$p->price, 0, ',', ' ') }} ₽</div>
            @else
                <div class="price-{{ $p->id }} text-muted" style="color:#a0aec0!important">Цена не указана</div>
            @endif

            <button
                type="button"
                class="btn btn-cart-{{ $p->id }}"
                data-cart-btn
            >
                <i class="fas fa-shopping-cart"></i> В корзину
            </button>
        </div>
    </div>
</div>
