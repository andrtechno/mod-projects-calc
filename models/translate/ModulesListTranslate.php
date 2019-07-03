<?php

namespace panix\mod\projectscalc\models\translate;

use yii\db\ActiveRecord;

class ModulesListTranslate extends ActiveRecord
{

    public static $translationAttributes = ['title', 'full_text'];

    public static function tableName()
    {
        return '{{%projects_calc_modules_translate}}';
    }

}