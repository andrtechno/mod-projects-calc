<?php

namespace panix\mod\projectscalc\models\translate;

use yii\db\ActiveRecord;

class OffersRedactionTranslate extends ActiveRecord
{
    public static $translationAttributes = ['text'];

    public static function tableName()
    {
        return '{{%offers_redaction_translate}}';
    }

}
