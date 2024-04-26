<?php

namespace App\Services\Dictionary;

use App\DTO\Admin\DictionaryDTO;
use LaravelEasyRepository\BaseService;

interface DictionaryService extends BaseService{
    public function createDictionary(DictionaryDTO $data);
    public function updateDictionary(DictionaryDTO $data, int $id);
    public function deleteDictionary(int $id);
    public function getDictionary(int $id, $columns = ['*']);
    public function getAllDictionary($columns = ['*'], $search = null, $limit = 10);
    public function getGroupDictionary($columns = ['*'],$search = null, $group = 'A');
}
