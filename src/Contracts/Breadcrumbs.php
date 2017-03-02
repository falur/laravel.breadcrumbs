<?php

namespace Falur\Breadcrumbs\Contracts;

interface Breadcrumbs
{
    /**
     * @param string $name
     * @param string $url
     * @return $this mixed
     */
    public function add($name, $url);

    /**
     * @param $name
     * @return \Falur\Breadcrumbs\BreadcrumbsItem
     */
    public function get($name);

    /**
     * @param array $items
     * @return $this
     */
    public function addArray(array $items);

    /**
     * @param string $name
     * @param string $url
     * @return $this mixed
     */
    public function prepend($name, $url);

    /**
     * @param string $name
     * @return $this
     */
    public function remove($name);

    /**
     * @return $this
     */
    public function clear();

    /**
     * @param string $name
     * @return boolean
     */
    public function exists($name);

    /**
     * @return \Illuminate\Support\Collection
     */
    public function crumbs();

    /**
     * @param string $path
     * @return mixed
     */
    public function setViewPath($path);

    /**
     * @param string $template
     * @return $this
     */
    public function setTemplate($template);

    /**
     * @param string $template
     * @return string
     */
    public function render($template = null);
}
