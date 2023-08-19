<?php

namespace App\Http\Controllers;

use App\Services\FruitItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FruitItemController extends Controller
{

    protected FruitItemService $fruitItemService;

    public function __construct(FruitItemService $fruitItemService)
    {
        $this->fruitItemService = $fruitItemService;

        $this->fruitItemService->setAccount($this->getAccount());
    }

    /**
     * store data
     */
    public function store(Request $request)
    {
        $rules = [
            'fruit_item_name' => 'required|string|min:6|max:255',
            'unit' => ['required', Rule::in(['kg', 'pcs', 'pack'])],
            'price' => 'required|decimal:0,6|min:0.2',
            'category_id' => 'required|integer|min:1',
        ];

        $request = array_intersect_key($request->all(), $rules);

        $validator = Validator::make($request, $rules);

        if ($validator->fails()) {
            return $this->responseError('', $validator->errors(), 400);
        }

        list($data, $message) = $this->fruitItemService->create($request);
        if ($message || !($data->id ?? 0)) {
            $message = $message ?: 'Create the fruit item fail';
            return $this->responseError($message);
        }

        $message = 'Create the fruit item successfully';

        return $this->responseSuccess($data, $message);
    }

}
