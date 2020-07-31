<?php


namespace App\Components;

use App\Components\BaseComponents;

class BaseFormModel extends BaseComponents
{

    public function __construct($config = [])
    {
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        parent::__construct($config);
    }

    /**
     *
     *
     * @param  null  $names
     *
     * @return array|mixed|null
     */
    public function getAttributes($names = null)
    {
        $attributes = $this->attributes();
        if ($names === null) {
            return $attributes;
        } elseif (!isset($attributes[$names])) {
            return null;
        }

        return $attributes[$names];
    }

    /**
     * Returns the list of attribute names.
     * By default, this method returns all public non-static properties of the class.
     * You may override this method to change the default behavior.
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return $this->_getProperty('attributes');
    }
}