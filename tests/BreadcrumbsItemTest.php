<?php

namespace Falur\Breadcrumbs\Tests;

use Falur\Breadcrumbs\BreadcrumbsItem;

class BreadcrumbsItemTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $breadcrumbItem = new BreadcrumbsItem('name', 'url');

        $this->assertEquals('name', $breadcrumbItem->title);
        $this->assertEquals('url', $breadcrumbItem->url);
    }
}
