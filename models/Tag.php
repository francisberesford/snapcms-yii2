<?php

namespace snapcms\models;

use Yii;

/**
 * This is the model class for table "{{%tags}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent
 */
class Tag extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent'], 'integer'],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('snapcms', 'ID'),
            'name' => Yii::t('snapcms', 'Name'),
            'parent' => Yii::t('snapcms', 'Parent'),
        ];
    }
    
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['id' => 'media_id'])
            ->viaTable('{{%media_tags}}', ['tag_id' => 'id']);
    }

    public static function getRootTags()
    {
        return self::findAll(['parent' => null]);
    }

    public static function getList($parent = null, $startLevel = 1, $page = 'media/index')
    {
        $list = [];
        $Tags = self::findAll(['parent' => $parent]);
        foreach($Tags as $Tag)
        {
            $list [] = [
                'label' => $Tag->name,
                'url' => [$page, 'filter' => $Tag->id],
                'items' => self::getList($Tag->id, $startLevel, $page)
            ];
           
            //$item;
        }
        return $list;
    }
    
    public function getChildren()
    {
        return $this->hasMany(self::className(), ['parent' => 'id']);
    }

}
