<?php


namespace App\Components\validators;


use App\Components\Validator;
use Hyperf\Utils\Context;

class RequiredValidator extends Validator
{
    /**
     * @var bool whether to skip this validator if the value being validated is empty.
     */
    public $skipOnEmpty = false;
    /**
     * @var mixed the desired value that the attribute must have.
     * If this is null, the validator will validate that the specified attribute is not empty.
     * If this is set as a value that is not null, the validator will validate that
     * the attribute has a value that is the same as this property value.
     * Defaults to null.
     * @see strict
     */
    public $requiredValue;
    /**
     * @var bool whether the comparison between the attribute value and [[requiredValue]] is strict.
     * When this is true, both the values and types must match.
     * Defaults to false, meaning only the values need to match.
     *
     * Note that behavior for when [[requiredValue]] is null is the following:
     *
     * - In strict mode, the validator will check if the attribute value is null
     * - In non-strict mode validation will fail
     */
    public $strict = false;
    /**
     * @var string the user-defined error message. It may contain the following placeholders which
     * will be replaced accordingly by the validator:
     *
     * - `{attribute}`: the label of the attribute being validated
     * - `{value}`: the value of the attribute being validated
     * - `{requiredValue}`: the value of [[requiredValue]]
     */
    public $message;

    public function __construct($config = [])
    {
        if ($this->message === null) {
            $this->message = $this->requiredValue === null ? '{attribute} cannot be blank.' :
                '{attribute} must be "{requiredValue}".';
        }
        parent::__construct($config);
    }

    /**
     * 验证传递过来的值
     *
     * @param $value
     *
     * @return array|void|null
     */
    public function validateValue($value)
    {
        if ($this->requiredValue === null) {
            if ($this->strict && $value !== null || !$this->strict && !$this->isEmpty(is_string($value) ? trim($value) : $value)) {
                return null;
            }
        }elseif (!$this->strict && $value == $this->requiredValue || $this->strict && $value === $this->requiredValue) {
            return null;
        }
        if ($this->requiredValue === null) {
            return [$this->message, []];
        }

        return [$this->message, [
            'requiredValue' => $this->requiredValue,
        ]];
    }

}