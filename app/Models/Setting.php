<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $value
 */
class Setting extends Model
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
    protected $fillable = ['name', 'code', 'value'];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'd.m.y';

    protected $allowedSorts = ['name', 'value'];

    protected $allowedFilters = ['name', 'value'];

    public $timestamps = false;
}
