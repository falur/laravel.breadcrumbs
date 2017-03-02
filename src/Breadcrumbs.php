<?php

namespace Falur\Breadcrumbs;

class Breadcrumbs implements Contracts\Breadcrumbs
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $crumbs;

    /**
     * @var string
     */
    protected $viewPath = 'breadcrumbs::';

    /**
     * @var string
     */
    protected $template = 'default';

    /**
     * Breadcrumbs constructor.
     */
    public function __construct()
    {
        $this->crumbs = collect([]);
    }

    /**
     * @param string $name
     * @param string $url
     * @return $this
     */
    public function add($name, $url)
    {
        $this->crumbs->put($name, new BreadcrumbsItem($name, $url));

        return $this;
    }

    /**
     * @param string $name
     * @return \Falur\Breadcrumbs\BreadcrumbsItem
     */
    public function get($name)
    {
        return $this->crumbs->get($name);
    }

    /**
     * @param array $items
     * @return $this
     */
    public function addArray(array $items)
    {
        foreach ($items as $k => $item) {
            if ($item instanceof BreadcrumbsItem) {
                $this->crumbs->put($item->title, $item);

                continue;
            }

            list($name, $url) = $this->getDataFromMixed($k, $item);

            $this->add($name, $url);
        }

        return $this;
    }

    /**
     * @param mixed $k
     * @param mixed $item
     * @return array
     */
    protected function getDataFromMixed($k, $item)
    {
        if (!is_array($item)) {
            throw new \InvalidArgumentException("{$k} item is not array");
        }

        if (count($item) < 2) {
            throw new \InvalidArgumentException("{$k} item invalid");
        }

        if (isset($item['name']) && isset($item['url'])) {
            return [
                $item['name'],
                $item['url']
            ];
        }

        return array_values($item);
    }

    /**
     * @param string $name
     * @param string $url
     * @return $this
     */
    public function prepend($name, $url)
    {
        $this->crumbs->prepend(new BreadcrumbsItem($name, $url), $name);

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function remove($name)
    {
        $this->crumbs->forget($name);

        return $this;
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->crumbs = collect([]);

        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exists($name)
    {
        return $this->crumbs->has($name);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function crumbs()
    {
        return $this->crumbs;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setViewPath($path)
    {
        $this->viewPath = $path;

        return $this;
    }

    /**
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @param string|null $template
     * @return string
     */
    public function getFullViewPath($template = null)
    {
        if (is_null($template)) {
            $template = $this->template;
        }

        $end = mb_strlen($this->viewPath) - 1;

        if ($this->viewPath[$end] == ':') {
            return $this->viewPath . $template;
        }

        return $this->viewPath . '.' . $template;
    }

    /**
     * @param string|null $template
     * @return string
     */
    public function render($template = null)
    {
        return \view($this->getFullViewPath($template), [
            'crumbs' => $this->crumbs
        ])->render();
    }
}
