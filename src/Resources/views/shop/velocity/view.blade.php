@extends('shop::layouts.master')

@section('page_title')
    {{ $blog->name }}
@stop

@section('content-wrapper')

    <div class="main">
        <div>
            <div class="row col-12 remove-padding-margin">
                <div id="home-right-bar-container" class="col-12 no-padding content">
                    <div class="container-right row no-margin col-12 no-padding">
                        <section class="blog-hero-wrapper">
                            <div class="blog-hero-image">
                                <img
                                    src="{{ '/storage/' . $blog->src }}"
                                    alt="Blanditiis soluta et iste consectetur sapiente nobis ut perferendis fugiat veritatis incidunt dolore."
                                    class="card-img img-fluid img-thumbnail bg-fill">
                            </div>
                        </section>
                        <div id="blog" class="container mt-5">
                            <div class="full-content-wrapper">
                                <div class="row">
                                    <div class="col-md-9">
                                        <section class="blog-content">
                                            <div class="text-justify mb-3 blog-post-content">
                                                <h3>{{ $blog->name }}</h3>
                                                {!! $blog->short_description !!}
                                                <br/>
                                                {!! $blog->description !!}
                                            </div>
                                        </section>
                                    </div>

                                    <sidebar class="col-lg-3 blog-sidebar">
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
                                    </sidebar>
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