<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CacheLock
 *
 * @property string $key
 * @property string $owner
 * @property int $expiration
 */
class CacheLock extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'cache_locks';

    protected $primaryKey = 'key';

    protected $casts = [
        'expiration' => 'int',
    ];

    protected $fillable = [
        'owner',
        'expiration',
    ];
}
