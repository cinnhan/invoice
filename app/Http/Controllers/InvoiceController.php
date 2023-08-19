<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{

    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;

        $this->invoiceService->setAccount($this->getAccount());
    }

    /**
     * store data
     */
    public function store(Request $request)
    {
        $rules = [
            'customer_name' => 'required|string|min:2|max:255',
            'fruit_data' => 'required|array',
            'fruit_data.*.fruit_id' => 'required|integer|min:1',
            'fruit_data.*.quantity' => 'required|integer|min:1',
        ];

        $request = array_intersect_key($request->all(), $rules);

        $validator = Validator::make($request, $rules);

        if ($validator->fails()) {
            return $this->responseError('', $validator->errors(), 400);
        }

        list($id, $message) = $this->invoiceService->create($request);
        if ( !$id || $message) {
            $message = $message ?: 'Create invoice fail';
            return $this->responseError($message);
        }

        $data = compact('id');
        $message = 'Create invoice successfully';

        return $this->responseSuccess($data, $message);
    }

    /**
     * update data
     */
    public function update(Request $request)
    {
        $rules = [
            'id' => 'required|integer|min:1',
            'customer_name' => 'required|string|min:2|max:255',
            'fruit_data' => 'required|array',
            'fruit_data.*.fruit_id' => 'required|integer|min:1',
            'fruit_data.*.quantity' => 'required|integer|min:1',
        ];

        $request = array_intersect_key($request->all(), $rules);

        $validator = Validator::make($request, $rules);

        if ($validator->fails()) {
            return $this->responseError('', $validator->errors(), 400);
        }

        $message = $this->invoiceService->update($request);
        if ($message) {
            return $this->responseError($message);
        }

        $data = [];
        $message = 'Update the invoice successfully';
        return $this->responseSuccess($data, $message);
    }

    /**
     * destroy data
     */
    public function destroy(Request $request)
    {
        $rules = [
            'id' => 'required|array',
            'id.*' => 'integer|min:1',
        ];

        $request = array_intersect_key($request->all(), $rules);

        $validator = Validator::make($request, $rules);

        if ($validator->fails()) {
            return $this->responseError('', $validator->errors(), 400);
        }

        $message = $this->invoiceService->delete($request);
        if ($message) {
            return $this->responseError($message);
        }

        $data = [];
        $message = 'Delete the invoice successfully';
        return $this->responseSuccess($data, $message);
    }

}
