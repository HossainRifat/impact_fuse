<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
            aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand text-white fs-2 fw-bold" href="#">ImpactFuse</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="page.html">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home.members')}}">Volunteer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home.events')}}">Event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home.blogs')}}">Blog</a>
                </li>
            </ul>
        </div>
    </div>
</nav>