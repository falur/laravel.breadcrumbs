<?php

namespace Falur\Breadcrumbs;

use Exception;

class BreadcrumbsFactory implements Contracts\BreadcrumbsFactory
{
    /**
     * @var Breadcrumbs[]
     */
    protected $items = [];

    /**
     * @param string $name
     * @param callable $callback
     * @return $this
     */
    public function add($name, callable $callback)
    {
        $this->items[$name] = $callback(new Breadcrumbs());

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function remove($name)
    {
        if ($this->exists($name)) {
            unset($this->items[$name]);
        }

        return $this;
    }

    /**
     * @param string $name
     * @return Breadcrumbs|null
     */
    public function get($name)
    {
        if ($this->exists($name)) {
            return $this->items[$name];
        }

        return null;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        return isset($this->items[$name]);
    }

    /**
     * @param string $name
     * @param null|string $template
     * @return string
     * @throws Exception
     */
    public function render($name, $template = null)
    {
        if ($this->exists($name)) {
            return $this->items[$name]->render($template);
        }

        throw new Exception("Breadcrumbs with name = {$name} not exists");
    }

    /**
     * @param string $name
     * @param null|string $template
     * @return string
     */
    public function renderIfExists($name, $template = null)
    {
        if ($this->exists($name)) {
            return $this->items[$name]->render($template);
        }

        return '';
    }
}
