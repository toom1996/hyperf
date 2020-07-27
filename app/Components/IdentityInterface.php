<?php


namespace App\Components;

/**
 * Interface UserIdentityInterface
 *
 * @package App\Components
 * @property $id
 */
interface IdentityInterface
{

    public static function findIdentity($id);


    public static function findIdentityByAccessToken($token);


    public function getId();


    public function getAuthKey();


    public function validateAuthKey($authKey);
}