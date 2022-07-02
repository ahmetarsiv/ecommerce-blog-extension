@extends('shop::layouts.master')

@section('page_title')
    Blog
@endsection

@section('head')
@endsection

@section('content-wrapper')

    <div class="row col-12 remove-padding-margin">
        <div id="home-right-bar-container" class="col-12 no-padding content">
            <div class="container-right row no-margin col-12 no-padding">
                <div id="blog" class="container mt-5">
                    <div class="full-content-wrapper">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="mb-3">Our Blog</h1>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    @foreach($blogRepository as $blog)
                                        <div class="col-lg-4 col-md-6 col-sm-12 blog-post-item">
                                            <div class="card mb-5">
                                                @if(!$blog->image)
                                                    <img src="{{ url('/vendor/webkul/ui/assets/images/product/large-product-placeholder.png') }}" alt="{{ $blog->name }}" class="card-img-top">
                                                @else
                                                    <img src="{{ storage_path($blog->image) }}" alt="{{ $blog->name }}" class="card-img-top">
                                                @endif
                                                <div class="card-body">
                                                    <h2 class="card-title">
                                                        <a href="{{ url('blog',$blog->slug) }}">{{ $blog->name }}</a>
                                                    </h2>
                                                    <div class="post-meta">
                                                        <p>{!! \Carbon\Carbon::parse($blog->published_at)->diffForHumans() !!}
                                                            <a href="#">{{ $blog->author }}</a>
                                                        </p>
                                                    </div>
                                                    <div class="post-categories">
                                                        <p><a href="#" class="cat-link">Category</a></p>
                                                    </div>
                                                    <div class="card-text text-justify">{!! $blog->short_description !!}</div>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="{{ url('blog',$blog->slug) }}" class="text-uppercase btn-text-link">Read more</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-3 blog-sidebar">
                                <div class="row">
                                    <div class="col-lg-12 mb-4 categories"><h3>Categories</h3>
                                        <ul class="list-group">
                                            @foreach($categories as $category)
                                                <a href="{{ url('blog',$category->category->slug) }}" class="list-group-item list-group-item-action ">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        {{$category->default_category == 0 ? 'other' : $category->category->name}}
                                                        <span class="badge badge-pill  badge-primary ">{{$category->count}}</span>
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

@endsection