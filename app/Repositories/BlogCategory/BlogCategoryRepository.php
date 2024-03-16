<?php

namespace App\Repositories\BlogCategory;

use App\DTO\Admin\BlogCategoryDTO;
use LaravelEasyRepository\Repository;

interface BlogCategoryRepository extends Repository{
    public function createBlogCategory(BlogCategoryDTO $data);
    public function updateBlogCategory(BlogCategoryDTO $data, int $id);
    public function deleteBlogCategory(int $id);
    public function getBlogCategory(int $id, $columns = ['*']);
    public function getAllBlogCategory($columns = ['*']);
    public function getBlogCategoryByTitle(string $title, $columns = ['*']);
}
