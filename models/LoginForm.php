<?php

namespace app\models;

use app\models\Usuarios;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 */
class LoginForm extends Model
{
    /**
     * Nombre de usuario.
     * @var [type]
     */
    public $username;
    /**
     * Contraseña del usuario.
     * @var [type]
     */
    public $password;
    /**
     * Coordenada x de la posicion en la que se loguea el usuario.
     * @var [type]
     */
    public $posx;
    /**
     * Coordenada y de la posicion en la que se loguea el usuario.
     * @var [type]
     */
    public $posy;

    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username','password'], 'required'],
            ['username', 'exist', 'targetClass' => Usuarios::class, 'targetAttribute' => ['username' => 'nombre_usuario']],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Usuario',
            'password' => 'Contraseña',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Contraseña incorrecta.');
            }
        }
    }

    /**
     * Valida la contraseña
     * @return bool Cuando se loguea correctamente
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Busca usuarios por el nombre_usuario.
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuarios::findOne(['nombre_usuario' => $this->username]);
        }

        return $this->_user;
    }
}
