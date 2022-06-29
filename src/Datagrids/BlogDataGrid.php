<?php

namespace Webkul\Blog\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;
use Webkul\Ui\DataGrid\DataGrid;

class BlogDataGrid extends DataGrid
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
        $queryBuilder = DB::table('blogs')
            ->select('blogs.id','blogs.name', 'blogs.slug', 'blogs.short_description', 'blogs.description', 'blogs.channels',
                'category.name as category_name', 'blogs.author',
                'blogs.tags', 'blogs.image', 'blogs.status', 'blogs.allow_comments', 'blogs.published_at',
                'blogs.meta_title', 'blogs.meta_description', 'blogs.meta_keywords')
            ->leftJoin('blog_categories as category', 'blogs.default_category', '=', 'category.id');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('blog::app.datagrid.id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('blog::app.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'category_name',
            'label' => trans('blog::app.datagrid.category'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('blog::app.datagrid.status'),
            'type' => 'boolean',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($value) {
                if ($value->status == 1) {
                    return '<span class="badge badge-md badge-success">' . trans('admin::app.datagrid.active') . '</span>';
                } else {
                    return '<span class="badge badge-md badge-danger">' . trans('admin::app.datagrid.inactive') . '</span>';
                }
            },
        ]);

        $this->addColumn([
            'index' => 'allow_comments',
            'label' => trans('blog::app.datagrid.allow_comments'),
            'type' => 'boolean',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true,
            'closure' => function ($value) {
                if ($value->allow_comments == 1) {
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
            'route' => 'admin.blog.edit',
            'icon' => 'icon pencil-lg-icon'
        ]);

        $this->addAction([
            'title' => 'delete',
            'method' => 'POST',
            'route' => 'admin.blog.delete',
            'icon' => 'icon trash-icon'
        ]);
    }

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'action' => route('admin.blog.massdelete'),
            'method' => 'POST',
        ]);
    }
}