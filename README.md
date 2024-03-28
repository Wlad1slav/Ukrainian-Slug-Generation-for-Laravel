# Ukrainian Slug Generation Laravel
Трейт для генерації українського slug в Laravel веб додатках.

## Залежності
- PHP >= 8.2
- Laravel

## Приклади використання

```php
class MyController extends Controller
{
    use SlugGenerationTrait; // Трейт для генерації slug
    
    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);
        
        // Виклик методу з трейту для генерації slug
        $slug = self::createOriginalSlug($request->name, Model::class);
        
        Model::create([
            'name' => $request->name,
            'slug' => $slug
        ]);
    }
}
```

## Приклад slug
`Як умру, то поховайте
Мене на могилі,
Серед степу широкого,
На Вкраїні милій,` **===>**
`iak-umru-to-pokhovajte-mene-na-mohyli-sered-stepu-syrokoho-na-vkrajini-mylij`
