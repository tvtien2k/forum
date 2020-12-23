<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home">BTEC FORUM</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="posts/new">New Posts</a>
                </li>
                <li>
                    <a href="posts/popular">Popular</a>
                </li>
                @auth
                    <li>
                        <a href="posts/recommended">Recommended</a>
                    </li>
                @endauth
            </ul>
            @include('client.layouts.search')
            <ul class="nav navbar-nav pull-right">
                @auth
                    <li>
                        <a href="redirect">Dashboard</a>
                    </li>
                    <li>
                        <a>
                            <span class="glyphicon glyphicon-user"></span>
                            {{Auth::user()->name}}
                        </a>
                    </li>
                    <li>
                        <form class="navbar-form navbar-left" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-default">Logout</button>
                        </form>
                    </li>
                @endauth
                @guest
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
