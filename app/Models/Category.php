<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property integer $id
 * @property string $name
 * @property int $_lft
 * @property int $_rgt
 * @property int $parent_id
 * @property string $created_at
 * @property string $updated_at
 */
class Category extends Model
{
    use NodeTrait;
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
    protected $fillable = ['name', '_lft', '_rgt', 'parent_id', 'created_at', 'updated_at'];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $allowedSorts = ['name'];

    protected $allowedFilters = ['name'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'categories_books', 'category_id', 'book_id');
    }
}
