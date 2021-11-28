<?php

namespace engine;


class Model
{
    public \PDO $pdo;
    public array $errors = [];

    public function __construct()
    {
        $this->pdo = Db::instance()->pdo;
    }

    /**
     * Правила, которые будут определяться в моделях
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Валидация полей
     * Правило можно задать списку полей
     * Пример задания правила:
     * ['field1, field2,...', ['min', 'min' => 10]]
     */
    public function validate()
    {
        if (empty($this->rules())) {
            return [];
        }

        // Пробегаем по правилам
        foreach ($this->rules() as $key => $row) {
            list($attrList, $rule) = $row;
            list($ruleName, $ruleValue) = $rule;
            $attributes = explode(',', str_replace(' ', '', $attrList));

            // Пробегаем по списку аттрибутов
            foreach ($attributes as $attribute) {
                if ($ruleName == 'required' && !$this->{$attribute}) {
                    $this->addErrorToField($attribute, 'required');
                }

                if ($ruleName == 'email' && !filter_var($this->{$attribute}, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorToField($attribute, 'email');
                }

                if ($ruleName == 'max' && strlen($this->{$attribute}) > $ruleValue['max']) {
                    $this->addErrorToField($attribute, 'max', $ruleValue['max']);
                }

                if ($ruleName == 'min' && strlen($this->{$attribute}) < $ruleValue['min']) {
                    $this->addErrorToField($attribute, 'min', $ruleValue['min']);
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Сообщения об ошибках
     * @return string[]
     */
    public static function errorMessages(): array
    {
        return [
            'required' => 'Поле {field} обязательно для заполнения',
            'max' => 'Допустимо максимум {max} символов',
            'min' => 'Необходимо минимум {min} символов',
            'email' => 'Email должен быть валидным',
        ];
    }

    /**
     * Добавляет ошибку к соответствующему полю
     * @param string $attribute
     * @param string $rule
     * @param null $ruleValue
     * @return void
     */
    public function addErrorToField(string $attribute, string $rule, $ruleValue = null)
    {
        if ($rule == 'required') {
            $this->errors[$attribute] = str_replace("{field}", $attribute, self::errorMessages()[$rule]);
        } else {
            if ($ruleValue) {
                $this->errors[$attribute] = str_replace("{$rule}", $ruleValue, self::errorMessages()[$rule]);
            } else {
                $this->errors[$attribute] = self::errorMessages()[$rule];
            }
        }
    }

    /**
     * Грузим переданные данные в аттрибуты
     * @param array $params
     */
    public function loadParams(array $params)
    {
        foreach ($params as $attribute => $param) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $param;
            }
        }
    }

}