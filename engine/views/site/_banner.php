<?php

use app\models\Banner;
use yii\helpers\Html;
use yii\helpers\Url;

$now = date('Y-m-d G:i:s');
$query = Banner::find();

if ($adspace) {
    $query->andWhere(['adspace' => $adspace]);
}

$query->andWhere(['active' => 1]);
$query->andWhere(['<=', 'valid_from', $now]);
$query->andWhere(['>=', 'valid_until', $now]);

$query->orderBy('rand()');

$banners = $query->limit(4)->all();

if ($banners) {
    $centeredBanner = new stdClass();
    if(count($banners) % 2 == 1) {
        $centeredBanner = $banners[0];
        unset($banners[0]);
    }

    foreach ($banners as $banner) {
        echo Html::a("
            <img class=\"thumbnail banner\" src=\"/{$banner->image}\">
            </img>", 
        ['//banner/visit', 'id' => $banner->slug], ['class' => 'banner col-md-6 col-sm-12 col-lg-6', 'target' => '_blank']);
    }

    if((array)$centeredBanner) {
        echo Html::a("
            <img class=\"thumbnail banner\" src=\"/{$centeredBanner->image}\">
            </img>", 
        ['//banner/visit', 'id' => $centeredBanner->slug], ['class' => 'banner col-md-6 col-md-offset-3 col-sm-12 col-lg-6 col-lg-offset-3', 'target' => '_blank']);

    }

}