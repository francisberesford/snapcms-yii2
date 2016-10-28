<?php
namespace snapcms\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use snapcms\components\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use snapcms\models\Config;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_DISABLED = 5;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;
    
    protected static $systemRoles = array(
        'Admin',
        'Anonymous',
    );

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
      * @inheritdoc
      */
     public function rules()
     {
         return [
             ['status', 'default', 'value' => self::STATUS_ACTIVE],
             ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_DISABLED]],

             ['role', 'default', 'value' => self::ROLE_USER],
             ['role', 'in', 'range' => [self::ROLE_USER]],
         ];
     }
     
    public function attributeLabels()
     {
         return [
             'status_label' => Yii::t('snapcms', 'Status'),
             'status' => Yii::t('snapcms', 'Status'),
             'role' => Yii::t('snapcms', 'Role'),
         ];
     }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Config::getData('general/security.passwordResetTokenExpire');
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /**
     * Checks whether a given role is a required system role
     * @param string $role The to check
     * @return boolean Whether the given role is a required system role
     */
    public static function isSystemRole($role) {
        return in_array($role, self::$systemRoles);
    }
    
    public static function getStatusLabels()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DISABLED => 'Disabled',
            //self::STATUS_DELETED => 'Deleted',
        ];
    }
    
    public function getStatus_label($type=null)
    {
        $types = self::getStatusLabels();
        $type = $type ? $type : $this->status;
        return ArrayHelper::getValue($types, $type, Yii::t('pvsell', 'Status not found!'));
    }
}
