<?php

namespace panix\mod\projectscalc\controllers\admin;

use Yii;
use panix\mod\projectscalc\models\AgreementsRedaction;
use panix\mod\projectscalc\models\search\AgreementsRedactionSearch;
use panix\engine\controllers\AdminController;

class AgreementsRedactionController extends AdminController
{

    public $tpl_keys = array(
        '{agreement_id}',
        '{date}',
        '{performer}',
        '{customer_fullname}',
        '{customer_text}',
        '{programming_days}',
        '{layouts_days}',
        '{price}',
        '{price_text}',
        '{price_original}',
        '{price_original_text}'
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
        $this->pageName = Yii::t('projectscalc/default', 'AGREEMENTS_REDACTION');
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
                'label' => Yii::t('projectscalc/default', 'AGREEMENTS'),
                'url' => ['/admin/projectscalc/agreements']
            ],
            $this->pageName
        ];

        $searchModel = new AgreementsRedactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Create or update new page
     * @param boolean $id
     */
    public function actionUpdate($id = false)
    {

        $model = AgreementsRedaction::findModel($id);

        $this->pageName = ($model->isNewRecord) ? 'New' : $model->getAgreementName();


        $this->breadcrumbs = [
            [
                'label' => Yii::t('projectscalc/default', 'MODULE_NAME'),
                'url' => ['/admin/projectscalc']
            ],
            [
                'label' => Yii::t('projectscalc/default', 'AGREEMENTS'),
                'url' => ['/admin/projectscalc/agreements']
            ],
            [
                'label' => Yii::t('projectscalc/default', 'AGREEMENTS_REDACTION'),
                'url' => ['index']
            ],
            $this->pageName
        ];

        $isNew = $model->isNewRecord;
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
