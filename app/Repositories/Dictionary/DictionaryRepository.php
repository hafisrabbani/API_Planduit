<?php

namespace App\Repositories\Dictionary;

use App\DTO\Admin\DictionaryDTO;
use LaravelEasyRepository\Repository;

interface DictionaryRepository extends Repository
{
    public function createDictionary(DictionaryDTO $data);

    public function updateDictionary(DictionaryDTO $data, int $id);

    public function deleteDictionary(int $id);

    public function getDictionary(int $id, $columns = ['*']);

    public function getAllDictionary($columns = ['*'], $search = null, $limit = 10);

    public function getGroupDictionary($columns = ['*'], $search = null, $group = 'A');

    public function getRandomDictionary($total = 1);
}
