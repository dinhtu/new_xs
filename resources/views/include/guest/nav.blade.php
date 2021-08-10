<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand">
        <img class="c-sidebar-brand-full" src="{{ url('images/logo.png') }}" width="46" height="46" alt="CoreUI Logo">
        <img class="c-sidebar-brand-minimized" src="{{ url('images/logo.png') }}" width="46" height="46" alt="CoreUI Logo">
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/login">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ url('assets/icons/coreui/free.svg#cui-smile-plus') }}"></use>
                </svg>
                ログイン
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/register">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ url('assets/icons/coreui/free.svg#cui-smile-plus') }}"></use>
                </svg>
                新規登録
            </a>
        </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
