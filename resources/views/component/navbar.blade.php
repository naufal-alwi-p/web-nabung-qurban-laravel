<nav class="navbar sticky-top navbar-expand-lg self-bg-1">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">E-Qurban</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul @class(['navbar-nav', 'mb-2', 'mb-lg-0', 'me-lg-5' => Illuminate\Support\Facades\Auth::check(), 'pe-lg-4' => Illuminate\Support\Facades\Auth::check()])>
                <li class="nav-item">
                    <a @class(['nav-link', 'fw-medium', 'active' => Illuminate\Support\Facades\Route::current()->uri() === '/']) aria-current="page" href="/">Home</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a @class(['nav-link', 'fw-medium', 'active' => Illuminate\Support\Facades\Route::current()->uri() === 'user/dashboard']) aria-current="page" href="/user/dashboard">Dashboard</a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="/#cara-kerja">Cara Kerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="/#layanan">Layanan</a>
                </li>
                @auth
                <li class="nav-item fw-medium dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/user/detail">Detail Akun</a></li>
                        <li><form action="/user/logout" method="post">@csrf<button class="dropdown-item text-danger">Logout</button></form></li>
                    </ul>
                </li>
                @endauth
            </ul>
            @guest
                <a class="btn btn-primary mx-lg-1" href="/user/register">Register</a>
                <a class="btn btn-outline-dark mx-lg-1" href="/user/login">Login</a>
            @endguest
        </div>
    </div>
</nav>