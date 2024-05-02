<?php

namespace App\Repositories\Blog;

use App\DTO\Admin\BlogDTO;
use App\Models\Blog;
use LaravelEasyRepository\Implementations\Eloquent;

class BlogRepositoryImplement extends Eloquent implements BlogRepository
{

    protected $model;

    public function __construct(Blog $model)
    {
        $this->model = $model;
    }

    public function getAll($columns = ['*'], $status = null, $limit = null, $orderBy = 'created_at', $sortBy = 'desc', $search = null, $category = null)
    {
        try {
            if (!$category) {
                return $this->model->with('category')->when($status, function ($query) use ($status) {
                    return $query->where('status', $status);
                })->when($search, function ($query) use ($search) {
                    return $query->where('title', 'like', '%' . $search . '%');
                })->orderBy($orderBy, $sortBy)->limit($limit)->get($columns);
            }
            return $this->model->with('category')->where('blog_category_id', $category)->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })->orderBy($orderBy, $sortBy)->limit($limit)->get($columns);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getById($id, $columns = ['*'])
    {
        try {
            return $this->model->with('category')->find($id, $columns);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createBlog(BlogDTO $blogDTO)
    {
        try {
            $blog = new Blog();
            $blog->title = $blogDTO->title;
            $blog->description = $blogDTO->description;
            $blog->slug = $blogDTO->slug;
            $blog->blog_category_id = $blogDTO->blog_category_id;
            $blog->thumbnail = $blogDTO->thumbnail;
            $blog->status = $blogDTO->status;
            $blog->save();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateBlog($id, BlogDTO $blogDTO)
    {
        try {
            $blog = $this->model->find($id);
            $blog->title = $blogDTO->title;
            $blog->description = $blogDTO->description;
            $blog->slug = $blogDTO->slug;
            $blog->blog_category_id = $blogDTO->blog_category_id;
            $blog->thumbnail = $blogDTO->thumbnail;
            $blog->status = $blogDTO->status;
            $blog->save();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteBlog($id)
    {
        try {
            $this->model->find($id)->delete();
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getBlogByCategoryId($id)
    {
        try {
            return $this->model->where('blog_category_id', $id)->where('status', 'published')->get();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findRelatedBlog($id, $limit = 5)
    {
        try {
            return $this->model->where('blog_category_id', $id)->where('id', '!=', $id)->limit($limit)->where('status', 'published')->get();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getBySlug(string $slug)
    {
        try {
            return $this->model->where('slug', $slug)->where('status', 'published')->first();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
