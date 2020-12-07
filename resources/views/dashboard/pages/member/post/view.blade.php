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
                                            <use xlink:href="#icon-ava-{{strtolower(substr($post->author->name, 0, 1))}}"></use>
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
                                <a >{{$post->title}}</a>
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
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script src="assets_client/js/bundle.js"></script>
@endsection
