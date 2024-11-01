<?php
namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $usernameOrEmail;
    public $password;
    public $rememberMe = true;

    private $_user;

    public function rules()
    {
        return [
            [['usernameOrEmail', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                Yii::error('User not found: ' . $this->usernameOrEmail);
                $this->addError($attribute, 'User not found.');
            } elseif (!$user->validatePassword($this->password)) {
                Yii::error('Incorrect password for user: ' . $this->usernameOrEmail);
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::find()
                ->where(['username' => $this->usernameOrEmail])
                ->orWhere(['email' => $this->usernameOrEmail])
                ->one();
        }
        return $this->_user;
    }
}