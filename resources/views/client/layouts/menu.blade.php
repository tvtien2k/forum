<ul class="list-group" id="menu">
    <li href="#" class="list-group-item menu1 active">
        Menu
    </li>

    @foreach($topics as $topic)
        <li href="#" class="list-group-item menu1">
            {{$topic->name}}
        </li>
        <ul>
            @foreach($topic->categories as $category)
                <li class="list-group-item">
                    <a href="loaitin.html">{{$category->name}}</a>
                </li>
            @endforeach
        </ul>
    @endforeach
</ul>
