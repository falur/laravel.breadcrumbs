# Хлебные крошки для laravel

## Установка

`composer require falur/laravel-breadcrumbs`

`config/app.php`

К `providers`
```php
Falur\Breadcrumbs\Providers\ServiceProvider::class
```

К `aliases`
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
```

Или

```php
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
```

В отображении

```php
// view.blade.php
{!! Breadcrumbs::render() !!}
```

## Свой шаблон отображения 

Либо 
`php artisan vendor:publish --provider="Falur\Breadcrumbs\Providers\ServiceProvider"`

После чего в каталоге `vendor` появится шаблон хлебных крошек

Либо
```php
Breadcrumbs::setViewPath($path);
Breadcrumbs::setTemplate($template);
```

Где `$path` - путь к шаблону `$template` - сам шаблон