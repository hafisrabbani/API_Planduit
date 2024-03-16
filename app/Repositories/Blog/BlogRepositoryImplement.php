<?php

namespace App\Repositories\Blog;

use App\DTO\Admin\BlogDTO;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Blog;

class BlogRepositoryImplement extends Eloquent implements BlogRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Blog $model)
    {
        $this->model = $model;
    }

    public function getAll($columns = ['*'])
    {
        try{
            return $this->model->with('blogCategory')->get($columns);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getById($id, $columns = ['*'])
    {
        try{
            return $this->model->with('blogCategory')->find($id, $columns);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createBlog(BlogDTO $blogDTO)
    {
        try{
            $this->model->create([
                'title' => $blogDTO->title,
                'description' => $blogDTO->description,
                'slug' => $blogDTO->slug,
                'blog_category_id' => $blogDTO->blog_category_id,
                'thumbnail' => $blogDTO->thumbnail,
            ]);
            return true;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateBlog($id, BlogDTO $blogDTO)
    {
        try{
            $blog = $this->model->find($id);
            $blog->update([
                'title' => $blogDTO->title,
                'description' => $blogDTO->description,
                'slug' => $blogDTO->slug,
                'blog_category_id' => $blogDTO->blog_category_id,
                'thumbnail' => $blogDTO->thumbnail,
            ]);
            return true;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteBlog($id)
    {
        try{
            $this->model->find($id)->delete();
            return true;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getBlogByCategoryId($id)
    {
        try{
            return $this->model->where('blog_category_id', $id)->get();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findRelatedBlog($id, $limit = 5)
    {
        try{
            return $this->model->where('blog_category_id', $id)->where('id', '!=', $id)->limit($limit)->get();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getBySlug(string $slug)
    {
        try{
            return $this->model->where('slug', $slug)->first();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
