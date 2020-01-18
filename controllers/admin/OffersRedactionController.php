<?php

namespace panix\mod\projectscalc\controllers\admin;

use Yii;
use panix\mod\projectscalc\models\OffersRedaction;
use panix\mod\projectscalc\models\search\OffersRedactionSearch;
use panix\engine\controllers\AdminController;

class OffersRedactionController extends AdminController
{

    public $tpl_keys = array(
        '{offer_id}',
        '{client}',
        '{list}',
        '{price_layouts}',
        '{price_makeup}',
        '{price_prototype}',
        '{total_price_uah}',
        '{total_price_usd}',
        '{type}'
    );

    public function actions()
    {
        return array(
            'delete' => array(
                'class' => 'ext.adminList.actions.DeleteAction',
            ),
        );
    }

    public function actionIndex()
    {

        $this->pageName = Yii::t('projectscalc/default', 'OFFERS_REDACTION');
        $this->buttons = [
            [
                'icon' => 'add',
                'label' => Yii::t('projectscalc/default', 'CREATE_BTN'),
                'url' => ['create'],
                'options' => ['class' => 'btn btn-success']
            ]
        ];
        $this->breadcrumbs = [
            [
                'label' => Yii::t('projectscalc/default', 'MODULE_NAME'),
                'url' => ['/admin/projectscalc']
            ],
            [
                'label' => Yii::t('projectscalc/default', 'OFFERS'),
                'url' => ['/admin/projectscalc/offers']
            ],
            $this->pageName
        ];

        $searchModel = new OffersRedactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionPrint($id)
    {
        $model = OffersRedaction::model()
            ->findByPk($id);

        Yii::setPathOfAlias('Mpdf', Yii::getPathOfAlias('vendor.mpdf.mpdf.src'));

        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 9,
            'default_font' => 'times'
        ]);
        $mpdf->WriteHTML($model->text);
        $mpdf->Output("Offer_{$model->id}.pdf", 'I');
    }

    /**
     * Create or update new page
     * @param boolean $id
     */
    public function actionUpdate($id = false)
    {

        $model = OffersRedaction::findModel($id);

        $isNew = $model->isNewRecord;

        $this->pageName = ($isNew) ? 'NEW' : $model->getOfferName();
        $this->breadcrumbs = [
            [
                'label' => Yii::t('projectscalc/default', 'MODULE_NAME'),
                'url' => ['/admin/projectscalc']
            ],
            [
                'label' => Yii::t('projectscalc/default', 'OFFERS'),
                'url' => ['/admin/projectscalc/offers']
            ],
            $this->pageName
        ];

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->save();
            Yii::$app->session->setFlash('success', Yii::t('app/default', ($isNew) ? 'SUCCESS_CREATE' : 'SUCCESS_UPDATE'));
            $redirect = (isset($post['redirect'])) ? $post['redirect'] : Yii::$app->request->url;
            if (!Yii::$app->request->isAjax)
                return $this->redirect($redirect);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }


}
