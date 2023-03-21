<?php

namespace Webkul\Article\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\Article\Models\Blog;
use Webkul\Article\Models\Category;

class ArticleController extends Controller
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
    public function __construct()
    {
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $blogs = Blog::where('status', 1)->paginate(9);

        $categories = Blog::groupBy('default_category')->selectRaw('default_category')->selectRaw('count(*) as count')->get();

        return view($this->_config['view'], compact('blogs', 'categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function view($blog_slug, $slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();

        $categories = Blog::groupBy('default_category')->selectRaw('default_category')->selectRaw('count(*) as count')->get();

        return view($this->_config['view'], compact('blog', 'categories'));
    }
}
