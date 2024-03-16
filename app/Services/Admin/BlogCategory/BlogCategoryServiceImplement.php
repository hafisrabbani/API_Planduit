<?php

namespace App\Services\Admin\BlogCategory;

use App\DTO\Admin\BlogCategoryDTO;
use LaravelEasyRepository\Service;
use App\Repositories\BlogCategory\BlogCategoryRepository;

class BlogCategoryServiceImplement extends Service implements BlogCategoryService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(BlogCategoryRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function createBlogCategory(BlogCategoryDTO $blogCategoryDTO)
    {
        try {
            return $this->mainRepository->createBlogCategory($blogCategoryDTO);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateBlogCategory(BlogCategoryDTO $blogCategoryDTO, int $id)
    {
        try {
            return $this->mainRepository->updateBlogCategory($blogCategoryDTO, $id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteBlogCategory(int $id)
    {
        try {
            return $this->mainRepository->deleteBlogCategory($id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getBlogCategory(int $id, $columns = ['*'])
    {
        try {
            return $this->mainRepository->getBlogCategory($id, $columns);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAllBlogCategory($columns = ['*'])
    {
        try {
            return $this->mainRepository->getAllBlogCategory($columns);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
