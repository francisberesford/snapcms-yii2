<?php

namespace snapcms\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use snapcms\models\Media;

/**
 * MediaSearch represents the model behind the search form about `snapcms\models\Media`.
 */
class MediaSearch extends Media
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_public'], 'integer'],
            [['title', 'filename', 'mime_type', 'extension'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Media::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($this->load($params) && !$this->validate()) {
            return $dataProvider;
        }
        
        if(isset($params['filter']))
        {
            $query->joinWith(['tags']);
            $query->andFilterWhere([
                'tag_id' => $params['filter']
            ]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_public' => $this->is_public,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'mime_type', $this->mime_type])
            ->andFilterWhere(['like', 'extension', $this->extension]);

        return $dataProvider;
    }
}
