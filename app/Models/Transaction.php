<?php

namespace App\Models;

use App\Services\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory, Filterable;

    /**
     * @var string
     */
    protected $table = 'transactions';

    /**
     * @var string[]
     */
    protected $fillable = ['amount', 'currency', 'member_id', 'status', 'payment_date', 'parent_id'];

    /**
     * @return BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'uuid');
    }
}
