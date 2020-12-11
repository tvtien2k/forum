<ul class="nav navbar-right navbar-top-links">
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> {{Auth::user()->name}} <b class="caret"></b>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="member/account/profile"><i class="fa fa-user fa-fw"></i> User Profile</a>
            </li>
            <li><a href="member/account/security"><i class="fa fa-lock fa-fw"></i> Security</a>
            </li>
            <li class="divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div style="text-align: center;">
                        <button type="submit" class="btn btn-default">Logout</button>
                    </div>
                </form>
            </li>
        </ul>
    </li>
</ul>
