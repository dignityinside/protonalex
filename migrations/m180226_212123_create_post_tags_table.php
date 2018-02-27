<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_tags`.
 *
 * @author Alexander Schilling
 */
class m180226_212123_create_post_tags_table extends Migration
{
    public function up()
    {

        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%post_tags}}', [
            'post_id'         => $this->integer()->unsigned()->notNull(),
            'tag_id'         => $this->integer()->unsigned()->notNull(),
        ], $tableOptions
        );

    }

    public function down()
    {
        $this->dropTable('{{%post_tags}}');
    }
}
