@extends('shop::layouts.master')

@section('page_title')
    Blog
@stop

@section('content-wrapper')

    <div class="main">

        <div>
            <div class="row col-12 remove-padding-margin"><!---->
                <div id="home-right-bar-container" class="col-12 no-padding content">
                    <div class="container-right row no-margin col-12 no-padding">
                        <div id="blog" class="container mt-5">
                            <div class="full-content-wrapper">
                                <div class="row">
                                    <div class="col-lg-12"><h1 class="mb-3">Our Blog</h1></div>
                                    <div class="col-lg-9">
                                        <div class="row">

                                            @foreach($blogs as $blog)
                                                <div class="col-lg-4 col-md-6 col-sm-12 blog-post-item">
                                                    <div class="card mb-5">
                                                        <img
                                                            src="{{ '/storage/' . $blog->src }}"
                                                            alt="{{ $blog->name }}"
                                                            class="card-img-top">
                                                        <div class="card-body">
                                                            <h2 class="card-title"><a href="{{route('shop.article.view',[$blog->category->slug . '/' . $blog->slug])}}">{{ $blog->name }}</a></h2>
                                                            <div class="post-meta">
                                                                <p>
                                                                    {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->created_at)->format('M j, Y') }} by
                                                                    <a href="#">{{ $blog->author }}</a>
                                                                </p>
                                                            </div>
                                                            <div class="card-text text-justify">
                                                                {!! $blog->short_description !!}
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <a href="{{route('shop.article.view',[$blog->category->slug . '/' . $blog->slug])}}" class="text-uppercase btn-text-link">Read more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-lg-12 mt-5 mb-5">
                                                {!! $blogs->links() !!}
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-3 blog-sidebar">
                                        <div class="row">
                                            <div class="col-lg-12 mb-4 categories"><h3>Categories</h3>
                                                <ul class="list-group">
                                                    @foreach($categories as $category)
                                                        <a href="#" class="list-group-item list-group-item-action">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                {{ $category->category->name }} <span class="badge badge-pill badge-primary">{{ $category->count }}</span>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@stop