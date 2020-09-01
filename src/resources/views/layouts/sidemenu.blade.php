{{-- 現在パスの太字化、ルーティング処理 --}}
<div>
    <ul class="nav flex-column pl-3 f_white">
        <li id="loginname" class="nav-item my-2">
            {{-- 現在ログイン中のアカウント名を記載予定20200130 --}}
            <div class="bg-sm-danger bg-sm-light ml-2">{{ __('messages.login') }}：@yield('login_user')</div>
        </li>
        <li class="nav-item ml-2">
            <a class="nav-link" href="/top">{{ __('messages.top') }}</a>
        </li>
        <li>
            <i class="fas fa-user mr-2"></i>{{ __('messages.admin') }}
        </li>
        <li class="nav-item ml-2">
            <a class="nav-link" href="/admin">{{ __('messages.list') }}</a>
        </li>
        <li class="nav-item ml-2">
            <a class="nav-link" href="/admin/create">{{ __('messages.register') }}</a>
        </li>
        <li>
            <i class="fas fa-file-alt mr-2"></i>{{ __('messages.dist') }}
        </li>
        <li class="nav-item ml-2">
            <a class="nav-link" href="/dist/schedules">{{ __('messages.dist_schedule.list') }}</a>
        </li>
        <li class="nav-item ml-2">
            <a class="nav-link" href="/news/create">{{ __('messages.register') }}</a>
        </li>
        <li class="nav-item pb-5">
            <a  id="test"
                class="nav-link" href="{{ route('logout') }}"
                onclick="double_logout();
                event.preventDefault();">
                {{ __('messages.logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}"
            method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
