<?php

namespace Falur\Breadcrumbs\Tests;

use Falur\Breadcrumbs\BreadcrumbsItem;
use Falur\Breadcrumbs\Providers\ServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function getBreadcrumbItem($args = ['name', 'url'])
    {
        return $this->getMockBuilder(BreadcrumbsItem::class)
            ->setConstructorArgs($args)
            ->getMock();
    }
}