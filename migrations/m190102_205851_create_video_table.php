<?php

use yii\db\Migration;

/**
 * Handles the creation of table `video`.
 *
 * @author Alexander Schilling
 */
class m190102_205851_create_video_table extends Migration
{

    /**
     * @return bool|void
     */
    public function up()
    {

        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%video}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'code' => $this->string(255)->null(),
            'platform' => $this->string(255)->null(),
            'thumbnail' => $this->string(255)->null(),
            'published' => $this->integer()->unsigned()->notNull(),
            'author' => $this->string(255)->null(),
            'user_id' => $this->bigInteger()->unsigned()->notNull()->defaultValue(0),
            'status_id' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(1),
            'category_id' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'hits' => $this->bigInteger()->unsigned()->null()->defaultValue(0),
            'allow_comments' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'meta_description' => $this->string(255)->null(),
            'language' => $this->string(2)->null()->defaultValue('ru')
        ], $tableOptions
        );

        $this->createIndex('idx-title-unique', '{{%video}}', 'title', true);

    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%video}}');
    }
}
