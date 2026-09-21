<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Job
 *
 * @property int $id
 * @property string $queue
 * @property string $payload
 * @property int $attempts
 * @property int|null $reserved_at
 * @property int $available_at
 * @property int $created_at
 */
class Job extends Model
{
    public $timestamps = false;

    protected $table = 'jobs';

    protected $casts = [
        'attempts'     => 'int',
        'reserved_at'  => 'int',
        'available_at' => 'int',
    ];

    protected $fillable = [
        'queue',
        'payload',
        'attempts',
        'reserved_at',
        'available_at',
    ];
}
