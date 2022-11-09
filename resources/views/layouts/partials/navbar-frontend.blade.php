<nav class="main-header navbar navbar-expand-md navbar-dark navbar-primary">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset(config('backend.preloader')) }}" alt="{{ config('app.name') }}"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('frontend.patients.index') }}" class="nav-link">Patients</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('frontend.symptoms.index') }}" class="nav-link">Symptoms</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('frontend.vaccines.index') }}" class="nav-link">Vaccines</a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('frontend.patients.apply') }}" class="nav-link">Apply</a>
                </li>
            </ul>

            {{--    <form class="form-inline ml-0 ml-md-3">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                               aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            --}}
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <a href="{{ route('auth.login') }}" class="nav-link">Login</a>
            </li>
        </ul>
    </div>
</nav>