<?php

namespace Webkul\Article\Repositories;

use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;

class BlogCommentRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Article\Models\Comment';
    }

    /**
     * Save blog tag.
     *
     * @param  array  $data
     * @return bool|\Webkul\Article\Contracts\Comment
     */
    public function save(array $data)
    {
        //
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
        Event::dispatch('admin.blog.comments.update.before', $id);

        $tag = $this->update($data, $id);

        Event::dispatch('admin.blog.comments.update.after', $tag);

        return true;
    }

    /**
     * Delete a blog tag item and delete the image from the disk or where ever it is.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        Event::dispatch('admin.blog.comments.delete.before', $id);

        parent::delete($id);

        Event::dispatch('admin.blog.comments.delete.after', $id);
    }

    /**
     * Get only active blog tags.
     *
     * @return array
     */
    public function getActiveBlogComments()
    {
        $currentLocale = core()->getCurrentLocale();

        return $this->whereRaw("find_in_set(?, locale)", [$currentLocale->code])
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->toArray();
    }
}