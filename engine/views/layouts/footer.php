<?php
    use app\components\CategoriesListWidget;
    use app\components\PageSectionWidget;
    use app\components\SocialMediaListWidget;
    use app\models\Page;

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<footer id="footer">
    <!-- Publish ICO -->
    <div class="post-add-bar no-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                            <center>
                                <span class="pull-right">
                                    <?=t('app', 'ICO discovery platform')?>
                                </span>
                            </center>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <center>
                                <a href="<?=url(['/listing/post']);?>" class="btn-as secondary">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    <?=t('app', 'Publish ICO');?>
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Publish ICO -->

    <!-- Subscribe -->
    <div class="subscribe">
        <section class="main-search subscribe-footer">
            <div class="container">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'fieldConfig' => ['options' => ['class' => 'input-group']],
                    'action' => ['subscribe/subscribe'],
                    'options' => [
                        'class' => 'search-form',
                    ],
                ]);?>

                <label><?=t('app', 'Subscribe')?></label>
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <?=$form->field($subscribeModel, 'email', [
                            'template' => "{label}\n<i class='fa fa-envelope-o' aria-hidden='true'></i>\n{input}\n{hint}\n{error}",
                        ])->textInput(['placeholder' => t('app', 'Email Address')])->label(false)?>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group no-padding">
                            <?=Html::submitButton(t('app', 'Subscribe'), ['class' => 'btn-as'])?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end()?>
            </div>
        </section>
    </div>
    <!-- /Subscribe -->

    <!-- Footer rest -->
    <center>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                </div>
            </div>
            <center>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?=PageSectionWidget::widget(['sectionType' => Page::SECTION_ONE])?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?=PageSectionWidget::widget(['sectionType' => Page::SECTION_TWO])?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?=SocialMediaListWidget::widget(['title' => t('app', 'Connect')])?>
                    </div>
                </div>
            </center>
        </div>
    </center>
    <!-- /Footer rest -->
</footer>