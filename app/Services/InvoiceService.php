<?php

namespace App\Services;

use App\Repositories\FruitItemRepository;
use App\Repositories\InvoiceInfoRepository;
use App\Repositories\InvoiceItemRepository;
use Illuminate\Support\Str;

class InvoiceService extends BaseService
{

    public function __construct()
    {

    }

    public function create($request)
    {
        $recordId = 0;
        $message = '';

        $fruitData = $request['fruit_data'];
        $assocFruitId_quantity = array_column($fruitData, 'quantity', 'fruit_id');
        $fruitIds = array_keys($assocFruitId_quantity);

        $fruitColumns = [
            'id as fruit_id',
            'fruit_item_name as fruit_name',
            'unit',
            'price',
            'category_id',
            'category_name',
        ];
        $fruitDataInDb = (new FruitItemRepository())->getByIds($fruitIds, $fruitColumns);
        if (count($fruitIds) != $fruitDataInDb->count()) {
            $message = 'Fruit is not equal with data in the system';
            return [$recordId, $message];
        }

        $totalAmount = 0;
        foreach ($fruitDataInDb as $fruitInDb) {
            $quantity = $assocFruitId_quantity[$fruitInDb->fruit_id];

            $amount = $fruitInDb->price * $quantity;
            $totalAmount += $amount;

            $fruitInDb->quantity = $quantity;
            $fruitInDb->amount = $amount;
        }

        $createdUpdatedColumns = $this->getCreatedUpdatedColumns();
        $extraInvoiceData = [
            'code' => strtoupper(Str::random()),
            'customer_name' => $request['customer_name'],
            'total_amount' => $totalAmount,
        ];

        $dataInvoice = array_merge($createdUpdatedColumns, $extraInvoiceData);

        $recordInvoice = (new InvoiceInfoRepository())->insert($dataInvoice);
        $recordId = $recordInvoice->id;

        $createdUpdatedColumns['invoice_id'] = $recordId;
        $invoiceItem = array_map(function ($item) use ($createdUpdatedColumns) {
            $item = array_merge($item, $createdUpdatedColumns);

            return $item;
        }, $fruitDataInDb->toArray());

        (new InvoiceItemRepository())->upsert($invoiceItem, ['invoice_id', 'fruit_id'], ['updated_at', 'updated_by']);

        return [$recordId, $message];
    }

    public function update($request)
    {
        $message = '';

        $invoiceColumns = [
            'id',
        ];

        $recordId = $request['id'];
        unset($request['id']);

        $invoiceRecord = (new InvoiceInfoRepository())->getByIds($recordId, $invoiceColumns);
        if ( !$invoiceRecord) {
            return $message = 'Not found the invoice';
        }

        $fruitData = $request['fruit_data'];
        $assocFruitId_quantity = array_column($fruitData, 'quantity', 'fruit_id');
        $fruitIds = array_keys($assocFruitId_quantity);

        $fruitColumns = [
            'id as fruit_id',
            'fruit_item_name as fruit_name',
            'unit',
            'price',
            'category_id',
            'category_name',
        ];
        $fruitDataInDb = (new FruitItemRepository())->getByIds($fruitIds, $fruitColumns);
        if (count($fruitIds) != $fruitDataInDb->count()) {
            return $message = 'Fruit is not equal with data in the system';
        }

        $totalAmount = 0;
        foreach ($fruitDataInDb as $fruitInDb) {
            $quantity = $assocFruitId_quantity[$fruitInDb->fruit_id];

            $amount = $fruitInDb->price * $quantity;
            $totalAmount += $amount;

            $fruitInDb->quantity = $quantity;
            $fruitInDb->amount = $amount;
        }

        $createdUpdatedColumns = $this->getCreatedUpdatedColumns();
        $extraInvoiceData = [
            'customer_name' => $request['customer_name'],
            'total_amount' => $totalAmount,
        ];

        $dataInvoice = array_merge($this->getUpdatedColumns(), $extraInvoiceData);
        $numberOfSuccess = (new InvoiceInfoRepository())->updateById($recordId, $dataInvoice);

        $createdUpdatedColumns['invoice_id'] = $recordId;
        $invoiceItem = array_map(function ($item) use ($createdUpdatedColumns) {
            $item = array_merge($item, $createdUpdatedColumns);

            return $item;
        }, $fruitDataInDb->toArray());

        (new InvoiceItemRepository())->upsert($invoiceItem, ['invoice_id', 'fruit_id'], ['unit', 'price', 'quantity', 'amount', 'updated_at', 'updated_by']);

        return $message;
    }

    public function delete($request)
    {
        $columns = [
            'id',
        ];

        $message = '';

        $ids = $request['id'];

        $totalInRequest = count($ids);

        $data = (new InvoiceInfoRepository())->getByIds($ids, $columns);
        $totalInDb = $data->count();

        if ($totalInRequest != $totalInDb) {
            return $message = 'The number of invoices is not equal in the system';
        }

        $totalSuccess = (new InvoiceInfoRepository())->deleteByIds($ids);

        if ( !$totalSuccess) {
            return $message = 'Delete the invoices fail';
        }

        return $message;
    }

}
