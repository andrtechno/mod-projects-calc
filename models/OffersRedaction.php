<?php

namespace panix\mod\projectscalc\models;

use Yii;
use panix\engine\db\ActiveRecord;
use panix\engine\behaviors\TranslateBehavior;
use panix\mod\projectscalc\models\translate\OffersRedactionTranslate;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use panix\mod\projectscalc\models\search\OffersRedactionSearch;

class OffersRedaction extends ActiveRecord
{

    const MODULE_ID = 'projectscalc';
    const route = '/admin/projectscalc/offersredaction';
    public $translationClass = OffersRedactionTranslate::class;

    public function getGridColumns()
    {
        return [
            [
                'attribute' => 'id',
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-left'],
                'value' => function (self $model) {
                    return $model->getOfferName();
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => new OffersRedactionSearch(),
                    'attribute' => 'created_at',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d D Y H:i:s');
                }
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => new OffersRedactionSearch(),
                    'attribute' => 'updated_at',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->updated_at, 'php:d D Y H:i:s');
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


    public function rules()
    {
        return [
            [['text'], 'string'],
            [['text'], 'required'],
        ];
    }

    public function getOfferTranslations222()
    {
        return $this->hasMany(OffersRedactionTranslate::class, ['object_id' => 'id']);
    }


}
