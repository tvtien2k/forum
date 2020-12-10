<form class="navbar-form navbar-left" role="search" method="get" action="search">
    <div class="form-group">
        <input list="posts" type="text" id="key" name="key" class="form-control" placeholder="Search"
               onkeyup="getPost();">
        <datalist id="posts">
        </datalist>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>

