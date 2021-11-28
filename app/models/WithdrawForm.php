<?php

namespace app\models;

use engine\Model;

class WithdrawForm extends Model
{
    // для всего что приходит извне, по умолчанию задаю тип string
    public string $balance;

    public function rules(): array
    {
        return [
            ['balance', ['required']]
        ];
    }

    public function withdraw(User $user): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $sum = (float) $this->balance;

        if ($sum <= 0) {
            $this->errors['balance'] = 'Значение суммы должно быть > 0';
            return false;
        }

        if ($sum > $user->balance) {
            $this->errors['balance'] = 'Вы пытаетесь снять больше, чем у вас на балансе';
            return false;
        }

        $user->balanceOperation($sum, PaymentHistory::TYPE_WITHDRAW);
        return true;
    }
}