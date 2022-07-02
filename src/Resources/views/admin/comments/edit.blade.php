@extends('admin::layouts.content')

@section('page_title')
    {{ __('blog::app.comment.edit-title') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('admin.blog.comment.update', $comment->id) }}" @submit.prevent="onSubmit">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.blog.comment.index') }}'"></i>

                        {{ __('blog::app.comment.edit-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('blog::app.comment.edit-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()

                    {!! view_render_event('admin.blog.comments.edit.before') !!}

                    <accordian title="{{ __('blog::app.comment.general') }}" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('post') ? 'has-error' : '']">
                                <label for="post">{{ __('blog::app.comment.post') }}</label>

                                <input type="text" class="control" name="post" value="{{ $comment->blog->name }}" disabled="disabled" data-vv-as="&quot;{{ __('blog::app.comment.post') }}&quot;">

                                <span class="control-error" v-if="errors.has('post')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('author') ? 'has-error' : '']">
                                <label for="author">{{ __('blog::app.comment.name') }}</label>

                                <input type="text" class="control" name="author" value="{{ $comment->author }}" disabled="disabled" data-vv-as="&quot;{{ __('blog::app.comment.name') }}&quot;">

                                <span class="control-error" v-if="errors.has('author')">@{{ errors.first('author') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                                <label for="email">{{ __('blog::app.comment.email') }}</label>

                                <input type="text" class="control" name="email" value="{{ $comment->email }}" disabled="disabled" data-vv-as="&quot;{{ __('blog::app.comment.email') }}&quot;">

                                <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('created_at') ? 'has-error' : '']">
                                <label for="created_at">{{ __('blog::app.comment.comment_date') }}</label>

                                <input type="text" class="control" name="created_at" value="{{ $comment->created_at }}" disabled="disabled" data-vv-as="&quot;{{ __('blog::app.comment.comment_date') }}&quot;">

                                <span class="control-error" v-if="errors.has('created_at')">@{{ errors.first('created_at') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('status') ? 'has-error' : '']">
                                <label for="status" class="required">{{ __('blog::app.comment.status') }}</label>

                                <select class="control" id="status" name="status" v-validate="'required'">
                                    <option value="1" {{$comment->status === 1 ? 'selected': null}}>{{ __('blog::app.comment.status-pending') }}</option>
                                    <option value="2" {{$comment->status === 2 ? 'selected': null}}>{{ __('blog::app.comment.status-approved') }}</option>
                                    <option value="0" {{$comment->status === 0 ? 'selected': null}}>{{ __('blog::app.comment.status-rejected') }}</option>
                                </select>

                                <span class="control-error" v-if="errors.has('status')">@{{ errors.first('status') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('comment') ? 'has-error' : '']">
                                <label for="meta_keywords" class="required">{{ __('blog::app.comment.comment') }}</label>

                                <textarea type="text" class="control" name="comment" v-validate="'required'">{{ $comment->comment }}</textarea>

                                <span class="control-error" v-if="errors.has('comment')">@{{ errors.first('comment') }}</span>
                            </div>

                        </div>
                    </accordian>

                    {!! view_render_event('admin.blog.comments.edit.after', ['comment' => $comment]) !!}

                </div>
            </div>
        </form>
    </div>
@stop

@push('scripts')
    @include('admin::layouts.tinymce')

    <script>
        $(document).ready(function () {
            tinyMCEHelper.initTinyMCE({
                selector: 'textarea#content',
                height: 200,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor alignleft aligncenter alignright alignjustify | link hr |numlist bullist outdent indent  | removeformat | code | table',
                image_advtab: true,
                valid_elements : '*[*]',
            });
        });
    </script>
@endpush