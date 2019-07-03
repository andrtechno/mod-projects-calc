<?php

namespace panix\mod\projectscalc\models;


use Yii;
use panix\mod\projectscalc\models\translate\AgreementsRedactionTranslate;
use panix\mod\projectscalc\models\search\AgreementsRedactionSearch;
use panix\engine\jui\DatePicker;
use panix\engine\db\ActiveRecord;

class AgreementsRedaction extends ActiveRecord
{

    const MODULE_ID = 'projectscalc';
    const route = '/admin/projectscalc/agreementsredaction';
    public $translationClass = AgreementsRedactionTranslate::class;

    public function getGridColumns()
    {
        return [
            [
                'attribute' => 'id',
                'format' => 'raw',
                'contentOptions' => array('class' => 'text-left'),
                'value' => function (self $model) {
                    return $model->getAgreementName();
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => new AgreementsRedactionSearch(),
                    'attribute' => 'created_at',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control']
                ]),
                'contentOptions' => ['class' => 'text-center'],
                'value' => function (self $model) {
                    return Yii::$app->formatter->asDatetime($model->created_at, 'php:d D Y H:i:s');
                }
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => new AgreementsRedactionSearch(),
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

    public function getAgreementName()
    {
        return 'Редакция договора №' . $this->id;
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%agreements__redaction}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['text', 'performer', 'performer_text'], 'string'],
            [['text', 'performer', 'performer_text'], 'required'],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
    }

}
