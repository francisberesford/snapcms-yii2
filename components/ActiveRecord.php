<?php

namespace snapcms\components;

use Yii;
use yii\console\Application;
use yii\db\ActiveRecord as BaseActiveRecord;

/**
 * Class ActiveRecord
 *
 * @author Jackson Tong <tongtoan2704@gmail.com>
 * @package snapcms\components
 */
class ActiveRecord extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public function beforeValidate()
    {
        if(Yii::$app instanceof Application) {
            return true;
        }

        if(parent::beforeValidate())
        {
            $User = Yii::$app->user->identity;

            if($this->hasAttribute('created_at') && empty($this->created_at) && $this->isNewRecord) {
                $this->created_at = date('Y-m-d H:i:s');
            }
            //todo: find the other way to insert identity because beforeValidate will insert value to search model: ProjectSearch::created_by
            if($this->hasAttribute('created_by') && empty($this->created_by) && $this->isNewRecord) {
                $this->created_by = $User->id;
            }
            if($this->hasAttribute('owned_by') && empty($this->owned_by) && $this->isNewRecord) {
                $this->owned_by = $User->id;
            }
            //@todo: create our own timestamp behaviour that checks the attribute exists.
            if($this->scenario == 'default' && $this->hasAttribute('updated_at')) {
                $this->updated_at = date('Y-m-d H:i:s');
            }
            if($this->hasAttribute('updated_by')) {
                $this->updated_by = $User->id;
            }
            return true;
        }
    }
}