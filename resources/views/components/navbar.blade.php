<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                @if(auth()->check())
                    <span class="m-2 welcome_user">Welcome, {{ auth()->user()->name }}</span>
                    <a class="ml-3" href="{{ route('logout') }}">Logout</a>
                @else
                <button class="btn btn-outline-primary m-4" type="submit">Login</button>
                @endif
            </li>
        </ul>
    </div>
</nav>
