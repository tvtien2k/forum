@extends('client1.index')

@section('title', 'Page Title')

@section('style')
    <link rel="stylesheet" href="assets_client/css/style.css">
@endsection

@section('main')
    <main id="tt-pageContent">
        <div class="container">
            <div class="tt-single-topic-list">
                <div class="tt-item">
                    <div class="tt-single-topic">
                        <div class="tt-item-header">
                            <div class="tt-item-info info-top">
                                <div class="tt-avatar-icon">
                                    <i class="tt-icon">
                                        <svg>
                                            <use
                                                xlink:href="#icon-ava-{{strtolower(substr($post->author->name, 0, 1))}}"></use>
                                        </svg>
                                    </i>
                                </div>
                                <div class="tt-avatar-title">
                                    <a>{{$post->author->name}}</a>
                                </div>
                                <a class="tt-info-time">
                                    <i class="tt-icon">
                                        <svg>
                                            <use xlink:href="#icon-time"></use>
                                        </svg>
                                    </i>{{$post->created_at}}
                                </a>
                            </div>
                            <h3 class="tt-item-title">
                                <a>{{$post->title}}</a>
                            </h3>
                            <div class="tt-item-tag">
                                <ul class="tt-list-badge">
                                    <li>
                                        <a>
                                            <span class="tt-color03 tt-badge">
                                                {{$post->category->topic->name}}
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="tt-badge">
                                                {{$post->category->name}}
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tt-item-description">
                            {{$post->content}}
                        </div>
                        <div class="tt-item-info info-bottom">
                            <div class="col-separator"></div>
                            <a class="tt-icon-btn tt-hover-02 tt-small-indent">
                                <i class="tt-icon">
                                    <svg>
                                        <use xlink:href="#icon-flag"></use>
                                    </svg>
                                </i>
                            </a>
                            <a class="tt-icon-btn tt-hover-02 tt-small-indent">
                                <i class="tt-icon">
                                    <svg>
                                        <use xlink:href="#icon-reply"></use>
                                    </svg>
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tt-wrapper-inner">
                    <div class="pt-editor form-default">
                        <h6 class="pt-title">Post Your Reply</h6>
                        <form method="post" action="">
                            @csrf
                            <input type="text" name="id" value="{{$post->id}}" hidden>
                            <div class="form-group">
                                <textarea class="editor" name="_content">{{ old('_content') }}</textarea>
                            </div>
                            <div class="pt-row">
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-secondary btn-width-lg">
                                        Reply
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @foreach($comments as $comment)
                    @php
                        $level = count(explode('_', explode('-', $comment->id)[1])) - 2;
                    @endphp
                    <div class="tt-wrapper-inner">
                        <h4 class="tt-title-separator"></h4>
                    </div>
                    <div class="row">
                        <div class="col-{{$level}}"></div>
                        <div class="tt-item col-{{12-$level}}">
                            <div class="tt-single-topic">
                                <div class="tt-item-header pt-noborder">
                                    <div class="tt-item-info info-top">
                                        <div class="tt-avatar-icon">
                                            <i class="tt-icon">
                                                <svg>
                                                    <use
                                                        xlink:href="#icon-ava-{{strtolower(substr($post->author->name, 0, 1))}}"></use>
                                                </svg>
                                            </i>
                                        </div>
                                        <div class="tt-avatar-title">
                                            <a href="#">{{$comment->author->name}}</a>
                                        </div>
                                        <a href="#" class="tt-info-time">
                                            <i class="tt-icon">
                                                <svg>
                                                    <use xlink:href="#icon-time"></use>
                                                </svg>
                                            </i>{{$comment->created_at}}
                                        </a>
                                    </div>
                                </div>
                                <div class="tt-item-description">
                                    {{$comment->content}}
                                </div>
                                <div class="tt-item-info info-bottom">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#reply" data-whatever="{{$comment->id}}">
                                        Reply
                                    </button>
                                    <div class="col-separator"></div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#report" data-whatever="@mdo">
                                        Report
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="modal fade" id="reply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                        <input type="text" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                        <input type="text" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Message:</label>
                                        <textarea class="form-control" id="message-text"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Send message</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="report" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                        <input type="text" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                        <input type="text" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Message:</label>
                                        <textarea class="form-control" id="message-text"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Send message</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection

@section('js')
    <script src="assets_client/js/bundle.js"></script>
    <script src="ckeditor5/build/ckeditor.js"></script>
    <script>ClassicEditor
            .create(document.querySelector('.editor'), {

                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'indent',
                        'outdent',
                        '|',
                        'alignment',
                        'insertTable',
                        'blockQuote',
                        'undo',
                        'redo',
                        '|',
                        'mediaEmbed',
                        'imageInsert',
                        '|',
                        'code',
                        'codeBlock',
                        '|',
                        'htmlEmbed',
                        'exportPdf'
                    ]
                },
                language: 'en',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:full',
                        'imageStyle:side'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                },
                licenseKey: '',

            })
            .then(editor => {
                window.editor = editor;


            })
            .catch(error => {
                console.error('Oops, something went wrong!');
                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                console.warn('Build id: t7ukt7v91nmd-3rq4gwmsanl7');
                console.error(error);
            });
    </script>
    <script>
        $('#reply').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('whatever')
            var modal = $(this)
            modal.find('.modal-title').text('Reply comment of ' + recipient)
            modal.find('.modal-body input').val(recipient)
        })
        $('#report').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('whatever')
            var modal = $(this)
            modal.find('.modal-title').text('New message to ' + recipient)
            modal.find('.modal-body input').val(recipient)
        })
    </script>
@endsection
