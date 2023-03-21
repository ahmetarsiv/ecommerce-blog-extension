@extends('admin::layouts.master')

@section('page_title')
    {{ __('blog::app.category.title') }}
@stop

@section('content-wrapper')

    <div class="content full-page dashboard">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('blog::app.category.title') }}</h1>
            </div>

            <div class="page-action">
                <div class="export-import" @click="showModal('downloadDataGrid')">
                    <i class="export-icon"></i>

                    <span>
                        {{ __('admin::app.export.export') }}
                    </span>
                </div>

                <a href="{{ route('admin.blog.category.create') }}" class="btn btn-lg btn-primary">
                    {{ __('blog::app.category.add-title') }}
                </a>
            </div>

            <div class="page-action">
                <date-filter></date-filter>

            </div>

            <date-mobile-filter></date-mobile-filter>
        </div>

        <div class="page-content">
            <datagrid-plus src="{{ route('admin.blog.category.index') }}"></datagrid-plus>
        </div>
    </div>

    <modal id="downloadDataGrid" :is-open="modalIds.downloadDataGrid">
        <h3 slot="header">{{ __('admin::app.export.download') }}</h3>

        <div slot="body">
            <export-form></export-form>
        </div>
    </modal>

@stop

@push('scripts')
    @include('admin::export.export', ['gridName' => app('Webkul\Article\DataGrids\CategoryDataGrid')])
@endpush