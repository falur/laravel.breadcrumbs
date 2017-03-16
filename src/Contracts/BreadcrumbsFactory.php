<?php

namespace Falur\Breadcrumbs\Contracts;

interface BreadcrumbsFactory
{
    /**
     * @param string $name
     * @param callable $callback
     * @return $this
     */
    public function add($name, $callback);

    /**
     * @param string $name
     * @return $this
     */
    public function remove($name);

    /**
     * @param string $name
     * @return Breadcrumbs|null
     */
    public function get($name);

    /**
     * @param string $name
     * @return bool
     */
    public function exists($name);

    /**
     * @param string $name
     * @param null|string $template
     * @return string
     * @throws \Exception
     */
    public function render($name, $template = null);

    /**
     * @param string $name
     * @param null|string $template
     * @return string
     */
    public function renderIfExists($name, $template = null);
}
