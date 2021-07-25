<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    {{-- <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
        <span class="c-header-toggler-icon"></span>
    </button> --}}
    <a class="c-header-brand d-sm-none" href="#">
        <img class="c-header-brand" src="{{ url('/images/logo.svg')}}" width="97" height="46" alt="POOF-LOGO">
    </a>
    <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
        <span class="c-header-toggler-icon"></span>
    </button>
    <ul class="c-header-nav ml-auto mr-6">
        <li class="c-header-nav-item mx-2">
            @if (isset($title))
                {{ $title }}
            @endif
        </li>

        <!-- TODO ログイン or 新規登録 or ログインユーザー表示名の表示 -->

        <li class="c-header-nav-item d-sm-none">
            <button class="c-header-toggler c-class-toggler" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                <span class="c-header-toggler-icon"></span>
            </button>
        </li>
        <li class="c-header-nav-item dropdown d-md-down-none">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar">
                    <img class="c-avatar-img" src="{{ url('/assets/img/avatars/6.jpg') }}" alt="user@email.com">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="/logout">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ url('assets/icons/coreui/free.svg#cui-account-logout') }}"></use>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </li>
    </ul>
</header>
