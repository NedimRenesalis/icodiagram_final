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

namespace app\models\auto;

/**
 * This is the ActiveQuery class for [[Subscribe]].
 *
 * @see Subscribe
 */
class SubscribeQuery extends \app\yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     * @return Subscribe[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Subscribe|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
