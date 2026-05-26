# Global Scope Conflict with Route Model Binding in Laravel

## Problem
A `NotFoundHttpException` occurred on `PUT /articles/5/publish` despite the writer (ID: 87) being the actual author of article 5 (`author_id: 87`, `status: "draft"`). The Global Scope `visibility` in `Article` model filtered out the draft article during implicit Route Model Binding before the controller could execute.

## Root Cause
The Global Scope automatically applies to **all** queries, including Laravel's implicit `Article::find(5)` during Route Model Binding. The scope adds `WHERE (status = 'published' OR author_id = 87)`, which fails because `status = "draft"` and the `OR` condition within the `AND id = 5` clause returns `null`. Laravel then throws `NotFoundHttpException` before reaching the controller's manual authorization check.

**Affected Files:**
- `app/Models/Article.php` — Global Scope `visibility` filters all queries
- `routes/api.php` — Route uses implicit binding `{article}`
- `app/Http/Controllers/Api/V1/ArticleController.php` — `publish(Article $article)` receives `null`

## Solution
Use **Explicit Route Model Binding** in `RouteServiceProvider` to bypass the Global Scope during model resolution, keeping manual authorization in the controller:

```php
// app/Providers/RouteServiceProvider.php
use App\Models\Article;
use Illuminate\Support\Facades\Route;

public function boot(): void
{
    Route::bind('article', function ($value) {
        return Article::withoutGlobalScope('visibility')->findOrFail($value);
    });
    parent::boot();
}
