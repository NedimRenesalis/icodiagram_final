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

namespace app\controllers;

use Yii;
use app\models\SubscribeForm;
use app\models\auto\Subscribe;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\GoneHttpException;


/**
 * Class SubscribeController
 * @package app\controllers
 */
class SubscribeController extends Controller
{
    /**
     * Action subscribe.
     */
    public function actionSubscribe()
    {
        $model = new SubscribeForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $data = new Subscribe();
                $data['email'] = strtolower($model->email);
                $data->save();
                notify()->addSuccess(t('app', 'Successfully subscribed!'));
            }   
            catch (Exception $e) {
                notify()->addError(t('app', 'Something went wrong!'));
            }
        } 
        else {
            notify()->addError(t('app', 'Something went wrong!'));
        }

        return $this->redirect(['/']);
    }

    /**
     * Gets all emails.
     * @return Subscribe[]
     */
    public static function getAll() {
        return ArrayHelper::toArray(Subscribe::find()->select(Subscribe::getEmailField())->all());
    }
}