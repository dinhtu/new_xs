<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand">
        <img class="c-sidebar-brand-full" src="{{ url('images/logo.svg') }}" width="118" height="46" alt="CoreUI Logo">
        <img class="c-sidebar-brand-minimized" src="{{ url('images/logo.svg') }}" width="118" height="46" alt="CoreUI Logo">
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('producer.dashboard.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ url('assets/icons/coreui/free.svg#cui-home') }}"></use>
                </svg>
                ダッシュボード
            </a>
        </li>
        
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ url('assets/icons/coreui/free.svg#cui-settings') }}"></use>
                </svg> マイアカウント
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link" href="/logout">
                        <span class="c-sidebar-nav-icon"></span> ログアウト
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
