<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;

        $this->categoryService->setAccount($this->getAccount());
    }

    /**
     * store data
     */
    public function store(Request $request)
    {
        $rules = [
            'category_name' => 'required|string|min:2|max:255',
        ];

        $request = array_intersect_key($request->all(), $rules);

        $validator = Validator::make($request, $rules);

        if ($validator->fails()) {
            return $this->responseError('', $validator->errors(), 400);
        }

        $data = $this->categoryService->create($request);
        if (is_string($data) || !($data->id ?? 0)) {
            $message = is_string($data) ? $data : 'Create the category fail';
            return $this->responseError($message);
        }

        $message = 'Create the category successfully';

        return $this->responseSuccess($data, $message);
    }

}
