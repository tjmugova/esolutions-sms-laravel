<?php

namespace Tjmugova\EsolutionsSms\Facades;

use Illuminate\Support\Facades\Facade;

class EsolutionsSms extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'esolutionssms';
    }
}