<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cache
 *
 * @property string $key
 * @property string $value
 * @property int $expiration
 */
class Cache extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'cache';

    protected $primaryKey = 'key';

    protected $casts = [
        'expiration' => 'int',
    ];

    protected $fillable = [
        'value',
        'expiration',
    ];
}
