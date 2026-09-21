<?php

declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelHasPermission
 *
 * @property int $permission_id
 * @property string $model_type
 * @property int $model_id
 * @property Permission $permission
 */
class ModelHasPermission extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    protected $table = 'model_has_permissions';

    protected $casts = [
        'permission_id' => 'int',
        'model_id'      => 'int',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
