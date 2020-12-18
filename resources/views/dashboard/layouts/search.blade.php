<form method="get" action="search">
    <div class="input-group custom-search-form">
        <input list="posts" type="text" id="key" name="key" class="form-control" placeholder="Search..."
               onkeyup="getPost();">
        <datalist id="posts">
        </datalist>
        <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </span>
    </div>
</form>
