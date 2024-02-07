<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // this is the important one

        // seterah mau yang mana
        'api/v1/**',
        'auth/**',

        // or
        // 'api/v1/*',
        // 'api/v1/quotes/*'
    ];
}
