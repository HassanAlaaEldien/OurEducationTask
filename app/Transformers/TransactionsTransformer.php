<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;
use League\Fractal\TransformerAbstract;

class TransactionsTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        'member'
    ];

    /**
     * A Fractal transformer.
     *
     * @param Transaction $transaction
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'id' => $transaction->id,
            'amount' => $transaction->amount,
            'currency' => $transaction->currency,
            'status' => $transaction->status,
            'payment_date' => $transaction->payment_date,
            'parent_id' => $transaction->parent_id
        ];
    }

    /**
     * @param Transaction $transaction
     * @return Item|NullResource
     */
    public function includeMember(Transaction $transaction)
    {
        return $transaction->member
            ? $this->item($transaction->member, new MembersTransformer())
            : $this->null();
    }
}
