<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Product extends Model implements Auditable
{
    use SoftDeletes, AuditableTrait;

    protected $fillable = [
        'user_id',
        'type',
        'time',
        'value',
        'interest',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
