<?php

namespace snapcms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use snapcms\models\Config;

/**
 * ConfigSearch represents the model behind the search form about `snapcms\models\Config`.
 */
class ConfigSearch extends Config
{
    public function rules()
    {
        return [
            [['path', 'value'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Config::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
