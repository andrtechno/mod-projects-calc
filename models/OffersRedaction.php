<?php

namespace panix\mod\projectscalc\models;


use panix\mod\projectscalc\models\search\OffersRedactionSearch;
use Yii;
use panix\engine\db\ActiveRecord;
use panix\engine\behaviors\TranslateBehavior;
use panix\mod\projectscalc\models\translate\OffersRedactionTranslate;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

class OffersRedaction extends ActiveRecord
{

    const MODULE_ID = 'projectscalc';
    const route = '/admin/projectscalc/offersredaction';

    public function getGridColumns() {
        return [
            [
                'attribute' => 'id',
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-left'],
                'value'=>function($model){
                    return $model->getOfferName();
                }
            ],
            [
                'attribute' => 'date_create',
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => new OffersRedactionSearch(),
                    'attribute' => 'date_create',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->date_create, 'php:d D Y H:i:s');
                }
            ],
            [
                'attribute' => 'date_update',
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => new OffersRedactionSearch(),
                    'attribute' => 'date_update',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function($model) {
                    return Yii::$app->formatter->asDatetime($model->date_update, 'php:d D Y H:i:s');
                }
            ],
            'DEFAULT_CONTROL' => [
                'class' => 'panix\engine\grid\columns\ActionColumn',
            ],
            'DEFAULT_COLUMNS' => [
                ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function getOfferName()
    {
        return 'Редакция предложения №' . $this->id;
    }


    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%offers_redaction}}';
    }


    public function rules() {
        return [
            [['text'], 'string'],
            [['text'], 'required'],
        ];
    }

    public function getOfferTranslations()
    {
        return $this->hasMany(OffersRedactionTranslate::class, ['object_id' => 'id']);
    }

    public function behaviors()
    {
        return ArrayHelper::merge([
            'translate' => [ //offer_translate
                'class' => TranslateBehavior::class,
                'translationRelation'=>'offerTranslations',
                'translationAttributes' => [
                    'text'
                ]
            ],
        ], parent::behaviors());
    }

}
