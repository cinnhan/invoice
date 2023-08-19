<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService extends BaseService
{

    public function __construct()
    {

    }

    public function create($request)
    {
        $categoryName = $request['category_name'];
        $dataInDb = (new CategoryRepository())->getByUniques('category_name', $categoryName, ['id']);
        if ($dataInDb) {
            return $message = 'The category name is exists';
        }

        $createdUpdatedColumns = $this->getCreatedUpdatedColumns();
        $data = array_merge($request, $createdUpdatedColumns);

        $record = (new CategoryRepository())->insert($data);

        return $record;
    }

}
