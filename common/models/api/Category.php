<?php

namespace common\models\api;

use Yii;

/**
 * This is the model class for table "rf_category".
 *
 * @property int $category_id 主键
 * @property int $category_pid 父级id
 * @property string $symbol 标识
 * @property string $thumb 分类图标
 * @property string $name 名称
 * @property int $sort 排序
 * @property string $data 其他配置项JSON编码
 * @property int $created_at 创建时间戳
 * @property int $updated_at 修改时间戳
 *
 * @property Media[] $media
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rf_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_pid', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['symbol', 'name'], 'required'],
            [['data'], 'string'],
            [['symbol', 'name'], 'string', 'max' => 20],
            [['thumb'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'category_pid' => 'Category Pid',
            'symbol' => 'Symbol',
            'thumb' => 'Thumb',
            'name' => 'Name',
            'sort' => 'Sort',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['category_id' => 'category_id']);
    }
}
