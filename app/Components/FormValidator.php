<?php


namespace App\Components;

use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Context;
use ReflectionClass;


/**
 * Class FormValidator
 *
 * @author: TOOM <1023150697@qq.com>
 */
class FormValidator extends BaseFormModel
{

    private function rules()
    {
        return $this->_getProperty('_validator');
    }

    /**
     *
     *
     * @return bool
     */
    public function validate()
    {
        $this->clearErrors();

        $scenarios = $this->scenarios();
        $scenario = $this->getScenario();
        if (!isset($scenarios[$scenario])) {
            throw new InvalidArgumentException("Unknown scenario: $scenario");
        }

        $attributeNames = $this->activeAttributes();
        $attributeNames = (array)$attributeNames;

        /** @var \App\Components\Validator $validator */
        foreach ($this->getActiveValidators() as $validator) {
            $validator->validateAttributes($this, $attributeNames);
        }
        return !$this->hasErrors();
    }

    /**
     * Returns a value indicating whether there is any validation error.
     * @param string|null $attribute attribute name. Use null to check all
     *     attributes.
     * @return bool whether there is any error.
     */
    public function hasErrors($attribute = null)
    {
        return $attribute === null ? !empty($this->_getProperty('_errors')) : isset($this->_getProperty('_errors')[$attribute]);
    }


    /**
     * 返回适用于当前[[scenario]]的验证器。
     *
     * @param  null  $attribute
     *
     * @return array
     */
    public function getActiveValidators()
    {
        //返回当前场景需要验证的规则
        $activeAttributes = $this->activeAttributes();
        //$scenario = $this->getScenario();

        $validators = [];
        foreach ($this->getValidators() as $validator) {
            $validatorAttributes = $validator->getValidationAttributes($activeAttributes);
            $attributeValid = !empty($validatorAttributes);
            if ($attributeValid) {
                $validators[] = $validator;
            }
        }

        return $validators;
    }

    /**
     * 返回在[[rules() ]]中声明的所有验证器。
     *
     * @return mixed|null
     */
    public function getValidators()
    {
        if ($this->_getProperty('_validators') === null) {
            $this->_setProperty('_validators', $this->createValidators());
        }
        return $this->_getProperty('_validators');
    }

    /**
     *
     *
     * @return \ArrayObject
     */
    public function createValidators()
    {
        $validators = new \ArrayObject();
        foreach ($this->rules() as $rule) {
            if ($rule instanceof Validator) {
                $validators->append($rule);
            } elseif (is_array($rule) && isset($rule[0], $rule[1])) { // attributes, validator type
                $validator = Validator::createValidator($rule[1], $this, (array) $rule[0], array_slice($rule, 2));
                $validators->append($validator);
            } else {
                //TODO 抛出异常
                throw new InvalidConfigException('Invalid validation rule: a rule must specify both attribute names and validator type.');
            }
        }
        return $validators;
    }

    /**
     * 返回在当前方案中要验证的属性名称。
     * Returns the attribute names that are subject to validation in the
     * current scenario.
     * @return string[] safe attribute names
     */
    public function activeAttributes()
    {
        //TODO: 可优化
        $scenario = $this->getScenario();
        $scenarios = $this->scenarios();
        if (!isset($scenarios[$scenario])) {
            return [];
        }
        $attributes = array_keys(array_flip($scenarios[$scenario]));
        foreach ($attributes as $i => $attribute) {
            if (strncmp($attribute, '!', 1) === 0) {
                $attributes[$i] = substr($attribute, 1);
            }
        }
        return $attributes;
    }

    /**
     * Removes errors for all attributes or a single attribute.
     * @param string $attribute attribute name. Use null to remove errors for
     *     all attributes.
     */
    public function clearErrors($attribute = null)
    {
        $this->_setProperty('_errors', []);
    }

    /**
     * Parsing scene verification rules
     *
     * @return array
     */
    public function scenarios()
    {
        $rulesKey = [];
        if (is_array($this->rules()) && count ($this->rules()) > 0) {
            foreach ($this->rules() as $item) {
                if (!is_array($item[0])) {
                    $rulesKey [] = $item[0];
                }else {
                    foreach ($item[0] as $value) {
                        $rulesKey[] = $value;
                    }
                }
            }
        }
        return [
            $this->_getProperty('_scenario') => $rulesKey,
        ];
    }

    /**
     *
     *
     * @return mixed|null
     */
    public function getScenario()
    {
        return $this->_getProperty('_scenario');
    }

    /**
     *
     *
     * @param $value
     */
    public function setScenario($value)
    {
        $this->_setProperty('_scenario', $value);
        if (!isset($this->scenariosValidator()[$this->_getProperty('_scenario')])) {

            throw new InvalidargumentException ("Unknown scenario: $value");
        }
        $this->_setProperty('_validator', $this->scenariosValidator()[$this->_getProperty('_scenario')]);
    }

    /**
     *
     *
     * @param $values
     * @param  bool  $safeOnly
     */
    public function setAttributes($values, $safeOnly = true)
    {
        $attributesArr = [];
        if (is_array($values)) {
            //筛选出安全属性, rules没规定的属性将会被过滤掉
            $attributes = array_flip($safeOnly ? $this->safeAttributes() : $this->attributes());
            foreach ($values as $name => $value) {
                if (isset($attributes[$name])) {
                    $attributesArr[$name] = $value;
                }
            }
            $this->_setProperty('attributes', $attributesArr);
        }
    }

    /**
     * 获取安全的 attributes
     * @return string[] safe attribute names
     */
    public function safeAttributes()
    {
        $scenario = $this->getScenario();
        $scenarios = $this->scenarios();

        $attributes = [];
        foreach ($scenarios[$scenario] as $attribute) {
            if ($attribute[0] !== '!' && !in_array('!' . $attribute, $scenarios[$scenario])) {
                $attributes[] = $attribute;
            }
        }
        return $attributes;
    }

    public function scenariosValidator()
    {
        return [];
    }

    /**
     * Returns the text label for the specified attribute.
     * @param string $attribute the attribute name
     * @return string the attribute label
     * @see generateAttributeLabel()
     * @see attributeLabels()
     */
    public function getAttributeLabel($attribute)
    {
        $labels = $this->attributeLabels();
        return isset($labels[$attribute]) ? $labels[$attribute] : $attribute;
    }

    /**
     * Adds a new error to the specified attribute.
     * @param string $attribute attribute name
     * @param string $error new error message
     */
    public function addError($attribute, $error = '')
    {
        $arr = $this->_getProperty('_errors');
        $arr[$attribute][] = $error;
        $this->_setProperty('_errors', $arr);
    }

    /**
     * Returns the attribute labels.
     *
     * Attribute labels are mainly used for display purpose. For example, given
     * an attribute
     * `firstName`, we can declare a label `First Name` which is more
     * user-friendly and can be displayed to end users.
     *
     * By default an attribute label is generated using
     * [[generateAttributeLabel()]]. This method allows you to explicitly
     * specify attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child
     * class needs to merge the parent labels with child labels using functions
     * such as `array_merge()`.
     *
     * @return array attribute labels (name => label)
     * @see generateAttributeLabel()
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * 获取第一条报错信息
     *
     * @return mixed
     */
    public function getFirstError()
    {
        return current($this->_getProperty('_errors'))[0];
    }
}