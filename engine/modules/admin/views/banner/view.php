<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    $this->title = $banner->title;
    $this->params['breadcrumbs'][] = ['label' => t('app', 'Banner'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary categories-index">
    <div class="box-header">
        <div class="pull-left">
            <h2 class="box-title"><?= Html::encode($this->title) ?></h2>
        </div>

        <div class="pull-right">
            <?= Html::a(t('app', 'Update'), ['update', 'id' => $banner->slug], ['class' => 'btn btn-xs btn-success']) ?>
            <?= Html::a(t('app', 'Delete'), ['delete', 'id' => $banner->slug], [
                'class' => 'btn btn-xs btn-danger',
                'data' => [
                    'confirm' => t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="box-body">
        <?= DetailView::widget([
            'model' => $banner,
            'attributes' => [
                'id',
                'title',
                'slug',
                'image',
                'url:url',
                'client',
                'adspace',
                'visit_count',
                'created_at',
                'updated_at',
                'valid_from',
                'valid_until',
                'comment:ntext',
            ],
        ]) ?>
    </div>
</div>