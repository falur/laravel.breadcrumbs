# Хлебные крошки для laravel

## Установка

`composer require falur/laravel-breadcrumbs`

`config/app.php`

```php
Falur\Breadcrumbs\Providers\ServiceProvider::class
```

```php
'Breadcrumbs' => Falur\Breadcrumbs\Facades\Breadcrumbs::class,
'BreadcrumbsFactory' => Falur\Breadcrumbs\Facades\BreadcrumbsFactory::class,
```

## Использование

```php
// BaseController.php
class BaseController extends Controller
{
    /**
     * @var Falur\Breadcrumbs\Contracts\Breadcrumbs
     */
    protected $breadcrumbs;

    public function __construct(Falur\Breadcrumbs\Contracts\Breadcrumbs $breadcrumbs)
    {
        $this->breadcrumbs->add('Главная', '/');
    }
}

// PageController.php
class PageController extends BaseController
{
    public function action()
    {
        $this->breadcrumbs->add('Action', '/action');
    }
}

// or 

// PageController.php
class PageController extends Controller
{
    public function action(Falur\Breadcrumbs\Contracts\Breadcrumbs $breadcrumbs)
    {
        $breadcrumbs->addArray([
            new BreadcrumbsItem('Home', '/'),
            new BreadcrumbsItem('Action', '/action'),
        ]);
    }
}

// view.blade.php
Breadcrumbs::render();
```