<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                @include('dashboard.layouts.search')
            </li>
            <li>
                <a href="member/dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="member/recently"><i class="fa fa-clock-o fa-fw"></i> Recently</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-table fa-fw"></i> Manage Post<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="member/post/list">My Post</a>
                    </li>
                    <li>
                        <a href="member/post/add">Add Post</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-user fa-fw"></i> Account<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="member/account/profile">User Profile</a>
                    </li>
                    <li>
                        <a href="member/account/security">Security</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
        </ul>
    </div>
</div>
