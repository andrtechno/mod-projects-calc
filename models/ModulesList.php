<?php

namespace panix\mod\projectscalc\models;

use Yii;
use panix\engine\Html;
use panix\mod\projectscalc\models\translate\ModulesListTranslate;
use panix\engine\db\ActiveRecord;

class ModulesList extends ActiveRecord
{

    const MODULE_ID = 'projectscalc';
    const route = '/admin/projectscalc/modules';
    public $translationClass = ModulesListTranslate::class;

    public function getGridColumns()
    {
        return [
            'title' => [
                'attribute' => 'title',
                'format' => 'raw',
                'contentOptions' => array('class' => 'text-left'),
            ],
            'price' => [
                // 'class' => 'EditableColumn',
                'attribute' => 'price',
                'format' => 'raw',
                'contentOptions' => array('class' => 'text-center'),
                //'value' => '$data->price',
            ],
            'type_id' => [
                'attribute' => 'type_id',
                'format' => 'raw',
                'contentOptions' => array('class' => 'text-center'),
                'filter' => self::getTypeList(),
                'value' => function ($model) {
                    $list = self::getTypeList();
                    return $list[$model->type_id];
                }
            ],
            'DEFAULT_CONTROL' => [
                'class' => 'panix\engine\grid\columns\ActionColumn',
                'template' => '{print}{update}{delete}',
                'buttons' => [
                    'print' => function ($url, $model, $key) {
                        return Html::a('<i class="icon-print"></i>', ['/admin/projectscalc/modules/pdf', 'id' => $model->id], [
                            'title' => Yii::t('yii', 'VIEW'),
                            'class' => 'btn btn-sm btn-info linkTarget',
                            'target' => '_blank'
                        ]);
                    },
                ]
            ],
            'DEFAULT_COLUMNS' => [
                ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%projects_calc_modules}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['title', 'type_id', 'price'], 'required'],
            [['full_text'], 'string'],
            // [['type_id', 'documentation_id'], 'integer'],
        ];
    }

    public static function getTypeList()
    {
        return array(
            1 => 'Модуль',
            2 => 'Дополнение',
        );
    }

}
