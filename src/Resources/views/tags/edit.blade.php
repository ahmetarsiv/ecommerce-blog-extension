@extends('admin::layouts.content')

@section('page_title')
    {{ __('blog::app.tag.edit-title') }}
@stop

@section('content')
    <div class="content">
        @php $locale = core()->getRequestedLocaleCode(); @endphp

        <form method="POST" action="{{ route('admin.blog.tag.update', $tag->id) }}" @submit.prevent="onSubmit">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.blog.tag.index') }}'"></i>

                        {{ __('blog::app.tag.edit-title') }}

                        @if ($tag->locale)
                            <span class="locale">[{{ $tag->locale }}]</span>
                        @endif
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('blog::app.tag.edit-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()

                    {!! view_render_event('admin.blog.tags.edit.before') !!}

                    <accordian title="{{ __('blog::app.tag.general') }}" :active="true">
                        <div slot="body">
                            <div class="control-group multi-select" :class="[errors.has('locale[]') ? 'has-error' : '']">
                                <label for="locale">{{ __('admin::app.datagrid.locale') }}</label>

                                <select class="control" id="locale" name="locale[]" data-vv-as="&quot;{{ __('admin::app.datagrid.locale') }}&quot;" v-validate="'required'" multiple>
                                    @foreach (core()->getAllLocales() as $localeModel)

                                        <option value="{{ $localeModel->code }}" {{ in_array($localeModel->code, explode(',', $tag->locale)) ? 'selected' : ''}}>
                                            {{ $localeModel->name }}
                                        </option>

                                    @endforeach
                                </select>

                                <span class="control-error" v-if="errors.has('locale[]')">@{{ errors.first('locale[]') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('blog::app.tag.name') }}</label>

                                <input type="text" class="control" name="name" v-validate="'required'" value="{{ $tag->name }}" data-vv-as="&quot;{{ __('blog::app.tag.name') }}&quot;">

                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('slug') ? 'has-error' : '']">
                                <label for="slug" class="required">{{ __('blog::app.tag.slug') }}</label>

                                <input type="text" class="control" name="slug" v-validate="'required'" value="{{ $tag->slug }}" data-vv-as="&quot;{{ __('blog::app.tag.slug') }}&quot;">

                                <span class="control-error" v-if="errors.has('slug')">@{{ errors.first('slug') }}</span>
                            </div>

                            <div class="control-group">
                                <label for="status">{{ __('blog::app.tag.status') }}</label>

                                <select class="control" id="status" name="status">
                                    <option value="1" {{$tag->status === 1 ? 'selected': null}}>{{ __('blog::app.tag.status-true') }}</option>
                                    <option value="0" {{$tag->status === 0 ? 'selected': null}}>{{ __('blog::app.tag.status-false') }}</option>
                                </select>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('blog::app.tag.description') }}" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('description') ? 'has-error' : '']">
                                <label for="description" class="required">{{ __('blog::app.tag.description') }}</label>

                                <textarea type="text" class="control" id="content" name="description" v-validate="'required'" data-vv-as="&quot;{{ __('blog::app.tag.description') }}&quot;">{{ $tag->description }}</textarea>

                                <span class="control-error" v-if="errors.has('description')">@{{ errors.first('description') }}</span>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('blog::app.tag.search_engine_optimization') }}" :active="true">
                        <div slot="body">
                            <div class="control-group">
                                <label for="meta_title">{{ __('blog::app.tag.meta_title') }}</label>

                                <input type="text" class="control" name="meta_title" value="{{ $tag->meta_keywords }}">
                            </div>

                            <div class="control-group">
                                <label for="meta_keywords">{{ __('blog::app.tag.meta_keywords') }}</label>

                                <textarea type="text" class="control" name="meta_keywords">{{ $tag->meta_keywords }}</textarea>
                            </div>

                            <div class="control-group">
                                <label for="meta_description">{{ __('blog::app.tag.meta_description') }}</label>

                                <textarea type="text" class="control" name="meta_description">{{ $tag->meta_description }}</textarea>

                            </div>
                        </div>
                    </accordian>

                    {!! view_render_event('admin.blog.tags.edit.before', ['tag' => $tag]) !!}

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