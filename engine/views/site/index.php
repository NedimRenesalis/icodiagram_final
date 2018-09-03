<?php
use app\components\AdsListWidget;
use app\assets\AppAsset;
use app\models\Listing;

AppAsset::register($this);
$this->title = html_encode(options()->get('app.settings.common.siteName', 'EasyAds'));
$controller = app()->controller;
$isHome = $controller->action->id === 'preicos' ? false : true;

$event_type = Yii::$app->getRequest()->getQueryParam('event_type');
$event_type = $event_type ? (($event_type == Listing::EVENT_TYPE_ACTIVE) ? Listing::EVENT_TYPE_ACTIVE :  Listing::EVENT_TYPE_UPCOMING) : Listing::EVENT_TYPE_ACTIVE;
?>

<section class="main-search">
    <?= $this->render('_homepage-search', [
            'searchModel' => $searchModel,
    ]); ?>

</section>

<!-- BANNERS TOP -->
<div class="banner-top">
    <div class="container">
        <div class="row">
            <?php
                echo $this->render('_banner', ['adspace' => 'location_top']);
            ?>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="mb10 col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 col-sm-12 hidden-xs">
            <?php app()->trigger('home.under.categories', new \app\yii\base\Event()); ?>
        </div>
    </div>
</div>

<div class="inbox">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="<?php if($isHome) echo 'active';?>"><a href="<?= url(['/']); ?>"><?=t('app', 'ICOs')?></a></li>
        <li class="<?php if(!$isHome) echo 'active';?>"><a href="<?= url(['/pre-icos']); ?>"><?=t('app', 'Pre-ICOs')?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="active-conversations">

            <div class="container">
                <div class="row active-upcomping-tabs">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <a class="<?php if(!isset($event_type) || $event_type == Listing::EVENT_TYPE_ACTIVE) echo 'active'; ?>" href="<?=app()->request->getPathInfo()?>?event_type=active"><?=t('app', 'Active')?></a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <a class="<?php if(isset($event_type) && $event_type == Listing::EVENT_TYPE_UPCOMING) echo 'active'; ?>" href="<?=app()->request->getPathInfo()?>?event_type=upcoming"><?=t('app', 'Upcoming')?></a>
                    </div>
                </div>
                <div class="row">
                    <div id="p0" data-pjax-container="" data-pjax-push-state="" data-pjax-timeout="1000">
                        <div id="active-conversations" class="list-view">
                            <div class="empty">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?= $promoted = AdsListWidget::widget(['listType' => AdsListWidget::LIST_TYPE_PROMOTED, 'type' => $isHome ? 1 : 0,'event_type' => $event_type, 'title' => t('app', ''), 'quantity' => options()->get('app.settings.common.homePromotedNumber', 8)]) ?>
                                    <?php
                                    if (!empty($promoted)) {
                                        echo AdsListWidget::widget(['listType' => AdsListWidget::LIST_TYPE_NEW, 'type' => $isHome ? 1 : 0, 'event_type' => $event_type, 'title' => t('app', 'New ICOs'), 'emptyTemplate' => false, 'quantity' => options()->get('app.settings.common.homeNewNumber', 8)]);
                                    } else {
                                        echo AdsListWidget::widget(['listType' => AdsListWidget::LIST_TYPE_NEW, 'type' => $isHome ? 1 : 0, 'event_type' => $event_type, 'title' => t('app', 'New ICOs'), 'emptyTemplate' => true, 'quantity' => options()->get('app.settings.common.homeNewNumber', 8)]);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 col-sm-12 hidden-xs">
            <?php app()->trigger('home.above.footer', new \app\yii\base\Event()); ?>
        </div>
    </div>
</div>