@extends('admin::layouts.content')

@section('page_title')
    {{ __('blog::app.category.add-title') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('admin.blog.category.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.blog.category.index') }}'"></i>

                        {{ __('blog::app.category.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('blog::app.category.create-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">

                <div class="form-container">
                    @csrf()

                    {!! view_render_event('admin.blog.categories.create.before') !!}

                    <accordian title="{{ __('blog::app.category.general') }}" :active="true">
                        <div slot="body">
                            <div class="control-group multi-select" :class="[errors.has('locale') ? 'has-error' : '']">
                                <label for="locale">{{ __('admin::app.datagrid.locale') }}</label>

                                <select class="control" id="locale" name="locale" data-vv-as="&quot;{{ __('admin::app.datagrid.locale') }}&quot;" v-validate="'required'" multiple>
                                    @foreach (core()->getAllLocales() as $localeModel)

                                        <option value="{{ $localeModel->code }}">
                                            {{ $localeModel->name }}
                                        </option>

                                    @endforeach
                                </select>

                                <span class="control-error" v-if="errors.has('locale')">@{{ errors.first('locale') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('blog::app.category.name') }}</label>

                                <input type="text" class="control" name="name" v-validate="'required'" value="{{ old('name') }}" data-vv-as="&quot;{{ __('blog::app.category.name') }}&quot;">

                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('slug') ? 'has-error' : '']">
                                <label for="slug" class="required">{{ __('blog::app.category.slug') }}</label>

                                <input type="text" class="control" name="slug" v-validate="'required'" value="{{ old('slug') }}" data-vv-as="&quot;{{ __('blog::app.category.slug') }}&quot;">

                                <span class="control-error" v-if="errors.has('slug')">@{{ errors.first('slug') }}</span>
                            </div>

                            <div class="control-group">
                                <label for="status">{{ __('blog::app.category.status') }}</label>

                                <select class="control" id="status" name="status">
                                    <option value="1">{{ __('blog::app.category.status-true') }}</option>
                                    <option value="0">{{ __('blog::app.category.status-false') }}</option>
                                </select>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('blog::app.category.description') }}" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('description') ? 'has-error' : '']">
                                <label for="description" class="required">{{ __('blog::app.category.description') }}</label>

                                <textarea type="text" class="control" id="content" name="description" v-validate="'required'" data-vv-as="&quot;{{ __('blog::app.category.description') }}&quot;">{{ old('description') }}</textarea>

                                <span class="control-error" v-if="errors.has('description')">@{{ errors.first('description') }}</span>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('blog::app.category.image') }}" :active="true">
                        <div slot="body">
                            <div class="control-group {!! $errors->has('image.*') ? 'has-error' : '' !!}">
                                <label class="required">{{ __('blog::app.category.image') }}</label>

                                <image-wrapper button-label="{{ __('blog::app.category.add-image') }}" input-name="image" :multiple="false" required></image-wrapper>

                                <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
                                    @foreach ($errors->get('image.*') as $key => $message)
                                        @php echo str_replace($key, 'Image', $message[0]); @endphp
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </accordian>

                    <accordian title="{{ __('blog::app.category.search_engine_optimization') }}" :active="true">
                        <div slot="body">
                            <div class="control-group" :class="[errors.has('meta_title') ? 'has-error' : '']">
                                <label for="meta_title" class="required">{{ __('blog::app.blog.meta_title') }}</label>

                                <input type="text" class="control" name="meta_title" v-validate="'required'" data-vv-as="Meta Title" value="{{ old('meta_title') }}">

                                <span class="control-error" v-if="errors.has('meta_title')">@{{ errors.first('meta_title') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('meta_keywords') ? 'has-error' : '']">
                                <label for="meta_keywords" class="required">{{ __('blog::app.blog.meta_keywords') }}</label>

                                <textarea type="text" class="control" v-validate="'required'" data-vv-as="Meta Keywords" name="meta_keywords">{{ old('meta_keywords') }}</textarea>

                                <span class="control-error" v-if="errors.has('meta_keywords')">@{{ errors.first('meta_keywords') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('meta_description') ? 'has-error' : '']">
                                <label for="meta_description" class="required">{{ __('blog::app.blog.meta_description') }}</label>

                                <textarea type="text" class="control" name="meta_description" v-validate="'required'" data-vv-as="Meta Description">{{ old('meta_description') }}</textarea>

                                <span class="control-error" v-if="errors.has('meta_description')">@{{ errors.first('meta_description') }}</span>
                            </div>
                        </div>
                    </accordian>

                    {!! view_render_event('admin.blog.categories.create.after') !!}

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