<?php


namespace App\Components;


use App\Components\validators\InlineValidator;
use Hyperf\Utils\Context;

class Validator extends BaseFormModel
{
    /**
     * 默认的验证器
     * @var array list of built-in validators (name => class or configuration)
     */
    public static $builtInValidators = [
        'boolean' => 'yii\validators\BooleanValidator',
        'captcha' => 'yii\captcha\CaptchaValidator',
        'compare' => 'yii\validators\CompareValidator',
        'date' => 'yii\validators\DateValidator',
        //        'datetime' => [
        //            'class' => 'yii\validators\DateValidator',
        //            'type' => DateValidator::TYPE_DATETIME,
        //        ],
        //        'time' => [
        //            'class' => 'yii\validators\DateValidator',
        //            'type' => DateValidator::TYPE_TIME,
        //        ],
        'default' => 'yii\validators\DefaultValueValidator',
        'double' => 'yii\validators\NumberValidator',
        'each' => 'yii\validators\EachValidator',
        'email' => 'yii\validators\EmailValidator',
        'exist' => 'App\Components\validators\ExistValidator',
        'file' => 'yii\validators\FileValidator',
        'filter' => 'yii\validators\FilterValidator',
        'image' => 'yii\validators\ImageValidator',
        'in' => 'yii\validators\RangeValidator',
        'integer' => [
            'class' => 'yii\validators\NumberValidator',
            'integerOnly' => true,
        ],
        'match' => 'yii\validators\RegularExpressionValidator',
        'number' => 'yii\validators\NumberValidator',
        'required' => 'App\Components\validators\RequiredValidator',
        'safe' => 'yii\validators\SafeValidator',
        'string' => 'yii\validators\StringValidator',
        'trim' => [
            'class' => 'yii\validators\FilterValidator',
            'filter' => 'trim',
            'skipOnArray' => true,
        ],
        'unique' => 'yii\validators\UniqueValidator',
        'url' => 'yii\validators\UrlValidator',
        'ip' => 'yii\validators\IpValidator',
    ];

    public $skipOnError = true;
    public $skipOnEmpty = true;
    public $message;
    public $validateAttributes = [];

    /**
     *
     *
     * @param $type
     * @param $model
     * @param $attributes
     * @param  array  $params
     *
     * @return object
     * @throws \ReflectionException
     */
    public static function createValidator($type, $model, $attributes, $params = [])
    {
        $params['validateAttributes'] = $attributes;

        if ($type instanceof \Closure) {
            $params['class'] = InlineValidator::class;
            $params['method'] = $type;
        } elseif (!isset(static::$builtInValidators[$type]) && method_exists($model, $type)) {//$model->hasMethod($type)
            // method-based validator
            $params['class'] = InlineValidator::class;
            $params['method'] = [$model, $type];
        } else {
            unset($params['current']);
            if (isset(static::$builtInValidators[$type])) {
                $type = static::$builtInValidators[$type];
            }
            if (is_array($type)) {
                $params = array_merge($type, $params);
            } else {
                $params['class'] = $type;
            }
        }
        $validatorClass = new \ReflectionClass($params['class']);
        unset($params['class']);
        return $validatorClass->newInstance($params);
    }


    /**
     *
     *
     * @return array
     */
    public function getValidationAttributes()
    {
        return $this->getAttributeNames();
    }

    /**
     * 通过model 验证attributes
     *
     * @param $model
     * @param  null  $attributes
     */
    public function validateAttributes($model, $attributes = null)
    {
        $attributes = $this->getValidationAttributes($attributes);
        foreach ($attributes as $attribute) {
            $skip = $this->skipOnError && $model->hasErrors($attribute)
                || $this->skipOnEmpty && $this->isEmpty($this->getAttributes($attribute));
            if (!$skip) {
                $this->validateAttribute($model, $attribute);
            }
        }
    }

    /**
     *
     *
     * @param $model
     * @param $attribute
     * @param $message
     * @param  array  $params
     */
    public function addError($model, $attribute, $message, $params = [])
    {
        $params['attribute'] = $model->getAttributeLabel($attribute);
        if (!isset($params['value'])) {
            $value = $this->getAttributes($attribute);
            if (is_array($value)) {
                $params['value'] = 'array()';
            } elseif (is_object($value) && !method_exists($value, '__toString')) {
                $params['value'] = '(object)';
            } else {
                $params['value'] = $value;
            }
        }
        $model->addError($attribute, $this->formatMessage($message, $params));
    }

    /**
     * Formats a mesage using the I18N, or simple strtr if `\Yii::$app` is not available.
     * @param string $message
     * @param array $params
     * @since 2.0.12
     * @return string
     */
    protected function formatMessage($message, $params)
    {
        $placeholders = [];
        foreach ((array) $params as $name => $value) {
            $placeholders['{' . $name . '}'] = $value;
        }
        return ($placeholders === []) ? $message : strtr($message, $placeholders);
    }

    /**
     *
     *
     * @param $model
     * @param $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $result = $this->validateValue($this->getAttributes($attribute));
        if (!empty($result)) {
            $this->addError($model, $attribute, $result[0], $result[1]);
        }
    }

    /**
     *
     *
     * @param $value
     */
    protected function validateValue($value)
    {
        //TODO 抛出异常
        throw new NotSupportedException(get_class($this) . ' does not support validateValue().');
    }

    /**
     * Checks if the given value is empty.
     * A value is considered empty if it is null, an empty array, or an empty string.
     * Note that this method is different from PHP empty(). It will return false when the value is 0.
     * @param mixed $value the value to be checked
     * @return bool whether the value is empty
     */
    public function isEmpty($value)
    {
//        if ($this->isEmpty !== null) {
//            return call_user_func($this->isEmpty, $value);
//        }

        return $value === null || $value === [] || $value === '';
    }


    /**
     * Returns cleaned attribute names without the `!` character at the beginning.
     * @return array attribute names.
     * @since 2.0.12
     */
    public function getAttributeNames()
    {
        return $this->validateAttributes;
    }
}