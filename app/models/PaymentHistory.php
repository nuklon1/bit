<?php

namespace app\models;

use engine\Model;

class PaymentHistory extends Model
{
    const TYPE_REPLENISH = 1;
    const TYPE_WITHDRAW = 2;

    public function rules(): array
    {
        return [
            ['user_id, user_card_id, sum, balance_before, balance_after, type', ['required']]
        ];
    }
}