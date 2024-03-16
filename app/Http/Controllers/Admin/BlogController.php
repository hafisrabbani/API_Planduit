<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Blog\BlogService;
use App\DTO\Admin\BlogDTO;
use App\Http\Requests\Admin\BlogRequest;
class BlogController extends Controller
{
    private BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index()
    {
        try {
            $blogs = $this->blogService->getAll();
            return view('admin.blog.index', compact('blogs'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(BlogRequest $request)
    {
        try {
            $request->validated();
            $generatedSlug = $this->blogService->generateSlug($request->title);
            $blogDTO = new BlogDTO(
                $request->title,
                $request->description,
                $request->blog_category_id,
                $request->thumbnail,
                slug: $generatedSlug
            );
            $this->blogService->create($blogDTO);
            return response()->json(['message' => 'Blog created successfully'], 201);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $blog = $this->blogService->getById($id);
            return view('admin.blog.edit', compact('blog'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update(BlogRequest $request, $id)
    {
        try {
            $request->validated();
            $blogDTO = new BlogDTO(
                $request->title,
                $request->description,
                $request->blog_category_id,
                $request->thumbnail
            );
            $this->blogService->update($id, $blogDTO);
            return response()->json(['message' => 'Blog updated successfully'], 200);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->blogService->delete($id);
            return response()->json(['message' => 'Blog deleted successfully'], 200);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $blog = $this->blogService->getById($id);
            return view('admin.blog.show', compact('blog'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
