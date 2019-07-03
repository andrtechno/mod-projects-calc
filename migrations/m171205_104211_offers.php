<?php

use panix\engine\db\Migration;
use panix\mod\projectscalc\models\Offers;
use panix\mod\projectscalc\models\OffersRedaction;
use panix\mod\projectscalc\models\translate\OffersRedactionTranslate;

class m171205_104211_offers extends Migration {

    public function up() {
        $this->createTable(Offers::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'redaction_id' => $this->integer()->unsigned(),
            'calc_id' => $this->integer()->unsigned(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->createTable(OffersRedaction::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->createTable(OffersRedactionTranslate::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'language_id' => $this->tinyInteger()->unsigned(),
            'object_id' => $this->integer()->unsigned(),
            'text' => $this->text(),
        ]);

        
        $this->createIndex('redaction_id', Offers::tableName(), 'redaction_id');
        $this->createIndex('calc_id', Offers::tableName(), 'calc_id');
        
        $this->createIndex('language_id', OffersRedactionTranslate::tableName(), 'language_id');
        $this->createIndex('object_id', OffersRedactionTranslate::tableName(), 'object_id');
    }

    public function down() {
        $this->dropTable(Offers::tableName());
        $this->dropTable(OffersRedaction::tableName());
        $this->dropTable(OffersRedactionTranslate::tableName());
    }

}
