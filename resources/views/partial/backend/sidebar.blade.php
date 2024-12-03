<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.index') }}" class="sidebar-brand">
            {{ __('panel.univercity') }} <span> {{ __('panel.ibb') }}</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">{{ __('panel.menu') }}</li>

            @foreach ($admin_side_menu as $menu)
                @if (count($menu->appearedChildren) == 0)
                    <li class="nav-item">
                        <a href="{{ route('admin.' . $menu->as) }}" class="nav-link">
                            <i class="{{ $menu->icon != null ? $menu->icon : 'fas fa-home' }}"></i>
                            {{-- <span class="link-title">{{ $menu->display_name }}</span> --}}

                            <span class="link-title">
                                {{ \Illuminate\Support\Str::limit($menu->display_name, 25) }}
                            </span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#{{ $menu->name }}" role="button"
                            aria-expanded="false" aria-controls="{{ $menu->name }}">
                            <i class="{{ $menu->icon != null ? $menu->icon : 'fas fa-home' }}"></i>
                            {{-- <span class="link-title">{{ $menu->display_name }}</span> --}}
                            <span class="link-title">
                                {{ \Illuminate\Support\Str::limit($menu->display_name, 18) }}
                            </span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        @if ($menu->appearedChildren !== null && count($menu->appearedChildren) > 0)
                            <div class="collapse" id="{{ $menu->name }}">
                                <ul class="nav sub-menu">
                                    @foreach ($menu->appearedChildren as $sub_menu)
                                        <li class="nav-item">
                                            <a href="{{ route('admin.' . $sub_menu->as) }}" class="nav-link">
                                                {{-- {{ $sub_menu->display_name }} --}}
                                                {{ \Illuminate\Support\Str::limit($sub_menu->display_name, 25) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endif
            @endforeach

        </ul>
    </div>
</nav>
<nav class="settings-sidebar">
    <div class="sidebar-body">
        <a href="#" class="settings-sidebar-toggler">
            <i data-feather="settings"></i>
        </a>
        <h6 class="text-muted mb-2">Sidebar:</h6>
        <div class="mb-3 pb-3 border-bottom">
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight"
                    value="sidebar-light">
                <label class="form-check-label" for="sidebarLight">
                    Light
                </label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark"
                    value="sidebar-dark" checked>
                <label class="form-check-label" for="sidebarDark">
                    Dark
                </label>
            </div>
        </div>
        <div class="theme-wrapper">
            <h6 class="text-muted mb-2">{{ __('panel.light_theme') }}:</h6>
            <label for="light-mode-switch"
                class="form-check-label theme-item {{ Cookie::get('theme') == 'light' ? 'active' : '' }}">
                <img src="{{ asset('backend/images/screenshots/light.jpg') }}" alt="light theme">
            </label>



            <div class="form-check form-switch " style="display: none !important;">
                <form action="{{ route('admin.create_update_theme') }}" method="post">
                    @csrf
                    <input class="form-check-input theme-choice" name="theme_choice" value="light" type="checkbox"
                        id="light-mode-switch" onchange="this.form.submit();"
                        {{ Cookie::get('theme') == 'light' ? 'checked , disabled' : '' }}>

                    {{-- <label class="form-check-label" for="light-mode-switch"> {{ __('panel.light_theme') }} </label> --}}
                </form>
            </div>

            <h6 class="text-muted mb-2">{{ __('panel.dark_theme') }}:</h6>
            <label for="dark-mode-switch"
                class="form-check-label theme-item {{ Cookie::get('theme') != null ? (Cookie::get('theme') == 'dark' ? 'active' : '') : 'active' }}">
                <img src="{{ asset('backend/images/screenshots/dark.jpg') }}" alt="light theme">
            </label>

            <div class="form-check form-switch " style="display: none !important;">
                <form action="{{ route('admin.create_update_theme') }}" method="post">
                    @csrf
                    <input class="form-check-input theme-choice" name="theme_choice" value="dark" type="checkbox"
                        id="dark-mode-switch" onchange="this.form.submit();"
                        {{ Cookie::get('theme') != null ? (Cookie::get('theme') == 'dark' ? 'checked , disabled' : '') : 'checked , disabled' }}>
                    <label class="form-check-label" for="dark-mode-switch">{{ __('panel.dark_theme') }} </label>
                </form>
            </div>
        </div>
    </div>
</nav>
