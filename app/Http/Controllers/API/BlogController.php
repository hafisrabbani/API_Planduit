<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Admin\Blog\BlogService;
use App\Services\Admin\BlogCategory\BlogCategoryService;
use App\Services\Common\FileHandler\FileHandlerService;

class BlogController extends Controller
{
    private BlogService $blogService;
    private FileHandlerService $fileHandlerService;
    private BlogCategoryService $blogCategoryService;

    public function __construct(BlogService $blogService, FileHandlerService $fileHandlerService, BlogCategoryService $blogCategoryService)
    {
        $this->blogService = $blogService;
        $this->fileHandlerService = $fileHandlerService;
        $this->blogCategoryService = $blogCategoryService;
    }

    public function getAll()
    {
        try {
            $search = request()->get('search') ?? null;
            $limit = request()->get('limit') ?? 10;
            $category = request()->get('category') ?? null;
            $blogs = $this->blogService->getAll(columns:[
                'id',
                'title',
                'thumbnail',
                'description',
                'blog_category_id',
                'slug',
                'created_at'
            ],status: 'published', limit: $limit,search: $search,category: $category);
            collect($blogs)->map(function ($blog) {
                $blog->thumbnail = $this->fileHandlerService->getFile($blog->thumbnail);
                $blog->short_description = substr(strip_tags($blog->description), 0, 100);
                $blog->category_name = $blog->category->title;
//                (int)$blog->category_id = $blog->blog_category_id;
                unset($blog->category);
                unset($blog->blog_category_id);
                unset($blog->description);
                return $blog;
            });
            return response()->json(['message' => 'Success','data' => $blogs], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getDetail($id)
    {
        try {
            $blog = $this->blogService->getBySlug($id);
            if(!$blog){
                return response()->json(['message' => 'Data not found', 'data' => null], 404);
            }
            $blog->thumbnail = $this->fileHandlerService->getFile($blog->thumbnail);
            $blog->category_name = $blog->category->title;
            unset($blog->category);
            unset($blog->blog_category_id);
            return response()->json(['message' => 'Success','data' => $blog], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getAllCategory()
    {
        try {
            $categories = $this->blogCategoryService->getAllBlogCategory();
            return response()->json(['message' => 'Success','data' => $categories], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
