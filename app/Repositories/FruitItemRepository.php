<?php

namespace App\Repositories;

use App\Models\FruitItem;
use Illuminate\Database\Eloquent\Builder;

class FruitItemRepository extends BaseRepository
{

    public function getModel()
    {
        return FruitItem::class;
    }

//    /**
//     * get Listing Query
//     * @param int $accountId
//     * @param array $whereColumn_value
//     * @param array $orderBys
//     * @param string $whereRaw
//     * @return Builder
//     */
//    public function getListingQuery($accountId, $whereColumn_value = [], $orderBys = [], $whereRaw = '')
//    {
//        $query = $this->model::join('ecommerce_stores', 'ecommerce_stores.id', '=', 'ecommerce_products.store_id')
//            ->where('ecommerce_products.account_id', $accountId)
//            ->select([
//                'ecommerce_products.id',
//                'ecommerce_products.item_id',
//                'ecommerce_products.product_name',
//                'ecommerce_products.store_id',
//                'ecommerce_stores.store_name',
//                'ecommerce_products.created_at',
//                'ecommerce_products.created_by',
//                'ecommerce_products.updated_at',
//                'ecommerce_products.updated_by',
//            ])
//        ;
//
//        return $this->extraListingQuery($query, $whereColumn_value, $orderBys, $whereRaw);
//    }

}
