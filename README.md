

## About Project Sameple

- Project CURD Banner
1. Controller: App\Http\Controllers\BannerController
2. Model: App\Banner, App\CodeMain
3. View: resources\views\admin\banner extends from layouts.master
4. Migration file: in folder database\migrations

## Logic
1. Controller conntect with model by reponsitory app\Repositories
2. Autoload reponsitory in app\Providers\RepositoryServiceProvider.php. and register in file config/app: App\Providers\RepositoryServiceProvider::class
3. js file resources\views\layouts\partials in scripts.blade.php
