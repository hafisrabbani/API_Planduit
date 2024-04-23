<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Blog\BlogService;
use App\DTO\Admin\BlogDTO;
use App\Http\Requests\Admin\BlogRequest;
use App\Services\Admin\BlogCategory\BlogCategoryService;
use App\Services\Common\FileHandler\FileHandlerService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BlogController extends Controller
{
    private BlogService $blogService;
    private BlogCategoryService $blogCategoryService;
    private FileHandlerService $fileHandlerService;

    public function __construct(BlogService $blogService, BlogCategoryService $blogCategoryService, FileHandlerService $fileHandlerService)
    {
        $this->blogService = $blogService;
        $this->blogCategoryService = $blogCategoryService;
        $this->fileHandlerService = $fileHandlerService;
    }

    public function index()
    {
        try {
            $blogs = $this->blogService->getAll();
            return view('Admin.Pages.Blog.index', compact('blogs'));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        $blogCategories = $this->blogCategoryService->getAllBlogCategory([
            'id',
            'title'
        ]);
        return view('Admin.Pages.Blog.create',compact('blogCategories'));
    }

    public function store(BlogRequest $request)
    {
        try {
            $request->validated();
            $generatedSlug = $this->blogService->generateSlug($request->title);
            $file = $request->file('thumbnail');
            $fileName = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
            $path = 'blog';
            $fileUpload = $this->fileHandlerService->uploadFile($file, $path, $fileName);
            $blogDTO = new BlogDTO(
                $request->title,
                $request->description,
                $request->blog_category_id,
                thumbnail: $fileUpload,
                slug: $generatedSlug,
                status: $request->status
            );
            $this->blogService->createBlog($blogDTO);
            return response()->json(['message' => 'Blog created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $blog = $this->blogService->getById($id);
            $blogCategories = $this->blogCategoryService->getAllBlogCategory([
                'id',
                'title'
            ]);
            $blog->thumbnail = $this->fileHandlerService->getFile($blog->thumbnail);
            return view('Admin.Pages.Blog.update', compact('blog', 'blogCategories'));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(BlogRequest $request, $id)
    {
        try {
            $request->validated();
            $dataBlog = $this->blogService->getById($id);
            if($request->hasFile('thumbnail')){
                $file = $request->file('thumbnail');
                $fileName = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                $path = 'blog';
                $uploadFile = $this->fileHandlerService->uploadFile($file, $path, $fileName);
            }else{
                $uploadFile = $dataBlog->thumbnail;
            }
            $blogDTO = new BlogDTO(
                title: $request->title,
                description: $request->description,
                blog_category_id: $request->blog_category_id,
                thumbnail: $uploadFile,
                slug: $dataBlog->slug,
                status: $request->status
            );
            $this->blogService->updateBlog($id, $blogDTO);
            return response()->json(['message' => 'Blog updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->blogService->delete($id);
            return response()->json(['message' => 'Blog deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $blog = $this->blogService->getById($id);
            return view('Admin.Pages.Blog.show', compact('blog'));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function ckeditorUpload(Request $request)
    {
        {
            try {
                 $request->validate([
                    'upload' => 'required|mimes:jpeg,jpg,png,gif|max:2048'
                ]);
                $file = $request->file('upload');
                $fileName = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                $path = 'uploads/ckeditor';

                $uploadedFile = $this->fileHandlerService->uploadFile($file, $path, $fileName);
                $imgUrl = $this->fileHandlerService->getFile($uploadedFile);
                return response()->json([
                    'uploaded' => 1,
                    'fileName' => $fileName,
                    'url' => $imgUrl
                ]);

            } catch (\Exception $e) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }
    }
}
