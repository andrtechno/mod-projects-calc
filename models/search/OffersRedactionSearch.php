<?php

namespace panix\mod\projectscalc\models\search;

use Yii;
use yii\base\Model;
use panix\engine\data\ActiveDataProvider;
use panix\mod\projectscalc\models\OffersRedaction;

class OffersRedactionSearch extends OffersRedaction {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['customer_name','created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = OffersRedaction::find();
        //$query->joinWith('translations');
        //$query->with('translations');
        $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort'=> self::getSort(),
                ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

       // $query->andFilterWhere(['like', PagesTranslate::tableName().'.name', $this->name]);
       // $query->andFilterWhere(['like', 'DATE(date_create)', $this->date_create]);
       // $query->andFilterWhere(['like', 'DATE(date_update)', $this->date_update]);
        //$query->andFilterWhere(['like', 'views', $this->views]);

        return $dataProvider;
    }
    public static function getSort() {
        $sort = new \yii\data\Sort([
            'attributes' => [
                'created_at',
                'updated_at',

            ],
        ]);
        return $sort;
    }
}
