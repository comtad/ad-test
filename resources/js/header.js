// resources/js/header.js
import $ from 'jquery';

const isDesktop = () => window.matchMedia('(min-width: 992px)').matches;

function bindHover(){
    const $dd = $('.navbar .dropdown');
    $dd.off('.hoverDD');
    if (!isDesktop()) {
        $dd.removeClass('show').children('.dropdown-menu').removeClass('show');
        return;
    }
    $dd.each(function(){
        const $el = $(this); let t;
        $el.on('mouseenter.hoverDD', function(){
            clearTimeout(t);
            $el.addClass('show');
            $el.children('.dropdown-toggle').attr('aria-expanded', true);
            $el.children('.dropdown-menu').addClass('show');
        });
        $el.on('mouseleave.hoverDD', function(){
            t = setTimeout(function(){
                $el.removeClass('show');
                $el.children('.dropdown-toggle').attr('aria-expanded', false);
                $el.children('.dropdown-menu').removeClass('show');
            }, 120);
        });
    });
}

$(() => {
    bindHover();
    $(window).on('resize.header', bindHover);

    const $menu   = $('#mainNav');
    const $toggle = $('#menuToggle');

    function openMenu(){
        if (isDesktop()) return;
        $menu.addClass('open');
        $toggle.attr('aria-expanded', true);
        $('body').addClass('offcanvas-open');
    }
    function closeMenu(){
        $menu.removeClass('open');
        $toggle.attr('aria-expanded', false);
        $('body').removeClass('offcanvas-open');
        $('#mainNav .dropdown-menu.show').removeClass('show');
    }

    $toggle.on('click.header', () => $menu.hasClass('open') ? closeMenu() : openMenu());
    $('.close-menu').on('click.header', closeMenu);

    $('#mainNav .nav-link').on('click.header', function(){
        if (!isDesktop() && !$(this).hasClass('dropdown-toggle')) closeMenu();
    });

    $(document).on('keydown.header', e => { if (e.key === 'Escape') closeMenu(); });
    $(window).on('resize.header', () => { if (isDesktop()) closeMenu(); });

    const $catalogLink = $('#catalogLink');
    if ($catalogLink.length) {
        const $catalogMenu = $catalogLink.next('.dropdown-menu');
        $catalogLink.on('click.header', function(e){
            if (!isDesktop()) {
                e.preventDefault();
                const open = $catalogMenu.hasClass('show');
                $catalogMenu.toggleClass('show', !open);
                $catalogLink.attr('aria-expanded', String(!open));
                return false;
            }
        });
    }

    // свайп справа→налево для закрытия (мобилка)
    let startX = null, swiping = false;
    $menu.on('touchstart.header', e => {
        if (!e.originalEvent.touches) return;
        startX = e.originalEvent.touches[0].clientX; swiping = true;
    });
    $menu.on('touchmove.header',  e => {
        if (!swiping || startX === null || !e.originalEvent.touches) return;
        const dx = e.originalEvent.touches[0].clientX - startX;
        if (dx < -80) { swiping = false; closeMenu(); }
    });
    $menu.on('touchend.header touchcancel.header', () => { startX = null; swiping = false; });
});

