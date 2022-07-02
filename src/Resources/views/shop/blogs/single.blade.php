@extends('shop::layouts.master')

@section('page_title')
    {{ $blogRepository->name }}
@endsection

@section('head')
    @isset($blogRepository->meta_title)
        <meta name="title" content="{{ $blogRepository->meta_title }}" />
    @endisset

    @isset($blogRepository->meta_description)
        <meta name="description" content="{{ $blogRepository->meta_description }}" />
    @endisset

    @isset($blogRepository->meta_keywords)
        <meta name="keywords" content="{{ $blogRepository->meta_keywords }}" />
    @endisset
@endsection

@section('content-wrapper')

    <div class="row col-12 remove-padding-margin">
        <div id="home-right-bar-container" class="col-12 no-padding content">
            <div class="container-right row no-margin col-12 no-padding">
                <section class="blog-hero-wrapper">
                    <div class="blog-hero-content">
                        <div class="banner-heading">
                            <h1 class="blog-hero-title">{{ $blogRepository->name }}</h1>
                            <div class="post-meta"><p>{!! \Carbon\Carbon::parse($blogRepository->published_at)->diffForHumans() !!} by<a href="#" class="cat-link">{{ $blogRepository->author }}</a></p></div>
                            <div class="post-categories">
                                <p><a href="#" class="cat-link">{{ $blogRepository->default_category }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="blog-hero-image">
                        @if(!$blogRepository->image)
                            <img src="{{ url('/vendor/webkul/ui/assets/images/product/large-product-placeholder.png') }}" alt="{{ $blogRepository->name }}" class="card-img img-fluid img-thumbnail bg-fill">
                        @else
                            <img src="{{ $blogRepository->image }}" alt="{{ $blogRepository->name }}" class="card-img img-fluid img-thumbnail bg-fill">
                        @endif

                    </div>
                </section>
                <div id="blog" class="container mt-5">
                    <div class="full-content-wrapper">
                        <div class="row">
                            <div class="col-md-9">
                                <section class="blog-content">
                                    <div class="post-tags mb-3"><strong>Tags:</strong>
                                        <a href="#" class="cat-link">{{ $blogRepository->tags }}</a>
                                    </div>
                                    <div class="text-justify mb-3 blog-post-content">
                                        <p>{!! $blogRepository->short_description !!}</p>
                                        {!! $blogRepository->description !!}
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection