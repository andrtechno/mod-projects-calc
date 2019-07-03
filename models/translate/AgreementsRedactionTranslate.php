<?php

namespace panix\mod\projectscalc\models\translate;

use yii\db\ActiveRecord;

class AgreementsRedactionTranslate extends ActiveRecord
{
    public static $translationAttributes = ['text'];

    public static function tableName()
    {
        return '{{%agreements__redaction_translate}}';
    }

}
