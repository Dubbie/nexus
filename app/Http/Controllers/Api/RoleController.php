<?php

namespace App\Http\Controllers\Api;

use Spatie\Permission\Models\Role;

class RoleController extends BaseApiController
{
    protected string $modelClass = Role::class;

    protected array $storeValidationRules = [
        'name' => 'required',
    ];

    protected array $updateValidationRules = [
        'name' => 'required',
    ];
}
