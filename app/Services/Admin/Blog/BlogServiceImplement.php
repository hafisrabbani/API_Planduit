<?php

namespace App\Services\Admin\Blog;

use App\DTO\Admin\BlogDTO;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use LaravelEasyRepository\Service;
use App\Repositories\Blog\BlogRepository;

class BlogServiceImplement extends Service implements BlogService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(BlogRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function getAll($columns = ['*'])
    {
        return $this->mainRepository->getAll($columns);
    }

    public function getById($id, $columns = ['*'])
    {
        return $this->mainRepository->getById($id, $columns);
    }

    public function createBlog(BlogDTO $blogDTO)
    {
        return $this->mainRepository->createBlog($blogDTO);
    }

    public function updateBlog($id, BlogDTO $blogDTO)
    {
        return $this->mainRepository->updateBlog($id, $blogDTO);
    }

    public function deleteBlog($id)
    {
        return $this->mainRepository->deleteBlog($id);
    }

    public function getBlogByCategoryId($id)
    {
        return $this->mainRepository->getBlogByCategoryId($id);
    }

    public function findRelatedBlog($id, $limit)
    {
        return $this->mainRepository->findRelatedBlog($id, $limit);
    }

    public function generateSlug($title, $id = null): string
    {
        try {
            $slug = Str::slug($title, '-');
            $data = $id ? $this->mainRepository->getById($id) : $this->mainRepository->getBySlug($slug);

            if ($data && $data->slug == $slug) {
                return $slug;
            }

            return $data ? $slug . '-' . Carbon::now()->timestamp : $slug;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
