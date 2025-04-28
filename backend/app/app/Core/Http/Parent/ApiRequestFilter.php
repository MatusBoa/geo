<?php

declare(strict_types=1);

namespace App\Core\Http\Parent;

use Illuminate\Http\Request;

abstract class ApiRequestFilter
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    protected function getSometimesRequiredRule(Request $request): string
    {
        return $request->isMethod('PATCH') ? 'sometimes' : 'required';
    }
}
