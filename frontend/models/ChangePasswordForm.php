<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

class ChangePasswordForm extends Model
{
    public $old_password;
    public $new_password;
    public $confirm_password;

    public function rules()
    {
        return [
            [['old_password', 'new_password', 'confirm_password'], 'required'],
            ['new_password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => "Parollar mos kelmadi"],
            ['old_password', 'validateOldPassword'],
        ];
    }

    public function validateOldPassword($attribute, $params)
    {
        $user = \Yii::$app->user->identity;
        if (!$user || !$user->validatePassword($this->old_password)) {
            $this->addError($attribute, 'Eski parol noto\'g\'ri.');
        }
    }
}
