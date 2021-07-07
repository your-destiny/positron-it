<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property integer $id
 * @property string $title
 * @property string $isbn
 * @property int $pageCount
 * @property string $publishedDate
 * @property string $thumbnailUrl
 * @property string $shortDescription
 * @property string $longDescription
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Book extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['title', 'isbn', 'pageCount', 'publishedDate', 'thumbnailUrl', 'shortDescription', 'longDescription', 'status', 'created_at', 'updated_at'];

    /**
     * @var false[]
     */
 /*   protected $attributes = [
        'title' => null,
        'isbn' => null,
        'pageCount' => null,
        'publishedDate' => null,
        'thumbnailUrl' => null,
        'shortDescription' => null,
        'longDescription' => null,
        'status' => null,
    ];*/

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = "Y-m-d H:i:s";

    protected $allowedSorts = ['title', 'isbn', 'pageCount', 'publishedDate', 'thumbnailUrl', 'shortDescription', 'longDescription', 'status', 'created_at'];

    protected $allowedFilters = ['title', 'isbn', 'pageCount', 'publishedDate', 'thumbnailUrl', 'shortDescription', 'longDescription', 'status', 'created_at'];


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_books', 'book_id', 'category_id');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'books_authors', 'book_id', 'author_id');
    }
}
