<?php

namespace App\Services;

use App\Repositories\FruitItemRepository;
use App\Repositories\CategoryRepository;

class FruitItemService extends BaseService
{
    public function __construct()
    {

    }

    public function create($request)
    {
        $record = null;
        $message = '';

        $categoryId = $request['category_id'];
        $categoryRecord = (new CategoryRepository())->getByIds($categoryId, ['id', 'category_name']);
        if ( !$categoryRecord) {
            $message = 'Not found the category';
            return [$record, $message];
        }

        $fruitItemName = $request['fruit_item_name'];
        $dataInDb = (new FruitItemRepository())->getByUniques('fruit_item_name', $fruitItemName, ['id']);
        if ($dataInDb) {
            $message = 'The fruit item name is exists';
            return [$record, $message];
        }

        $createdUpdatedColumns = $this->getCreatedUpdatedColumns();
        $extraData = ['category_name' => $categoryRecord->category_name];
        $data = array_merge($request, $createdUpdatedColumns, $extraData);

        $record = (new FruitItemRepository())->insert($data);

        return [$record, $message];
    }

}
