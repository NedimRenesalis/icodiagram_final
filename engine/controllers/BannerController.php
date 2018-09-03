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
use app\models\Banner;
use app\models\BannerSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\GoneHttpException;

/**
 * Class SubscribeController
 * @package app\controllers
 */
class BannerController extends Controller
{
    /**
     * Action subscribe.
     */
    public function actionVisit($id)
    {
        $banner = $this->findModel($id);

        if (!$banner->isActive()) {
            throw new GoneHttpException(t('app', 'The requested banner is not active anymore.'));
        }

        $banner->updateCounters(['visit_count' => 1]);

        return $this->redirect($banner->url);
    }

   /**
     * Finds the Banner model based on its primary key value.
     * 
     * @param string $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::find()->where(['slug' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested banner does not exist.');
        }
    }
}