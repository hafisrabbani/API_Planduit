<?php

namespace App\Repositories\Dictionary;

use App\DTO\Admin\DictionaryDTO;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Dictionary;

class DictionaryRepositoryImplement extends Eloquent implements DictionaryRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Dictionary $model)
    {
        $this->model = $model;
    }

    public function createDictionary(DictionaryDTO $data)
    {
        try {
            $dictionary = new Dictionary();
            $dictionary->title = $data->title;
            $dictionary->description = $data->description;
            $dictionary->save();
            return $dictionary;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateDictionary(DictionaryDTO $data, int $id)
    {
        try {
            return Dictionary::where('id', $id)->update([
                'title' => $data->title,
                'description' => $data->description
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteDictionary(int $id)
    {
        try {
            $dictionary = Dictionary::findOrfail($id);
            $dictionary->delete();
            return $dictionary;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getDictionary(int $id, $columns = ['*'])
    {
        try {
            return Dictionary::findOrfail($id, $columns);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAllDictionary($columns = ['*'])
    {
        try {
            return Dictionary::select($columns)->get();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getGroupDictionary($category, $columns = ['*'])
    {
        try {
            return Dictionary::where('title', 'like', $category.'%')->get($columns);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function searchDictionary($search, $columns = ['*'])
    {
        try {
            return Dictionary::where('title', 'like', '%'.$search.'%')->get($columns);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
