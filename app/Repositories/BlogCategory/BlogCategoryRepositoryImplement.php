<?php

namespace App\Repositories\BlogCategory;

use App\DTO\Admin\BlogCategoryDTO;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\BlogCategory;

class BlogCategoryRepositoryImplement extends Eloquent implements BlogCategoryRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(BlogCategory $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function createBlogCategory(BlogCategoryDTO $data)
    {
        try {
            $blogCategory = new BlogCategory();
            $blogCategory->title = $data->title;
            $blogCategory->save();
            return $blogCategory;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateBlogCategory(BlogCategoryDTO $data, int $id)
    {
        try {
            $blogCategory = BlogCategory::where('id', $id)->update(['title' => $data->title]);
            return $blogCategory;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteBlogCategory(int $id)
    {
        try {
            $blogCategory = BlogCategory::findOrfail($id);
            $blogCategory->delete();
            return $blogCategory;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getBlogCategory(int $id, $columns = ['*'])
    {
        try {
            $blogCategory = BlogCategory::findOrfail($id);
            return $blogCategory;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAllBlogCategory($columns = ['*'])
    {
        try {
            $blogCategory = BlogCategory::all($columns);
            return $blogCategory;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getBlogCategoryByTitle(string $title, $columns = ['*'])
    {
        try {
            $blogCategory = BlogCategory::where('title', $title)->first($columns);
            return $blogCategory;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
