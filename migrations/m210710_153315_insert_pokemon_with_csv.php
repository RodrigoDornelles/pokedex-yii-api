<?php

use League\Csv\Reader;
use yii\db\Migration;

/**
 * Class m210710_153315_insert_pokemon_with_csv
 */
class m210710_153315_insert_pokemon_with_csv extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $csv = Reader::createFromPath('data/pokemon.csv', 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            $this->insert('pokemon', $record);
        }

        // sets null in empty type 2
        $this->update('pokemon', ['type_2' => null], ['type_2' => '']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('pokemon');
    }
}
