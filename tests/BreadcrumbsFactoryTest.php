<?php

namespace Falur\Breadcrumbs\Tests;

use Falur\Breadcrumbs\Breadcrumbs;
use Falur\Breadcrumbs\BreadcrumbsFactory;
use Falur\Breadcrumbs\BreadcrumbsItem;
use Falur\Breadcrumbs\Providers\ServiceProvider;

class BreadcrumbsFactoryTest extends \Orchestra\Testbench\TestCase
{
    /**
     * BreadcrumbsFactory
     */
    protected $breadcrumbsFactory;

    public function setUp()
    {
        parent::setUp();

        $this->breadcrumbsFactory = new BreadcrumbsFactory();
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    public function testAdd()
    {
        $this->breadcrumbsFactory->add('test', function(Breadcrumbs $breadcrumbs) {
            $breadcrumbs->add('testTitle', 'testUrl');

            return $breadcrumbs;
        });

        $this->assertTrue($this->breadcrumbsFactory->exists('test'));
    }

    public function testGet()
    {
        $this->breadcrumbsFactory->add('test', function(Breadcrumbs $breadcrumbs) {
            $breadcrumbs->add('testTitle', 'testUrl');

            return $breadcrumbs;
        });

        $this->assertInstanceOf(Breadcrumbs::class, $this->breadcrumbsFactory->get('test'));

        $this->assertEquals('testTitle', $this->breadcrumbsFactory->get('test')->crumbs()->first()->title);
    }

    public function testRemove()
    {
        $this->breadcrumbsFactory->add('test', function(Breadcrumbs $breadcrumbs) {
            $breadcrumbs->add('testTitle', 'testUrl');

            return $breadcrumbs;
        });

        $this->breadcrumbsFactory->remove('test');

        $this->assertFalse($this->breadcrumbsFactory->exists('test'));
    }

    public function testRender()
    {
        $this->breadcrumbsFactory->add('test', function (Breadcrumbs $breadcrumbs) {
            return $breadcrumbs->addArray([
                new BreadcrumbsItem('home', '/'),
                ['name' => 'page1', 'url' => '/url'],
                ['page2', '/url/url'],
            ]);
        });

        $this->assertXmlStringEqualsXmlFile(
            __DIR__ . '/render/default.html',
            $this->breadcrumbsFactory->render('test')
        );
    }

    public function testRenderException()
    {
        $this->setExpectedException(\Exception::class);

        $this->breadcrumbsFactory->render('test');
    }

    public function testRenderIfExists()
    {
        $this->breadcrumbsFactory->add('test', function (Breadcrumbs $breadcrumbs) {
            return $breadcrumbs->addArray([
                new BreadcrumbsItem('home', '/'),
                ['name' => 'page1', 'url' => '/url'],
                ['page2', '/url/url'],
            ]);
        });

        $this->assertXmlStringEqualsXmlFile(
            __DIR__ . '/render/default.html',
            $this->breadcrumbsFactory->renderIfExists('test')
        );
    }

    public function testRenderIfExistsEmpty()
    {
        $this->assertEquals(
            '',
            $this->breadcrumbsFactory->renderIfExists('test')
        );
    }
}
