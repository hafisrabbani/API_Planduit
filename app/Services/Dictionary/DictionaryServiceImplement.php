<?php

namespace App\Services\Dictionary;

use App\DTO\Admin\DictionaryDTO;
use App\Repositories\Dictionary\DictionaryRepository;
use LaravelEasyRepository\Service;

class DictionaryServiceImplement extends Service implements DictionaryService
{

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

    public function getAllDictionary($columns = ['*'], $search = null, $limit = 10)
    {
        return $this->mainRepository->getAllDictionary($columns, $search, $limit);
    }

    public function getGroupDictionary($columns = ['*'], $search = null, $group = 'A')
    {
        return $this->mainRepository->getGroupDictionary($columns, $search, $group);
    }

    public function getRandomDictionary($total = 1)
    {
        return $this->mainRepository->getRandomDictionary($total);
    }
}
