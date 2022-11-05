<?php

namespace App\Transformers;

use App\Models\Member;
use League\Fractal\TransformerAbstract;

class MembersTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Member $member
     * @return array
     */
    public function transform(Member $member)
    {
        return [
            'uuid' => $member->uuid,
            'balance' => $member->balance,
            'currency' => $member->currency,
            'email' => $member->email
        ];
    }
}
