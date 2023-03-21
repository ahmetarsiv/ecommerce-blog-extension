<?php

namespace Webkul\Article\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;
use Webkul\Ui\DataGrid\DataGrid;

class CommentDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('blog_comments')->select('id')
            ->addSelect('id', 'post', 'author', 'email', 'comment', 'status', 'created_at');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('blog::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'post',
            'label'      => trans('blog::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'comment',
            'label'      => trans('blog::app.datagrid.content'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('blog::app.datagrid.status'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($value) {
                if ($value->status == 1) {
                    return '<span class="badge badge-md badge-warning">' . trans('blog::app.datagrid.pending') . '</span>';
                } elseif ($value->status == 2) {
                    return '<span class="badge badge-md badge-success">' . trans('blog::app.datagrid.approved') . '</span>';
                } elseif ($value->status == 0) {
                    return '<span class="badge badge-md badge-danger">' . trans('blog::app.datagrid.rejected') . '</span>';
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('blog::app.datagrid.published_at'),
            'type'       => 'datetime',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title' => 'edit',
            'method' => 'GET',
            'route' => 'admin.blog.comment.edit',
            'icon' => 'icon pencil-lg-icon'
        ]);

        $this->addAction([
            'title' => 'delete',
            'method' => 'POST',
            'route' => 'admin.blog.comment.delete',
            'icon' => 'icon trash-icon'
        ]);
    }

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'action' => route('admin.blog.comment.massdelete'),
            'method' => 'POST',
        ]);
    }
}