@php
    $items = $items ?? [];
    $lastBold = $lastBold ?? (count($items) ? ($items[count($items)-1]['suffix_bold'] ?? null) : null);
@endphp

<nav aria-label="breadcrumb">
    <ol class="breadcrumb pp-breadcrumb mb-10">
        @forelse($items as $item)
            @php
                $label = $item['label'] ?? '';
                $url   = $item['url'] ?? null;
            @endphp

            @if(!$loop->last)
                <li class="breadcrumb-item">
                    @if($url)
                        <a href="{{ $url }}">{{ e($label) }}</a>
                    @else
                        <span>{{ e($label) }}</span>
                    @endif
                </li>
            @else
                @php $suffix = $item['suffix_bold'] ?? $lastBold; @endphp
                <li class="breadcrumb-item active" aria-current="page">
                    <span>{{ e($label) }}</span>
                    @if(!empty($suffix))
                        <strong class="pp-breadcrumb-suffix">{{ $suffix }}</strong>
                    @endif
                </li>
            @endif
        @empty
            <li class="breadcrumb-item active" aria-current="page">…</li>
        @endforelse
    </ol>
</nav>

<style>
    .pp-breadcrumb{
        --bc-peach: var(--peach, #FAC579);
        --bc-text:  var(--dark,  #2d3748);
        background: transparent; border-radius: 0; padding: 0; box-shadow: none;
        font-size: 1rem; display: flex; align-items: center; flex-wrap: wrap;
    }
    .pp-breadcrumb .breadcrumb-item{
        color: var(--bc-text); font-weight: 600; margin: 0; padding: 0;
        display: flex; align-items: center; line-height: 1.2;
    }
    .pp-breadcrumb .breadcrumb-item + .breadcrumb-item{ padding-left: 0; margin-left: 0; }
    .pp-breadcrumb .breadcrumb-item + .breadcrumb-item::before{
        content: "/"; color: var(--bc-text); font-weight: inherit; padding: 0 .5rem; line-height: 1;
    }
    .pp-breadcrumb .breadcrumb-item a{
        color: var(--bc-text); text-decoration: none; padding: 0; border-radius: 6px; transition: color .18s ease;
    }
    .pp-breadcrumb .breadcrumb-item a:hover{ color: var(--bc-text); }
    .pp-breadcrumb .breadcrumb-item.active{ color: var(--bc-peach); font-weight: 600; }
    .pp-breadcrumb .pp-breadcrumb-suffix{ margin-left: .4rem; font-weight: 800; }
</style>
