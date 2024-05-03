<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Dictionary\DictionaryService;
use function Laravel\Prompts\search;

class DictionaryController extends Controller
{
    private DictionaryService $dictionaryService;

    public function __construct(DictionaryService $dictionaryService)
    {
        $this->dictionaryService = $dictionaryService;
    }


    public function index()
    {
        try {
            request()->validate([
                'search' => 'string',
                'group' => 'string|required'
            ]);
            $query = request()->query('search');
            $group = request()->query('group');
            $dictionaries = $this->dictionaryService->getGroupDictionary(['id','title'],$query, $group);
            return response()->json([
                'message' => 'success',
                'data' => $dictionaries
            ], 200);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function detail($id){
        try {
            $dictionary = $this->dictionaryService->getDictionary($id, [
                'id',
                'title',
                'description',
            ]);
            if (!$dictionary) {
                return response()->json(['message' => 'Data not found', 'data' => null], 404);
            }
            return response()->json([
                'message' => 'success',
                'data' => $dictionary
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
