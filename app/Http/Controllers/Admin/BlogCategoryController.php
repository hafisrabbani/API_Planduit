<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\BlogCategory\BlogCategoryService;
use App\DTO\Admin\BlogCategoryDTO;
use App\Http\Requests\Admin\BlogCategoryRequest;
class BlogCategoryController extends Controller
{
    protected $blogCategoryService;

    public function __construct(BlogCategoryService $blogCategoryService)
    {
        $this->blogCategoryService = $blogCategoryService;
    }

    public function index()
    {
        try {
            $blogCategories = $this->blogCategoryService->getAllBlogCategory();
            return view('Admin.Pages.Blog-Category.index', compact('blogCategories'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function create()
    {
        return view('Admin.Pages.Blog-Category.create');
    }

    public function store(BlogCategoryRequest $request)
    {
        try {
            $request->validated();
            $blogCategoryDTO = new BlogCategoryDTO($request->title);
            $this->blogCategoryService->createBlogCategory($blogCategoryDTO);
            return response()->json(['message' => 'Blog category created successfully'], 201);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $blogCategory = $this->blogCategoryService->getBlogCategory($id);
            return view('Admin.Pages.Blog-Category.update', compact('blogCategory'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update(BlogCategoryRequest $request, $id)
    {
        try {
            $request->validated();
            $blogCategoryDTO = new BlogCategoryDTO($request->title);
            $this->blogCategoryService->updateBlogCategory($blogCategoryDTO, $id);
            return response()->json(['message' => 'Blog category updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->blogCategoryService->deleteBlogCategory($id);
            return response()->json(['message' => 'Blog category deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
