<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    if ($action == 'update') {
        $this->title = t('app', 'Update Banner:  ') . $model->title;
        $this->params['breadcrumbs'][] = ['label' => t('app', 'Banner'), 'url' => ['index']];
        $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->slug]];
        $this->params['breadcrumbs'][] = t('app', 'Update');
    }else{
        $this->title = t('app', 'Register new Banner');
        $this->params['breadcrumbs'][] = ['label' => t('app', 'Banner'), 'url' => ['index']];
        $this->params['breadcrumbs'][] = $this->title;
    }
?>
<div class="box box-primary categories-index">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-ban" aria-hidden="true"></i> '.t('app', 'Cancel'), ['index'], ['class' => 'btn btn-sm btn-transparent']) ?>
        </div>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin();?>
        <div class="row">
            <div class="col-md-6">
                <?=$form->field($model, 'title')->textInput(['maxlength' => true])?>
                <?=$form->field($model, 'image')->textInput(['maxlength' => true])?>
                <?=$form->field($model, 'valid_from')->textInput(['type' => 'date'])?>
                <?=$form->field($model, 'client')->textInput(['maxlength' => true])?>
            </div>
            <div class="col-md-6">
                <?=$form->field($model, 'adspace')->dropDownList([
                    'location_top' => 'Top',
                    'location_bottom' => 'Bottom',
                    'location_right' => 'Right',
                ])?>
                <?=$form->field($model, 'url')->textInput(['maxlength' => true])?>
                <?=$form->field($model, 'valid_until')->textInput(['type' => 'date'])?>
                <?=$form->field($model, 'active')->dropDownList([
                    0 => t('app', 'No'),
                    1 => t('app', 'Yes'),
                ])?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?=$form->field($model, 'comment')->textarea(['rows' => 6])?>
            </div>
        </div>

        
        <div class="box-footer">
            <div class="pull-right">
                <?=Html::submitButton(t('app', 'Save'), ['class' => 'btn btn-primary'])?>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>

        <?php ActiveForm::end();?>
    </div>
</div>