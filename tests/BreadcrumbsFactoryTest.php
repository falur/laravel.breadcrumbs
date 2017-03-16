<?php

namespace Falur\Breadcrumbs\Tests;

use Falur\Breadcrumbs\Breadcrumbs;
use Falur\Breadcrumbs\BreadcrumbsFactory;

class BreadcrumbsFactoryTest extends TestCase
{
    /**
     * @var BreadcrumbsFactory
     */
    protected $breadcrumbsFactory;

    public function setUp()
    {
        parent::setUp();

        $this->breadcrumbsFactory = new BreadcrumbsFactory();
    }

    public function callbackBreadcrumbs(Breadcrumbs $breadcrumbs)
    {
        return $breadcrumbs;
    }

    public function testAdd()
    {
        $this->breadcrumbsFactory->add('test', [$this, 'callbackBreadcrumbs']);

        $this->assertTrue($this->breadcrumbsFactory->exists('test'));
    }

    public function testGet()
    {
        $this->breadcrumbsFactory->add('test', [$this, 'callbackBreadcrumbs']);

        $this->assertInstanceOf(Breadcrumbs::class, $this->breadcrumbsFactory->get('test'));
    }

    public function testRemove()
    {
        $this->breadcrumbsFactory->add('test', [$this, 'callbackBreadcrumbs']);

        $this->breadcrumbsFactory->remove('test');

        $this->assertFalse($this->breadcrumbsFactory->exists('test'));
    }

    public function testRender()
    {
        $this->breadcrumbsFactory->add('test', function (Breadcrumbs $breadcrumbs) {
            return $breadcrumbs->addArray([
                $this->getBreadcrumbItem(['home', '/']),
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
        $this->expectException(\Exception::class);

        $this->breadcrumbsFactory->render('test');
    }

    public function testRenderIfExists()
    {
        $this->breadcrumbsFactory->add('test', function (Breadcrumbs $breadcrumbs) {
            return $breadcrumbs->addArray([
                $this->getBreadcrumbItem(['home', '/']),
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
