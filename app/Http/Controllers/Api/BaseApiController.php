<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

abstract class BaseApiController extends Controller
{
    protected string $modelClass;
    protected ?string $storeRequest = null;
    protected ?string $updateRequest = null;

    /**
     * Get paginated/filtered results
     * 
     * @param Request $request The incoming HTTP request
     * @return JsonResponse A JSON response containing the results
     */
    public function index(Request $request): JsonResponse
    {
        return $this->wrapResponse(function () use ($request) {
            return $this->handleIndex($request);
        });
    }

    /**
     * Store a new resource
     * 
     * @param Request $request The incoming HTTP request
     * @return JsonResponse A JSON response containing the created resource
     */
    public function store(Request $request): JsonResponse
    {
        if ($this->storeRequest) {
            $formRequest = app($this->storeRequest);
            $formRequest->setContainer(app())->validateResolved();
            $validatedData = $formRequest->validated();
        } else {
            $validatedData = $this->validate($request, $this->storeValidationRules());
        }

        return $this->wrapResponse(function () use ($validatedData, $request) {
            return $this->handleStore($validatedData, $request);
        }, 201);
    }

    /**
     * Show a specific resource
     * 
     * @param string|int $id The ID of the resource to show
     * @return JsonResponse A JSON response containing the requested resource
     */
    public function show($id): JsonResponse
    {
        return $this->wrapResponse(function () use ($id) {
            return $this->handleShow($id);
        });
    }

    /**
     * Update an existing resource
     * 
     * @param Request $request The incoming HTTP request
     * @param string|int $id The ID of the resource to update
     * @return JsonResponse A JSON response containing the updated resource
     */
    public function update(Request $request, string|int $id): JsonResponse
    {
        if ($this->updateRequest) {
            $formRequest = app($this->updateRequest);
            $formRequest->setContainer(app())->validateResolved();
            $validatedData = $formRequest->validated();
        } else {
            $validatedData = $this->validate($request, $this->updateValidationRules());
        }

        return $this->wrapResponse(function () use ($id, $validatedData, $request) {
            return $this->handleUpdate($id, $validatedData, $request);
        });
    }

    /**
     * Delete a resource
     * 
     * @param string|int $id The ID of the resource to delete
     * @return JsonResponse A JSON response indicating success
     */
    public function destroy($id): JsonResponse
    {
        return $this->wrapResponse(function () use ($id) {
            return $this->handleDestroy($id);
        });
    }

    /**
     * Default index handling - can be overridden
     * 
     * @param Request $request The incoming HTTP request
     * @return mixed The query results
     */
    protected function handleIndex(Request $request): mixed
    {
        return $this->getModelClass()::all();
    }

    /**
     * Default show handling - can be overridden
     * 
     * @param string|int $id The ID of the resource to show
     * @return mixed The found model instance
     * @throws ModelNotFoundException When the resource is not found
     */
    protected function handleShow($id): mixed
    {
        return $this->getModelClass()::findOrFail($id);
    }

    /**
     * Default store handling - can be overridden
     * 
     * @param array $validatedData The validated request data
     * @return mixed The created model instance
     */
    protected function handleStore(array $validatedData): mixed
    {
        return $this->getModelClass()::create($validatedData);
    }

    /**
     * Default update handling - can be overridden
     * 
     * @param string|int $id The ID of the resource to update
     * @param array $validatedData The validated request data
     * @return mixed The updated model instance
     * @throws ModelNotFoundException When the resource is not found
     */
    protected function handleUpdate(string|int $id, array $validatedData): mixed
    {
        $model = $this->getModelClass()::findOrFail($id);
        $model->update($validatedData);
        return $model;
    }

    /**
     * Default destroy handling - can be overridden
     * 
     * @param string|int $id The ID of the resource to delete
     * @return mixed|null Returns null on success
     * @throws ModelNotFoundException When the resource is not found
     */
    protected function handleDestroy(string|int $id): mixed
    {
        $model = $this->getModelClass()::findOrFail($id);
        $model->delete();
        return null;
    }

    /**
     * Wrap response with try-catch and standard format
     * 
     * @param callable $callback The callback to execute
     * @param int $successCode The HTTP status code for success
     * @return JsonResponse The wrapped response
     */
    protected function wrapResponse(callable $callback, int $successCode = 200): JsonResponse
    {
        try {
            $result = $callback();
            return $this->successResponse('Operation successful', $result, $successCode);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse('Resource not found', 404);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Standard success response
     * 
     * @param string $message The success message
     * @param mixed|null $data The response data
     * @param int $code The HTTP status code
     * @return JsonResponse The formatted success response
     */
    protected function successResponse(string $message, mixed $data = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Standard error response
     * 
     * @param string $message The error message
     * @param int $code The HTTP status code
     * @return JsonResponse The formatted error response
     */
    protected function errorResponse(string $message, int $code = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }

    /**
     * Validate request with custom error messages
     * 
     * @param Request $request The request to validate
     * @param array $rules The validation rules
     * @param array $messages Custom error messages
     * @return array The validated data
     * @throws ValidationException When validation fails
     */
    protected function validate(Request $request, array $rules, array $messages = []): array
    {
        return $request->validate($rules, $messages);
    }

    /**
     * Get the model class for this controller
     * 
     * @return string The fully qualified model class name
     */
    protected function getModelClass(): string
    {
        return $this->modelClass;
    }

    /**
     * Get validation rules for store operation
     * 
     * @return array The validation rules
     */
    protected function storeValidationRules(): array
    {
        return [];
    }

    /**
     * Get validation rules for update operation
     * 
     * @return array The validation rules
     */
    protected function updateValidationRules(): array
    {
        return [];
    }
}
