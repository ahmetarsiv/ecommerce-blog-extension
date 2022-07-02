<?php

namespace Webkul\Blog\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\Blog\Models\Blog;
use Webkul\Blog\Repositories\BlogCategoryRepository;
use Webkul\Blog\Repositories\BlogRepository;

class ShopBlogController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected BlogRepository $blogRepository,
        protected BlogCategoryRepository $blogCategoryRepository
    )
    {
        $this->BlogRepository = $blogRepository;
        $this->BlogCategoryRepository = $blogCategoryRepository;

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $locale = config('app.locale');

        $categories = Blog::groupBy('default_category')
            ->where('locale', $locale)
            ->selectRaw('default_category')
            ->selectRaw('count(*) as count')
            ->get();

        $blogRepository = $this->blogRepository->getActiveBlogs();

        return view($this->_config['view'], compact('blogRepository', 'categories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function single($id)
    {
        $blogRepository = $this->blogRepository->getSingleBlogs($id);

        return view($this->_config['view'], compact('blogRepository'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function category($id)
    {
        $locale = config('app.locale');
        
        $categories = Blog::groupBy('default_category')
            ->where('locale', $locale)
            ->selectRaw('default_category')
            ->selectRaw('count(*) as count')
            ->get();

        $blogRepository = $this->blogRepository->getBlogCategories($id);

        return view($this->_config['view'], compact('blogRepository', 'categories'));
    }
}
