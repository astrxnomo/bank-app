<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Account extends Model implements Auditable
{
    use SoftDeletes, AuditableTrait;
    
    protected $fillable = [
        'user_id',
        'type',
        'value',
        'number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
