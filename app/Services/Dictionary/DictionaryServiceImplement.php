<?php

namespace App\Services\Dictionary;

use App\DTO\Admin\DictionaryDTO;
use LaravelEasyRepository\Service;
use App\Repositories\Dictionary\DictionaryRepository;

class DictionaryServiceImplement extends Service implements DictionaryService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(DictionaryRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function createDictionary(DictionaryDTO $data)
    {
        return $this->mainRepository->createDictionary($data);
    }

    public function updateDictionary(DictionaryDTO $data, int $id)
    {
        return $this->mainRepository->updateDictionary($data, $id);
    }

    public function deleteDictionary(int $id)
    {
        return $this->mainRepository->deleteDictionary($id);
    }

    public function getDictionary(int $id, $columns = ['*'])
    {
        return $this->mainRepository->getDictionary($id, $columns);
    }

    public function getAllDictionary($columns = ['*'])
    {
        return $this->mainRepository->getAllDictionary($columns);
    }

    public function getGroupDictionary($category, $columns = ['*'])
    {
        return $this->mainRepository->getGroupDictionary($category, $columns);
    }

    public function searchDictionary($search, $columns = ['*'])
    {
        return $this->mainRepository->searchDictionary($search, $columns);
    }
}
