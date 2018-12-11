<?php

namespace common\models\api;

use Yii;

/**
 * This is the model class for table "rf_media".
 *
 * @property int $media_id 主键
 * @property string $name 资源名称
 * @property string $url 本地服务器地址
 * @property string $http_url 网络地址
 * @property int $type 类型：1.图片2.音频3.视频
 * @property int $category_id 分组id,category表S=pic_group/S=audio_group/S=video_group
 * @property string $key 文件对应到云存储服务中的唯一标识,未来扩展七牛云备用
 * @property string $description 文件的描述内容
 * @property int $height 高度
 * @property int $width 宽度
 * @property int $size 大小
 * @property int $status 状态:0,软删除，1，正常
 * @property int $created_at 创建时间戳
 * @property int $updated_at 修改时间戳
 *
 * @property Category $category
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rf_media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'category_id'], 'required'],
            [['type', 'category_id', 'height', 'width', 'size', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'url'], 'string', 'max' => 100],
            [['http_url'], 'string', 'max' => 250],
            [['key'], 'string', 'max' => 512],
            [['description'], 'string', 'max' => 1024],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'media_id' => 'Media ID',
            'name' => 'Name',
            'url' => 'Url',
            'http_url' => 'Http Url',
            'type' => 'Type',
            'category_id' => 'Category ID',
            'key' => 'Key',
            'description' => 'Description',
            'height' => 'Height',
            'width' => 'Width',
            'size' => 'Size',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }
}
