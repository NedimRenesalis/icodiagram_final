<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use app\helpers\FrontendHelper;
use yii\helpers\ArrayHelper;
use app\models\Currency;
?>
<div class="listing-search">

    <div class="container">

        <div class="row">
            <div class="col-lg-8 col-lg-push-2 col-md-12 col-sm-12 col-xs-12">

                <?php $form = ActiveForm::begin([
                    'action'      => ['/site/search-map'],
                    'method'      => 'get',
                    'fieldConfig' => ['options' => ['class' => 'input-group']],
                    'options'     => ['class' => 'searchArea search-form search-map',]
                ]); ?>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                        <?= $form->field($searchModel, 'searchPhrase', [
                            'template' => "{label}\n<i class='fa fa-search' aria-hidden='true'></i>\n{input}\n{hint}\n{error}"
                        ])->textInput(['placeholder' => t('app', 'Keywords...')])->label(false) ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="input-group">
                            <?= $form->field($searchModel, 'location')->widget(Select2::classname(), [
                                'initValueText' => $locationDetails, // set the initial display text
                                'options'       => ['placeholder' => t('app', 'Location'), "class" => "select2-custom"],
                                'pluginOptions' => [
                                    'language'           => [
                                        'inputTooShort'=> new JsExpression('function () { return "'. t('app', 'Please enter more characters...') .'" }')
                                    ],
                                    'allowClear'         => true,
                                    'minimumInputLength' => 3,
                                    'ajax'               => [
                                        'url'      => url(['category/location'], true),
                                        'dataType' => 'json',
                                        'data'     => new JsExpression('function(params) { return {term:params.term}; }'),
                                        'delay'    => 250,
                                    ],
                                    'theme'              => Select2::THEME_DEFAULT,
                                ],
                            ])->label(false); ?>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 hidden-xs">
                        <div class="form-group">
                            <a href="#" id="choose-class" class="form-control" data-toggle="modal"
                               data-target="#modal-search-category"><?= html_purify($categoryPlaceholderText); ?></a>
                        </div>
                        <?= $form->field($searchModel, 'categorySlug', [
                            'template' => '{input} {error}',
                        ])->hiddenInput(['class' => 'form-control'])->label(false); ?>
                    </div>

                    <div class="modal fade" id="modal-search-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog add-category" role="document">
                            <div class="modal-content">
                                <div class="modal-body" id="modal-body-map" data-url-search="<?= url(['/category/map-view/']); ?>">
                                    <div class="choose-category">

                                        <div class="column-category primary-category">
                                            <h4>Categories</h4>

                                            <div class="category-items mCustomScrollbar mCS-autoHide">
                                                <ul>
                                                    <?php foreach ($categories as $category) {
                                                        if (empty($category->parent_id)) { ?>
                                                            <li><a href="#" data-id="<?= (int)$category->category_id; ?>" data-slug="<?= html_encode($category->slug); ?>"><span><i class="fa <?= html_encode($category->icon); ?>" aria-hidden="true"></i></span><span><?= html_encode($category->name); ?></span></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="column-subcategory mCustomScrollbar mCS-autoHide">
                                            <div class="column-subcategory-wrapper">
                                                <?php $sortedCategories = FrontendHelper::getCategoriesSorted($categories);
                                                if ($sortedCategories) foreach ($sortedCategories as $sortedCategoryId => $sortedCategory) { ?>
                                                    <div class="column-category" data-parent="<?= (int)$sortedCategoryId; ?>" style="display: none">
                                                        <h4><?= html_encode($sortedCategory['name']); ?></h4>
                                                        <div class="category-items mCustomScrollbar mCS-autoHide">
                                                            <ul>
                                                                <?php foreach ($sortedCategory['children'] as $childCategory) { ?>
                                                                    <li><a href="#" data-slug="<?= html_encode($childCategory->slug); ?>" data-id="<?= (int)$childCategory->category_id; ?>" class="subcateg"><span><?= html_encode($childCategory->name); ?></span></a></li>
                                                                <?php } ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <span class="no-category-selected"><?= t('app', 'Please select a specific category'); ?></span>
                                            <button id="success-selection" type="button" class="btn-as" style="display: none"
                                                    data-dismiss="modal"><?= t('app', 'Submit'); ?></button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <button id="close-modal" type="button" class="btn-as danger-action pull-right"
                                                    data-dismiss="modal"><?= t('app', 'Cancel'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hidden-lg hidden-md hidden-sm">
                        <div class="form-group">
                            <a href="javascript:;" id="choose-class-m-search" class="form-control choose-catg-m-search"><?=t('app', 'Choose category');?></a>
                        </div>
                    </div>
                    <div class="choose-category-mobile" id="modal-search-category-mobile">
                        <a href="#" class="close-x-categ-m"><i class="fa fa-times" aria-hidden="true"></i></a>
                        <div class="maincateg-m">
                            <div class="heading">
                                <a href="#" class="close-categ-m"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> <?=t('app', 'Choose category');?>
                            </div>
                            <ul class="categ-items">
                                <?php foreach ($categories as $category) {
                                    if (empty($category->parent_id)) { ?>
                                        <li>
                                            <a href="#" data-id="<?=(int)$category->category_id;?>" class="categ-item-m" data-slug="<?=html_encode($category->slug);?>" data-subcateg="<?= (!empty($category->children)) ? html_encode($category->slug) : '';?>">
                                                <span><i class="fa <?=html_encode($category->icon);?>" aria-hidden="true"></i></span>
                                                <span><?=html_encode($category->name);?></span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <?php $sortedCategories = FrontendHelper::getCategoriesSorted($categories);
                        if ($sortedCategories) foreach ($sortedCategories as $sortedCategoryId=>$sortedCategory) { ?>
                            <div id="subcateg-<?=html_encode($sortedCategory['slug']);?>" class="subcateg-m">
                                <div class="heading">
                                    <a href="#" data-parent="<?=(int)$sortedCategoryId;?>"  class="back-categ-m"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> <?=html_encode($sortedCategory['name']);?>
                                </div>
                                <ul class="categ-items">
                                    <li class="parent-option"><a href="#" data-id="<?=(int)$sortedCategoryId;?>" data-slug="<?=html_encode($sortedCategory['slug']);?>" class="categ-subitem-m"><i class="fa fa-angle-double-right" aria-hidden="true"></i><span class="search-hint"><?=t('app', 'Search in')?></span><?=html_encode($sortedCategory['name']);?></a></li>
                                    <?php foreach ($sortedCategory['children'] as $childCategory) { ?>
                                        <li><a href="#" data-id="<?=(int)$childCategory->category_id;?>" data-slug="<?=html_encode($childCategory->slug);?>" data-subcateg="<?= (!empty($childCategory->children)) ? html_encode($childCategory->slug) : '';?>" class="categ-subitem-m"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?=html_encode($childCategory->name);?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12">
                        <?= $form->field($searchModel, 'minPrice', ['options' => ['class' => 'input-group no-icon']])->textInput(['placeholder' => t('app', 'Min Price')])->label(false) ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12">
                        <?= $form->field($searchModel, 'maxPrice', ['options' => ['class' => 'input-group no-icon']])->textInput(['placeholder' => t('app', 'Max Price')])->label(false) ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <?= $form->field($searchModel, 'currency_id', [
                            'template' => '{input}',
                        ])->dropDownList(ArrayHelper::map(Currency::getActiveCurrencies(), 'currency_id', 'name'), ['class' => '', 'prompt' => t('app', 'Currency')])->label(false);
                        ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                         <?= $form->field($searchModel, 'negotiable', [
                            'options' => [
                                'class' => 'input-group checkbox icheck'
                            ],
                        ])->checkbox(['template' => '{input} {label}'], ['value' => false]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <?= Html::submitButton(t('app', 'Search'), ['class' => 'btn-as']) ?>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                        <?= Html::a(t('app', 'Reset'), ['site/search-map'], ['class' => 'btn-as reverse']) ?>
                    </div>
                    <?php if ($locationDetails && options()->get('app.settings.common.disableMap', 0) == 0 ) { ?>
                        <div class="col-lg-3 col-lg-offset-5 col-md-3 col-md-offset-5 col-sm-4 col-sm-offset-4 col-xs-12">
                            <?=Html::submitButton(t('app', 'Show List'), ['class' => 'btn-as', 'formaction' => url(['/site/search'])]) ?>
                        </div>
                    <?php } ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>
