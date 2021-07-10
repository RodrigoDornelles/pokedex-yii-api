<?php

use yii\db\Migration;

/**
 * Class m210710_140413_create_table_pokemon
 */
class m210710_140413_create_table_pokemon extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {   
        $this->createTable('pokemon', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->notNull(),
            'name' => $this->string(128)->notNull(),
            'type_1' => $this->string(32)->notNull(),
            'type_2' => $this->string(32),
            'total' => $this->integer()->notNull(),
            'hp' => $this->integer()->notNull(),
            'attack' => $this->integer()->notNull(),
            'defense' => $this->integer()->notNull(),
            'special_attack' => $this->integer()->notNull(),
            'special_defence' => $this->integer()->notNull(),
            'speed' => $this->integer()->notNull(),
            'generation' => $this->integer()->notNull(),
            'legendary' => $this->boolean()->notNull()->defaultValue(false),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('pokemon');
    }
}
