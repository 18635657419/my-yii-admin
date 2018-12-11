<?php

use yii\db\Migration;

/**
 * Class m180627_110818_create_media
 */
class m181211_155220_create_media extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT="媒体资源表"';
        }
        $this->createTable('{{%media}}', [
            'media_id'       => $this->primaryKey(11)->unsigned()->comment('主键'),
            'name'           => $this->string(100)->notNull()->comment('资源名称'),
            'url'            => $this->string(100)->comment('本地服务器地址'),
            'http_url'       => $this->string(250)->comment('网络地址'),
            'type'           => $this->tinyInteger()->unsigned()->notNull()->comment('类型：1.图片2.音频3.视频'),
            'category_id'    => $this->integer()->unsigned()->notNull()->comment('分组id,category表S=pic_group/S=audio_group/S=video_group'),
            'key'            => $this->string(512)->notNull()->defaultValue('')->comment('文件对应到云存储服务中的唯一标识,未来扩展七牛云备用'),
            'description'    => $this->string(1024)->notNull()->defaultValue('')->comment('文件的描述内容'),
            'height'         => $this->smallInteger()->unsigned()->comment('高度'),
            'width'          => $this->smallInteger()->unsigned()->comment('宽度'),
            'size'           => $this->smallInteger()->unsigned()->comment('大小'),
            'status'         => $this->tinyInteger()->notNull()->defaultValue(1)->comment('状态:0,软删除，1，正常'),
            'created_at'     => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('创建时间戳'),
            'updated_at'     => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('修改时间戳'),
            'FOREIGN KEY ([[category_id]]) REFERENCES {{%category}} ([[category_id]]) ON DELETE NO ACTION ON UPDATE NO ACTION',
        ], $tableOptions);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('media');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180627_110818_create_media cannot be reverted.\n";

        return false;
    }
    */
}
