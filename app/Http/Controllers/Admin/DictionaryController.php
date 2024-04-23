<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DictionaryRequest;
use App\Services\Dictionary\DictionaryService;
use App\DTO\Admin\DictionaryDTO;

class DictionaryController extends Controller
{
    protected DictionaryService $dictionaryService;

    public function __construct(DictionaryService $dictionaryService)
    {
        $this->dictionaryService = $dictionaryService;
    }

    public function index()
    {
        $dictionaries = $this->dictionaryService->all();
        return view('Admin.Pages.Dictionary.index');
    }

    public function create()
    {
        return view('Admin.Pages.Dictionary.create');
    }

    public function store(DictionaryRequest $request)
    {
        try {
            $request->validated();
            $dictionaryDTO = new DictionaryDTO(
                $request->title,
                $request->description
            );
            $this->dictionaryService->createDictionary($dictionaryDTO);
            return response()->json(['message' => 'Dictionary created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
