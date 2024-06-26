<?php

namespace App\Repositories\Blog;

use App\DTO\Admin\BlogDTO;
use LaravelEasyRepository\Repository;

interface BlogRepository extends Repository{
    public function getAll($columns = ['*'],$status = null, $limit = null, $orderBy = 'created_at', $sortBy = 'desc', $search = null, $category = null);
    public function getById($id, $columns = ['*']);
    public function createBlog(BlogDTO $blogDTO);
    public function updateBlog($id, BlogDTO $blogDTO);
    public function deleteBlog($id);
    public function getBlogByCategoryId($id);
    public function findRelatedBlog($id, $limit);

    public function getBySlug(string $slug);
}
