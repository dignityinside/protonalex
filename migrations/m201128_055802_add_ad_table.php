<?php

use yii\db\Migration;

/**
 * Create ad table
 *
 * @author Alexander Schilling
 */
class m201128_055802_add_ad_table extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{%ad}}', [
            'id'           => $this->primaryKey(),
            'title'        => $this->string(255)->null(),
            'description'  => $this->string(255)->null(),
            'url'          => $this->string(255)->null(),
            'banner_img'   => $this->string(255)->null(),
            'code'         => $this->string(255)->null(),
            'slot'         => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'target_blank' => $this->boolean()->notNull()->defaultValue(1),
            'rel_nofollow' => $this->boolean()->notNull()->defaultValue(1),
            'status'       => "ENUM('draft', 'public', 'deleted', 'archived') NOT NULL DEFAULT 'draft'",
            'hits'         => $this->bigInteger()->unsigned()->null()->defaultValue(0),
            'clicks'       => $this->bigInteger()->unsigned()->null()->defaultValue(0),
            'views'        => $this->bigInteger()->unsigned()->null()->defaultValue(0),
            'notice'       => $this->string(255)->null(),
            'paid_until'   => $this->dateTime(),
            'slug'         => $this->string(255)->notNull(),
            'created_at'   => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at'   => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'KEY `status_index` (`status`)',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

    }

    public function down()
    {
        $this->dropTable('{{%ad}}');
    }
}
