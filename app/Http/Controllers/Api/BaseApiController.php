<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Exception;
use Illuminate\Http\Request;

abstract class BaseApiController extends Controller
{
    protected string $modelClass;

    public function index()
    {
        try {
            $data = $this->getModelClass()::all();
            return $this->jsonResponse(true, 'Resource fetched successfully', $data);
        } catch (Exception $e) {
            return $this->jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(Request $request, ?callable $handler = null)
    {
        $validatedData = $request->validate($this->storeValidationRules());

        try {
            $resource = $handler ? $handler($validatedData) : $this->getModelClass()::create($validatedData);

            return $this->jsonResponse(true, 'Resource created successfully', $resource, 201);
        } catch (Exception $e) {
            return $this->jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $resource = $this->getModelClass()::findOrFail($id);
            return $this->jsonResponse(true, 'Resource fetched successfully', $resource);
        } catch (Exception $e) {
            return $this->jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(Request $request, $id, ?callable $handler = null)
    {
        $validatedData = $request->validate($this->updateValidationRules());

        try {
            $resource = null;

            if ($handler) {
                $resource = $handler($validatedData);
            } else {
                $resource = $this->getModelClass()::findOrFail($id);
                $resource->update($validatedData);
            }

            return $this->jsonResponse(true, 'Resource updated successfully', $resource);
        } catch (Exception $e) {
            return $this->jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $resource = $this->getModelClass()::findOrFail($id);
            $resource->delete();
            return $this->jsonResponse(true, 'Resource deleted successfully');
        } catch (Exception $e) {
            return $this->jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    protected function jsonResponse(bool $success, string $message, mixed $data = null, int $statusCode = 200)
    {
        $response = new ApiResponse($success, $message, $data);
        return response()->json($response, $statusCode);
    }

    protected function storeValidationRules(): array
    {
        return [];
    }

    protected function updateValidationRules(): array
    {
        return $this->storeValidationRules();
    }

    protected function getModelClass()
    {
        if (!class_exists($this->modelClass)) {
            throw new Exception("Model class {$this->modelClass} does not exist.");
        }
        return $this->modelClass;
    }
}
