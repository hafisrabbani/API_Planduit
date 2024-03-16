<?php

namespace App\Services\Admin\BlogCategory;

use App\DTO\Admin\BlogCategoryDTO;
use LaravelEasyRepository\BaseService;

interface BlogCategoryService extends BaseService{
    public function createBlogCategory(BlogCategoryDTO $blogCategoryDTO);
    public function updateBlogCategory(BlogCategoryDTO $blogCategoryDTO, int $id);
    public function deleteBlogCategory(int $id);
    public function getBlogCategory(int $id, $columns = ['*']);
    public function getAllBlogCategory($columns = ['*']);
}
