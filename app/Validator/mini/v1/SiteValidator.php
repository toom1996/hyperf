<?php


namespace App\Validator\mini\v1;


use App\Components\BaseFormModel;
use App\Components\FormValidator;


class SiteValidator extends FormValidator
{
    const SCENARIO_GET_SESSION = 'getSession';

    /**
     *
     *
     * @return array|\string[][][]
     */
    public function scenariosValidator()
    {
        return [
            self::SCENARIO_GET_SESSION => [
                ['code', 'required']
            ]
        ];
    }
}