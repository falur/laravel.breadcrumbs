<?php

namespace Falur\Breadcrumbs\Tests;

use Falur\Breadcrumbs\Breadcrumbs;
use Falur\Breadcrumbs\BreadcrumbsItem;

class BreadcrumbsTest extends TestCase
{
    /**
     * @var Breadcrumbs
     */
    protected $breadcrumbs;

    public function setUp()
    {
        parent::setUp();

        $this->breadcrumbs = new Breadcrumbs();
    }

    public function testConstructor()
    {
        $breadcrumbs = new Breadcrumbs();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $breadcrumbs->crumbs());
    }

    public function testAdd()
    {
        $this->assertCount(0, $this->breadcrumbs->crumbs()->toArray());

        $this->breadcrumbs->add('name', 'url');

        $this->assertCount(1, $this->breadcrumbs->crumbs()->toArray());
    }

    public function testGet()
    {
        $this->breadcrumbs->add('name', 'url');

        $item = $this->breadcrumbs->get('name');

        $this->assertInstanceOf(BreadcrumbsItem::class, $item);

        $this->assertEquals('name', $item->title);
        $this->assertEquals('url', $item->url);
    }

    public function testAddArray()
    {
        $this->breadcrumbs->addArray([
            $this->getBreadcrumbItem(),
            ['name' => 'name1', 'url' => 'url1'],
            ['name2', 'url2'],
        ]);

        $this->assertEquals(3, $this->breadcrumbs->crumbs()->count());

        $this->assertEquals('url', $this->breadcrumbs->get('name')->url);
        $this->assertEquals('name', $this->breadcrumbs->get('name')->title);

        $this->assertEquals('url1', $this->breadcrumbs->get('name1')->url);
        $this->assertEquals('name1', $this->breadcrumbs->get('name1')->title);

        $this->assertEquals('url2', $this->breadcrumbs->get('name2')->url);
        $this->assertEquals('name2', $this->breadcrumbs->get('name2')->title);
    }

    public function testPrepend()
    {
        $this->breadcrumbs->add('name', 'url');
        $this->breadcrumbs->prepend('name1', 'url');

        $this->assertEquals('name1', $this->breadcrumbs->crumbs()->first()->title);

        $this->breadcrumbs->add('name8', 'url');
        $this->breadcrumbs->prepend('name2', 'url');

        $this->assertEquals('name2', $this->breadcrumbs->crumbs()->first()->title);
    }

    public function testRemove()
    {
        $this->breadcrumbs->add('name', 'url');

        $this->breadcrumbs->remove('name');

        $this->assertEquals(0, $this->breadcrumbs->crumbs()->count());
    }

    public function testClear()
    {
        $this->breadcrumbs->addArray([
            $this->getBreadcrumbItem(),
            ['name' => 'name1', 'url' => 'url1'],
            ['name2', 'url2'],
        ]);

        $this->breadcrumbs->clear();

        $this->assertEquals(0, $this->breadcrumbs->crumbs()->count());
    }

    public function testExists()
    {
        $this->breadcrumbs->addArray([
            $this->getBreadcrumbItem(),
            ['name' => 'name1', 'url' => 'url1'],
            ['name2', 'url2'],
        ]);

        $this->assertTrue($this->breadcrumbs->exists('name'));
    }

    public function testCrumbs()
    {
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $this->breadcrumbs->crumbs());
    }

    public function testGetViewFullPath()
    {
        $this->breadcrumbs->setViewPath('breadcrumbs::');
        $this->breadcrumbs->setTemplate('default');

        $this->assertEquals('breadcrumbs::default', $this->breadcrumbs->getFullViewPath());

        $this->breadcrumbs->setViewPath('breadcrumbs::default');
        $this->breadcrumbs->setTemplate('default');

        $this->assertEquals('breadcrumbs::default.default', $this->breadcrumbs->getFullViewPath());
    }

    public function testRender()
    {
        $this->breadcrumbs->addArray([
            $this->getBreadcrumbItem(['home', '/']),
            ['name' => 'page1', 'url' => '/url'],
            ['page2', '/url/url'],
        ]);

        $this->assertXmlStringEqualsXmlFile(__DIR__ . '/render/default.html', $this->breadcrumbs->render());
    }
}
