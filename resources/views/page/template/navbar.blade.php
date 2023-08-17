<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">

        <form action="{{ url('logout/post') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm">
                <i class="far fa-user"></i>&nbsp;&nbsp; Logout
                <!-- <span class="badge badge-danger navbar-badge">3</span> -->
            </button>
        </form>
        </li>
    </ul>
</nav>
