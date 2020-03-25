<?php

use yii\db\Migration;

/**
 * Handles the add of new columns to table `video`.
 *
 * @author Alexander Schilling
 */
class m200322_091538_add_new_colums_video extends Migration
{
    /**
     * @return bool|void
     */
    public function up()
    {
        $this->addColumn('{{%video}}', 'playlist', $this->string(255)->null());
        $this->addColumn('{{%video}}', 'channel_url', $this->string(255)->null());
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->dropColumn('{{%video}}', 'playlist');
        $this->dropColumn('{{%video}}', 'channel_url');
    }
}
