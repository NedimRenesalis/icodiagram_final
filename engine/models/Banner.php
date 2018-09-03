<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://www.easyads.io
 * @copyright  2017 EasyAds (https://www.easyads.io)
 * @license    https://www.easyads.io
 * @since      1.0
 */

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Banner
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $image
 * @property string $url
 * @property string $client
 * @property string $adspace
 * @property int $visit_count
 * @property string $created_at
 * @property string $updated_at
 * @property string $valid_from
 * @property string $valid_until
 * @property string $comment
 */
class Banner extends \app\yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true,
            ],
            [
                'class' => TimestampBehavior::className(),
                'value' => date('Y-m-d G:i:s'),
            ],
        ];
    }

    public function isActive()
    {
        $now = time();

        if ($this->active !== 1) {
            return false;
        }

        $valid_from = strtotime($this->valid_from);
        $valid_until = strtotime($this->valid_until);

        return $valid_from <= $now && $valid_until >= $now;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'image', 'url'], 'required'],
            [['visit_count', 'active'], 'integer'],
            [['created_at', 'updated_at', 'valid_from', 'valid_until', 'slug'], 'safe'],
            [['comment'], 'string'],
            [['url'], 'url'],
            [['title', 'slug', 'image', 'url', 'client', 'adspace'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => t('app', 'ID'),
            'title' => t('app', 'Title'),
            'slug' => t('app', 'Slug'),
            'image' => t('app', 'Image'),
            'url' => t('app', 'Url'),
            'client' => t('app', 'Client'),
            'adspace' => t('app', 'Adspace'),
            'visit_count' => t('app', 'Visit Count'),
            'created_at' => t('app', 'Created At'),
            'updated_at' => t('app', 'Updated At'),
            'valid_from' => t('app', 'Valid From'),
            'valid_until' => t('app', 'Valid Until'),
            'comment' => t('app', 'Comment'),
            'active' => t('app', 'Active'),
        ];
    }
}
