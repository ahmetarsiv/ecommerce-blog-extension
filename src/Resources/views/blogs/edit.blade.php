@extends('admin::layouts.content')

@section('page_title')
    {{ __('blog::app.blog.edit-title') }}
@stop

@section('content')
    <div class="content">
        @php $locale = core()->getRequestedLocaleCode(); @endphp

        <form method="POST" action="{{ route('admin.blog.update', $blog->id) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.blog.index') }}'"></i>

                        {{ __('blog::app.blog.edit-title') }}

                        @if ($blog->locale)
                            <span class="locale">[{{ $blog->locale }}]</span>
                        @endif
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('blog::app.blog.create-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()
                    {!! view_render_event('admin.blogs.edit.before') !!}

                    <accordian title="{{ __('blog::app.blog.general') }}" :active="true">
                        <div slot="body">
                            <div class="control-group multi-select" :class="[errors.has('locale[]') ? 'has-error' : '']">
                                <label for="locale">{{ __('admin::app.datagrid.locale') }}</label>

                                <select class="control" id="locale" name="locale[]" data-vv-as="&quot;{{ __('admin::app.datagrid.locale') }}&quot;" v-validate="'required'" multiple>
                                    @foreach (core()->getAllLocales() as $localeModel)

                                        <option value="{{ $localeModel->code }}" {{ in_array($localeModel->code, explode(',', $blog->locale)) ? 'selected' : ''}}>
                                            {{ $localeModel->name }}
                                        </option>

                                    @endforeach
                                </select>

                                <span class="control-error" v-if="errors.has('locale[]')">@{{ errors.first('locale[]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('blog::app.blog.name') }}</label>

                                <input type="text" class="control" name="name" v-validate="'required'" value="{{$blog->name}}" data-vv-as="&quot;{{ __('blog::app.blog.name') }}&quot;">

                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('slug') ? 'has-error' : '']">
                                <label for="slug" class="required">{{ __('blog::app.blog.slug') }}</label>

                                <input type="text" class="control" name="slug" v-validate="'required'" value="{{$blog->slug}}" data-vv-as="&quot;{{ __('blog::app.blog.slug') }}&quot;">

                                <span class="control-error" v-if="errors.has('slug')">@{{ errors.first('slug') }}</span>
                            </div>

                            @inject('channels', 'Webkul\Core\Repositories\ChannelRepository')

                            <div class="control-group multi-select" :class="[errors.has('channels') ? 'has-error' : '']">
                                <label for="url-key" class="required">{{ __('admin::app.cms.pages.channel') }}</label>

                                <select type="text" class="control" name="channels" v-validate="'required'" value="{{ old('channel') }}" data-vv-as="&quot;{{ __('admin::app.cms.pages.channel') }}&quot;" multiple="multiple">
                                    @foreach($channels->all() as $channel)
                                        <option value="{{ $channel->id }}" {{$channel->id == $blog->channels ? 'selected' : null}}>{{ core()->getChannelName($channel) }}</option>
                                    @endforeach
                                </select>

                                <span class="control-error" v-if="errors.has('channels')">@{{ errors.first('channels') }}</span>
                            </div>

                            <div class="control-group date">
                                <label for="starts_from">{{ __('blog::app.blog.published_at') }}</label>
                                <date>
                                    <input type="text" name="published_at" class="control" value="{{$blog->published_at}}"/>
                                </date>
                            </div>

                            <div class="control-group">
                                <label for="status">{{ __('blog::app.blog.status') }}</label>

                                <select class="control" id="status" name="status">
                                    <option value="1" {{$blog->status === 1 ? 'selected': null}}>{{ __('blog::app.blog.status-true') }}</option>
                                    <option value="0" {{$blog->status === 0 ? 'selected': null}}>{{ __('blog::app.blog.status-false') }}</option>
                                </select>
                            </div>

                            <div class="control-group">
                                <label for="allow_comments">{{ __('blog::app.blog.allow_comments') }}</label>

                                <select class="control" id="allow_comments" name="allow_comments">
                                    <option value="1" {{$blog->allow_comments === 1 ? 'selected': null}}>{{ __('blog::app.blog.yes') }}</option>
                                    <option value="0" {{$blog->allow_comments === 0 ? 'selected': null}}>{{ __('blog::app.blog.no') }}</option>
                                </select>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('blog::app.blog.categories_tag') }}" :active="true">
                        <div slot="body">
                            <div class="control-group">
                                <label for="default_category">{{ __('blog::app.blog.default_category') }}</label>

                                <select class="control" id="default_category" name="default_category">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{$category->id == $blog->default_category ? 'selected' : null}}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="control-group multi-select" :class="[errors.has('tags') ? 'has-error' : '']">
                                <label for="url-key" class="required">{{ __('blog::app.blog.tags') }}</label>

                                <select type="text" class="control" name="tags" v-validate="'required'" value="{{ old('tags') }}" data-vv-as="&quot;{{ __('blog::app.blog.tags') }}&quot;" multiple="multiple">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{$tag->id == $blog->tags ? 'selected' : null}}>{{$tag->name}}</option>
                                    @endforeach
                                </select>

                                <span class="control-error" v-if="errors.has('tags')">@{{ errors.first('tags') }}</span>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('blog::app.blog.description') }}" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('short_description') ? 'has-error' : '']">
                                <label for="short_description" class="required">{{ __('blog::app.blog.short_description') }}</label>

                                <textarea type="text" class="control" id="content" name="short_description" v-validate="'required'" data-vv-as="&quot;{{ __('blog::app.blog.short_description') }}&quot;">{{$blog->short_description}}</textarea>

                                <span class="control-error" v-if="errors.has('short_description')">@{{ errors.first('short_description') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('description') ? 'has-error' : '']">
                                <label for="description" class="required">{{ __('blog::app.blog.description') }}</label>

                                <textarea type="text" class="control" id="content" name="description" v-validate="'required'" data-vv-as="&quot;{{ __('blog::app.blog.description') }}&quot;">{{$blog->description}}</textarea>

                                <span class="control-error" v-if="errors.has('description')">@{{ errors.first('description') }}</span>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('blog::app.blog.image') }}" :active="true">
                        <div slot="body">
                            <div class="control-group {!! $errors->has('image.*') ? 'has-error' : '' !!}">
                                <label class="required">{{ __('blog::app.blog.image') }}</label>

                                <image-wrapper button-label="{{ __('blog::app.blog.add-image') }}" input-name="image" :multiple="false" :images='"{{ Storage::url($blog->image) }}"'></image-wrapper>

                                <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
                                    @foreach ($errors->get('image.*') as $key => $message)
                                        @php echo str_replace($key, 'Image', $message[0]); @endphp
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('blog::app.blog.search_engine_optimization') }}" :active="true">
                        <div slot="body">
                            <div class="control-group">
                                <label for="meta_title">{{ __('blog::app.blog.meta_title') }}</label>

                                <input type="text" class="control" name="meta_title" value="{{$blog->meta_title}}">
                            </div>

                            <div class="control-group">
                                <label for="meta_keywords">{{ __('blog::app.blog.meta_keywords') }}</label>

                                <textarea type="text" class="control" name="meta_keywords">{{$blog->meta_keywords}}</textarea>
                            </div>

                            <div class="control-group">
                                <label for="meta_description">{{ __('blog::app.blog.meta_description') }}</label>

                                <textarea type="text" class="control" name="meta_description">{{$blog->meta_description}}</textarea>

                            </div>
                        </div>
                    </accordian>

                    {!! view_render_event('admin.blogs.edit.after', ['blogs' => $blog]) !!}
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