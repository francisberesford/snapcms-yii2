<?php

namespace snapcms\components;

use Yii;
use yii\web\User as BaseUser;
use snapcms\models\User as SnapCmsUser;
use yii\web\NotFoundHttpException;

/**
 * Class User
 *
 * @author  Jackson Tong <jackson@snapfrozen.com.au>
 * @package vendor\snapfrozen\snapcms\components
 */
class User extends BaseUser
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $session = Yii::$app->session;
        if ($shadow_id = $session->get('shadow_id')) {
            $User = SnapCmsUser::findOne($shadow_id);

            if ($User === null) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

            // Switch identity back to the user who used login-as function
            $this->identity = $User;
        }
    }
}