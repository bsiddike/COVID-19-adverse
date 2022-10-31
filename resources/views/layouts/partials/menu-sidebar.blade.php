<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset(\App\Supports\Constant::USER_PROFILE_IMAGE) }}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">
            <strong>{{ config('backend.sidebar') }}</strong>
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 d-flex border-bottom-0">
            <div class="image">
                <img src="{{ Auth::user()->getFirstMediaUrl('avatars') }}" class="img-circle elevation-2"
                     alt="{{ Auth::user()->name }}">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @can('backend.dashboard')
                    <li class="nav-item">
                        <a href="{{ route('backend.dashboard') }}"
                           class="nav-link  @if(Route::is('backend.dashboard')) active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>{!! __('menu-sidebar.Dashboard') !!}</p>
                        </a>
                    </li>
                @endcan

                @canany(['backend.organization.patients.index', 'backend.organization.symptoms.index'])
                    <li class="nav-item @if(Route::is('backend.organization.*')) menu-open @endif">
                        <a href="#" class="nav-link @if(Route::is('backend.organization.*')) active @endif">
                            <i class="nav-icon fas fa-building"></i>
                            <p> {!! __('menu-sidebar.Organization') !!}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            @if(Route::is('backend.organization.*')) style="display: block;" @endif>

                            @can('backend.organization.patients.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.organization.patients.index') }}"
                                       class="nav-link @if(Route::is('backend.organization.patients.*')) active @endif">
                                        <i class="fas fa-user-nurse nav-icon"></i>
                                        <p>Patients</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.organization.symptoms.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.organization.symptoms.index') }}"
                                       class="nav-link @if(Route::is('backend.organization.symptoms.*')) active @endif">
                                        <i class="fas fa-viruses nav-icon"></i>
                                        <p>Symptoms</p>
                                    </a>
                                </li>
                            @endcan
                                @can('backend.organization.vaccines.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.organization.vaccines.index') }}"
                                       class="nav-link @if(Route::is('backend.organization.vaccines.*')) active @endif">
                                        <i class="fas fa-first-aid nav-icon"></i>
                                        <p>Vaccines</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @canany([
    'backend.settings.users.index',
    'backend.settings.roles.index',
    'backend.settings.permissions.index'])
                    <li class="nav-item @if(Route::is('backend.settings.*')) menu-open @endif">
                        <a href="#" class="nav-link @if(Route::is('backend.settings.*')) active @endif">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>{!! __('menu-sidebar.Settings') !!}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview"
                            @if(Route::is('backend.settings.*')) style="display: block;" @endif>
                            @can('backend.settings.users.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.settings.users.index') }}"
                                       class="nav-link @if(Route::is('backend.settings.users.*')) active @endif">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Users') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.settings.roles.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.settings.roles.index') }}"
                                       class="nav-link @if(Route::is('backend.settings.roles.*')) active @endif">
                                        <i class="fas fa-address-card nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Roles') !!}</p>
                                    </a>
                                </li>
                            @endcan

                            @can('backend.settings.permissions.index')
                                <li class="nav-item">
                                    <a href="{{ route('backend.settings.permissions.index') }}"
                                       class="nav-link @if(\Route::is('backend.settings.permissions.*')) active @endif">
                                        <i class="fas fa-list-alt nav-icon"></i>
                                        <p>{!! __('menu-sidebar.Permissions') !!}</p>
                                    </a>
                                </li>
                                @endcan
                                </li>
                            @endcan
                        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- /.main-sidebar -->
