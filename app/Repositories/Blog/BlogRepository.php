<?php

namespace App\Repositories\Blog;

use App\DTO\Admin\BlogDTO;
use LaravelEasyRepository\Repository;

interface BlogRepository extends Repository{
    public function getAll($columns = ['*']);
    public function getById($id, $columns = ['*']);
    public function createBlog(BlogDTO $blogDTO);
    public function updateBlog($id, BlogDTO $blogDTO);
    public function deleteBlog($id);
    public function getBlogByCategoryId($id);
    public function findRelatedBlog($id, $limit);

    public function getBySlug(string $slug);
}
