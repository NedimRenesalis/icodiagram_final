<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
    use yii\widgets\Pjax;

    $this->title = t('app', 'Subscribers');
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary subscribers-index">

    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?=Html::encode($this->title)?></h3>
        </div>
        <div class="pull-right">
            <?=Html::a(Html::tag('i', '', ['class' => 'fa fa-refresh fa-fw']) . t('app', 'Refresh'), ['index'], ['class' => 'btn btn-xs btn-success'])?>
        </div>
    </div>

    <div class="box-body">
        <?php Pjax::begin([
            'enablePushState' => true,
        ]);?>
        <?=GridView::widget([
            'id' => 'subscribers',
            'tableOptions' => [
                'class' => 'table table-bordered table-hover table-striped',
            ],
            'options' => ['class' => 'table-responsive grid-view'],
            'dataProvider'  => $dataProvider,
            'filterModel'   => $searchModel,
            'columns' => [
                'email',
                'created_at',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => [
                        'style' => 'width:145px',
                        'class' => 'table-actions',
                    ],
                    'template' => '{delete}',
                ],
            ],
        ]);?>
        <?php Pjax::end();?>
    </div>
</div>
