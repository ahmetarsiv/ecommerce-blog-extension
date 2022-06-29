<?php

namespace Webkul\Blog\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Webkul\Blog\Datagrids\CategoryDataGrid;
use Webkul\Blog\Repositories\BlogCategoryRepository;

class AdminCategoryController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
    public function __construct(protected BlogCategoryRepository $blogCategoryRepository)
    {
        $this->middleware('admin');

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(CategoryDataGrid::class)->toJson();
        }

        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $locale = core()->getRequestedLocaleCode();

        return view($this->_config['view'])->with('locale', $locale);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'slug'                  => 'slug', 'unique',
            'name'                  => 'required',
            'image.*'               => 'required|mimes:bmp,jpeg,jpg,png,webp',
            'description'           => 'required',
        ]);

        $data = request()->all();

        if (is_array($data['locale'])) {
            $data['locale'] = implode(',', $data['locale']);
        }

        $result = $this->blogCategoryRepository->save($data);

        if ($result) {
            session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Category']));
        } else {
            session()->flash('success', trans('blog::app.category.created-fault'));
        }

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $categories = $this->blogCategoryRepository->findOrFail($id);

        return view($this->_config['view'], compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(request(), [
            'slug'                  => 'slug', 'unique',
            'name'                  => 'required',
            'image'                 => 'required',
            'description'           => 'required',
        ]);

        $data = request()->all();

        if (is_array($data['locale'])) {
            $data['locale'] = implode(',', $data['locale']);
        }

        if (is_null(request()->image)) {
            session()->flash('error', trans('blog::app.category.updated-fault'));

            return redirect()->back();
        }

        $result = $this->blogCategoryRepository->updateItem($data, $id);

        if ($result) {
            session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Category']));
        } else {
            session()->flash('error', trans('blog::app.category.updated-fault'));
        }

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->blogCategoryRepository->findOrFail($id);

        try {
            $this->blogCategoryRepository->delete($id);

            return response()->json(['message' => trans('admin::app.response.delete-success', ['name' => 'Category'])]);
        } catch (\Exception $e) {
            report($e);
        }

        return response()->json(['message' => trans('admin::app.response.delete-failed', ['name' => 'Category'])], 500);
    }

    /**
     * Remove the specified resources from database.
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $suppressFlash = false;

        if (request()->isMethod('post')) {
            $indexes = explode(',', request()->input('indexes'));

            foreach ($indexes as $key => $value) {
                try {
                    $this->blogCategoryRepository->delete($value);
                } catch (\Exception $e) {
                    $suppressFlash = true;

                    continue;
                }
            }

            if (! $suppressFlash) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', ['resource' => 'Category']));
            } else {
                session()->flash('info', trans('admin::app.datagrid.mass-ops.partial-action', ['resource' => 'Category']));
            }

            return redirect()->back();
        } else {
            session()->flash('error', trans('admin::app.datagrid.mass-ops.method-error'));

            return redirect()->back();
        }
    }
}
