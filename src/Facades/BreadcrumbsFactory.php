<?php

namespace Falur\Breadcrumbs\Facades;

use Illuminate\Support\Facades\Facade;

class BreadcrumbsFactory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'breadcrumbsFactory';
    }
}
