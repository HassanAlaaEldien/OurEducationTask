<?php

namespace App\Models;

use App\Services\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory, Filterable;

    /**
     * @var string
     */
    protected $table = 'members';

    /**
     * @var string[]
     */
    protected $fillable = ['uuid', 'balance', 'currency', 'email', 'created_at'];

    /**
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'member_id', 'uuid');
    }
}
