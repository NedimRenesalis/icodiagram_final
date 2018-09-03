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

    namespace app\modules\admin\controllers;

    use app\models\Banner;
    use app\models\BannerSearch;
    use Yii;
    use yii\filters\AccessControl;
    use yii\filters\VerbFilter;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;

/**
 * Controls the actions for banner module.
 * @Class BannerController
 */
class BannerController extends \app\modules\admin\yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all banners.
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(request()->queryParams);
        $dataProvider->pagination->pageSize = 20;

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * View detailed banner information
     *
     * @param $id of the banner
     */
    public function actionView($id)
    {
        $banner = $this->findModel($id);

        return $this->render('view', [
            'banner' => $banner,
        ]);
    }

    /**
     * Creates a new banner.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banner();

        $model->active = true;
        $model->visit_count = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('form', [
                'action'=> 'create',
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing banner model.
     *
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('form', [
                'action'=> 'update',
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing banner model.
     *
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Banner model based on its id.
     *
     * @param string $id
     * @return Banner wanted model
     * @throws NotFoundHttpException model not found
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