<?php

namespace App\Repositories\Dictionary;

use App\DTO\Admin\DictionaryDTO;
use App\Models\Dictionary;
use LaravelEasyRepository\Implementations\Eloquent;

class DictionaryRepositoryImplement extends Eloquent implements DictionaryRepository
{

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

    public function getAllDictionary($columns = ['*'], $search = null,$limit = 10)
    {
        try {
            return Dictionary::select($columns)->orderBy('title', 'asc')->when($search,function ($query) use ($search) {
                return $query->where('title', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
            })->paginate($limit);
            dd($limit);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getGroupDictionary($columns = ['*'],$search = null, $group = 'A')
    {
        try {
            if($search !== null) {
                return Dictionary::select($columns)->orderBy('title', 'asc')->where('title', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%')->get();
            }
            return Dictionary::select($columns)->where('title', 'like', $group . '%')->orderBy('title', 'asc')->get();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
