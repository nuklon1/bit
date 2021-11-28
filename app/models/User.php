<?php

namespace app\models;

use engine\Model;

class User extends Model
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public float $balance;
    public int $cardId;
    public string $cardNumber;

    public function findById(int $id): self
    {
        $stmt = $this->pdo->prepare("
            SELECT u.*, c.`id` AS cardId, c.`balance`, c.`number` AS cardNumber 
            FROM `user` u 
            LEFT JOIN `user_card` c ON c.`user_id` = u.`id` 
            WHERE u.`id` = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(self::class);
    }

    /**
     * Операции с балансом пользователя
     * @param float $sum - может иметь отрицательное значение
     */
    public function balanceOperation(float $sum, int $type)
    {
        try {
            $this->pdo->beginTransaction();

            if ($type == PaymentHistory::TYPE_WITHDRAW) {
                $sum *= -1;
            }

            // Т.к. за время процедуры баланс может изменить другой процесс
            // (и в базе может быть отличное от текущего значения в объекте User), то блокируем его
            $stmt = $this->pdo->prepare("
                SELECT `id`, `balance` FROM `user_card` WHERE `user_id` = :id FOR UPDATE;
                UPDATE `user_card` SET `balance` = `balance` + $sum WHERE `user_id` = :id
            ");
            $stmt->execute(['id' => $this->id]);
            $uCard = $stmt->fetch(\PDO::FETCH_OBJ);

            // Реальный текущий баланс пользователя
            $currentBalance = $uCard->balance;
            $newBalance = $currentBalance + $sum;

            $stmt = $this->pdo->prepare("
                INSERT INTO `payment_history` 
                SET 
                    `user_id` = :userId, 
                    `user_card_id` = :cardId, 
                    `sum` = :sum, 
                    `balance_before` = :balanceBefore, 
                    `balance_after` = :balanceAfter,
                    `type` = :type
            ");
            $stmt->execute([
                'userId' => $this->id,
                'cardId' => $uCard->id,
                'sum' => $sum,
                'balanceBefore' => $currentBalance,
                'balanceAfter' => $newBalance,
                'type' => $type,
            ]);

            // Обновляю баланс и в объекте User
            $this->balance = $newBalance;

            $this->pdo->commit();
        }
        catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new \PDOException($e->getMessage());
        }
    }
}