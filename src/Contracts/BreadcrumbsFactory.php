<?php

namespace Falur\Breadcrumbs\Contracts;

interface BreadcrumbsFactory
{
    public function add($name, $callback);

    public function remove($name);

    public function get($name);

    public function __get($name);

    public function exists($name);

    public function render($name);

    public function renderIfExists($name);
}
