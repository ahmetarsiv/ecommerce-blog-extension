<?php

namespace Webkul\Article\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;
use Webkul\Ui\DataGrid\DataGrid;

class CategoryDataGrid extends DataGrid
{
    /**
     * Set index columns, ex: id.
     *
     * @var int
     */
    protected $index = 'id';

    /**
     * Default sort order of datagrid.
     *
     * @var string
     */
    protected $sortOrder = 'desc';

    /**
     * Locale.
     *
     * @var string
     */
    protected $locale = 'all';

    /**
     * Channel.
     *
     * @var string
     */
    protected $channel = 'all';

    /**
     * Contains the keys for which extra filters to render.
     *
     * @var string[]
     */
    protected $extraFilters = [
        'channels',
        'locales',
    ];

    /**
     * Create datagrid instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        /* locale */
        $this->locale = core()->getRequestedLocaleCode();

        /* channel */
        $this->channel = core()->getRequestedChannelCode();

        /* finding channel code */
        if ($this->channel !== 'all') {
            $this->channel = Channel::where('code', $this->channel)->first();

            $this->channel = $this->channel ? $this->channel->code : 'all';
        }
    }

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('blog_categories')
            ->select('id')
            ->addSelect('id', 'name', 'slug', 'status', 'description', 'meta_title', 'meta_description', 'meta_keywords');

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
            'index'      => 'name',
            'label'      => trans('blog::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('blog::app.datagrid.status'),
            'type'       => 'boolean',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($value) {
                if ($value->status == 1) {
                    return '<span class="badge badge-md badge-success">' . trans('admin::app.datagrid.active') . '</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">' . trans('admin::app.datagrid.inactive') . '</span>';
                }
            },
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title' => 'edit',
            'method' => 'GET',
            'route' => 'admin.blog.category.edit',
            'icon' => 'icon pencil-lg-icon'
        ]);

        $this->addAction([
            'title' => 'delete',
            'method' => 'POST',
            'route' => 'admin.blog.category.delete',
            'icon' => 'icon trash-icon'
        ]);
    }

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'action' => route('admin.blog.category.massdelete'),
            'method' => 'POST',
        ]);
    }
}