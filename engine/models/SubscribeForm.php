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

use yii\base\Model;

/**
 * Subscribe model. Email.
 */
class SubscribeForm extends Model
{
    /**
     * @var string
     */
    public $email = '';
    public $reCaptcha = '';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $rules = [
            ['email', 'email'],
            [['email'], 'string', 'max' => 100]
        ];

        if ($captchaSecretKey = options()->get('app.settings.common.captchaSecretKey', '')) {
            $rules[] = [
                ['reCaptcha'],
                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => $captchaSecretKey
            ];
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email'    =>  t('app', 'Email Address')
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function subscribePageAttribute() {
        return [
            'page_id'  =>  'subscribe-form'
        ];
    }
}
