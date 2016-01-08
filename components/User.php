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
     * Check identity of the shadow user rather than
     * switch identity back to shadow user may cause problem
     * with ckfinder upload folder
     *
     * @inheritdoc
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        $session = Yii::$app->session;

        if ($shadow_id = $session->get('shadow_id')) {
            $User = SnapCmsUser::findOne($shadow_id);
            if ($User === null) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

            return $this->getAuthManager()->checkAccess($User->id, $permissionName, $params);
        }

        return parent::can($permissionName, $params = [], $allowCaching = true);
    }
}