<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $message
 * @property string $tel
 * @property string $created_at
 * @property string $updated_at
 */
class Feedback extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedback_form';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['email', 'name', 'message', 'tel', 'created_at', 'updated_at'];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'd.m.y';


    protected $allowedSorts = ['email', 'name', 'message', 'tel', 'created_at'];

    protected $allowedFilters = ['email', 'name', 'message', 'tel', 'created_at'];

}
