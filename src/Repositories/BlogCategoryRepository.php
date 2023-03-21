<?php

namespace Webkul\Article\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

class BlogCategoryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Article\Models\Category';
    }

    /**
     * Save blog category.
     *
     * @param  array  $data
     * @return bool|\Webkul\Article\Contracts\Category
     */
    public function save(array $data)
    {
        Event::dispatch('admin.blog.categories.create.before', $data);

        $dir = 'category_images/';

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

        $categories = $this->create($data);

        Event::dispatch('admin.blog.categories.create.after', $categories);

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
        Event::dispatch('admin.blog.categories.update.before', $id);

        $dir = 'category_images/';

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
            $categoryItem = $this->find($id);

            Storage::delete($categoryItem->image);

            $data['image'] = $uploaded;
        } else {
            unset($data['image']);
        }

        $categories = $this->update($data, $id);

        Event::dispatch('admin.blog.categories.update.after', $categories);

        return true;
    }

    /**
     * Delete a blog category item and delete the image from the disk or where ever it is.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        $categoryItem = $this->find($id);

        $categoryItemImage = $categoryItem->image;

        Storage::delete($categoryItemImage);

        return $this->model->destroy($id);
    }

    /**
     * Get only active blog categories.
     *
     * @return array
     */
    public function getActiveBlogCategories()
    {
        $currentLocale = core()->getCurrentLocale();

        return $this->whereRaw("find_in_set(?, locale)", [$currentLocale->code])
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->toArray();
    }
}