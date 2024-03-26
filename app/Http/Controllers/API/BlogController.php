<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Admin\Blog\BlogService;
use App\Services\Common\FileHandler\FileHandlerService;

class BlogController extends Controller
{
    private BlogService $blogService;
    private FileHandlerService $fileHandlerService;

    public function __construct(BlogService $blogService, FileHandlerService $fileHandlerService)
    {
        $this->blogService = $blogService;
        $this->fileHandlerService = $fileHandlerService;
    }

    public function getAll()
    {
        try {
            $search = request()->get('search') ?? null;
            $limit = request()->get('limit') ?? 10;
            $blogs = $this->blogService->getAll(columns:[
                'id',
                'title',
                'thumbnail',
                'description',
                'blog_category_id',
                'slug',
                'created_at'
            ],status: 'published', limit: $limit,search: $search);
            collect($blogs)->map(function ($blog) {
                $blog->thumbnail = $this->fileHandlerService->getFile($blog->thumbnail);
                $blog->short_description = substr(strip_tags($blog->description), 0, 100);
                $blog->category_name = $blog->category->title;
                unset($blog->category);
                unset($blog->blog_category_id);
                unset($blog->description);
                return $blog;
            });
            return response()->json(['data' => $blogs], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getDetail($id)
    {
        try {
            $blog = $this->blogService->getBySlug($id);
            $blog->thumbnail = $this->fileHandlerService->getFile($blog->thumbnail);
            $blog->category_name = $blog->category->title;
            unset($blog->category);
            unset($blog->blog_category_id);
            return response()->json(['data' => $blog], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
