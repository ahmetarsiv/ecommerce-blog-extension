<?php

namespace Webkul\Blog\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Webkul\Core\Eloquent\Repository;

class BlogRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Blog\Models\Blog';
    }

    /**
     * Save blog.
     *
     * @param  array  $data
     * @return bool|\Webkul\Blog\Contracts\Blog
     */
    public function save(array $data)
    {
        Event::dispatch('admin.blogs.create.before', $data);

        $dir = 'blog_images/';

        $uploaded = $image = false;

        if (isset($data['image'])) {
            $image = $first = Arr::first($data['image'], function ($value, $key) {
                if ($value) {
                    return $value;
                } else {
                    return false;
                }
            });
        }

        if ($image != false) {
            $uploaded = $image->store($dir);

            unset($data['image'], $data['_token']);
        }

        if ($uploaded) {
            $data['image'] = $uploaded;
        } else {
            unset($data['image']);
        }

        $blog = $this->create($data);

        Event::dispatch('admin.blogs.create.after', $blog);

        return true;
    }

    /**
     * Update item.
     *
     * @param  array  $data
     * @param  int  $id
     * @return bool
     */
    public function updateItem(array $data, $id)
    {
        Event::dispatch('admin.blogs.update.before', $id);

        $dir = 'blog_images/';

        $uploaded = $image = false;

        if (isset($data['image'])) {
            $image = $first = Arr::first($data['image'], function ($value, $key) {
                return $value ? $value : false;
            });
        }

        if ($image != false) {
            $uploaded = $image->store($dir);

            unset($data['image'], $data['_token']);
        }

        if ($uploaded) {
            $blogItem = $this->find($id);

            Storage::delete($blogItem->image);

            $data['image'] = $uploaded;
        } else {
            unset($data['image']);
        }

        $blog = $this->update($data, $id);

        Event::dispatch('admin.blogs.update.after', $blog);

        return true;
    }

    /**
     * Delete a blog item and delete the image from the disk or where ever it is.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        $blogItem = $this->find($id);

        $blogItemImage = $blogItem->image;

        Storage::delete($blogItemImage);

        return $this->model->destroy($id);
    }

    /**
     * Get only active blogs.
     *
     * @return array
     */
    public function getActiveBlogs()
    {
        $currentLocale = core()->getCurrentLocale();

        return $this->whereRaw("find_in_set(?, locale)", [$currentLocale->code])
            ->where(function ($query) {
                $query->where('published_at', '>=', Carbon::now()->format('Y-m-d'))
                    ->orWhereNull('published_at');
            })
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->toArray();
    }
}