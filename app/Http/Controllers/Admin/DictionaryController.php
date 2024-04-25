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
        $dictionaries = $this->dictionaryService->getAllDictionary();
        return view('Admin.Pages.Dictionary.index', compact('dictionaries'));
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


    public function edit($id)
    {
        $dictionary = $this->dictionaryService->getDictionary($id);
        return view('Admin.Pages.Dictionary.update', compact('dictionary'));
    }

    public function update(DictionaryRequest $request, $id)
    {
        try {
            $request->validated();
            $dictionaryDTO = new DictionaryDTO(
                $request->title,
                $request->description
            );
            $this->dictionaryService->updateDictionary($dictionaryDTO, $id);
            return response()->json(['message' => 'Dictionary updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->dictionaryService->deleteDictionary($id);
            return response()->json(['message' => 'Dictionary deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
