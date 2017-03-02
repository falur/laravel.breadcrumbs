<?php

namespace Falur\Breadcrumbs;

class BreadcrumbsItem
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $url;

    /**
     * BreadcrumbsItem constructor.
     * @param string $title
     * @param string $url
     */
    public function __construct($title, $url)
    {
        $this->title = $title;
        $this->url = $url;
    }
}
