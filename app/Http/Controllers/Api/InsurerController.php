<?php

namespace App\Http\Controllers\Api;

use App\Models\Insurer;

class InsurerController extends BaseApiController
{
    protected string $modelClass = Insurer::class;

    protected function storeValidationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:255',
        ];
    }

    protected function updateValidationRules(): array
    {
        return $this->storeValidationRules();
    }
}
