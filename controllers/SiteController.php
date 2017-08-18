<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Tree;
use yii\web\UploadedFile;
use yii\helpers\Json;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new Tree();
        $session = Yii::$app->session;
        $session->open();
        $session->remove('filepath');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->select = (bool)$model->select;
            if ($model->select) {
                $model->json = str_replace('\\', '/', $model->json);
                $session['filepath'] = $model->json;
                return $this->redirect(['tree']);
            } else {
                $file = UploadedFile::getInstance($model, 'jsonFile');
                $filepath = $model->upload($file);
                if ($filepath) {
                    $session['filepath'] = $filepath;
                    return $this->redirect(['tree']);
                }
            }
        }

        $uploads = new \DirectoryIterator(Yii::getAlias('@app/uploads'));

        return $this->render('index', [
            'model' => $model,
            'uploads' => $uploads,
        ]);
    }

    public function actionTree()
    {
        $model = new Tree();

        $session = Yii::$app->session;
        $filepath = $session['filepath'];

        return $this->render('tree', [
            'filepath' => $filepath,
            'model' => $model,
        ]);
    }

    public function actionExport() {
        $model = new Tree();
        $model->load(Yii::$app->request->post());

        return Yii::$app->response->sendContentAsFile(
            Json::encode(Json::decode($model->json), JSON_PRETTY_PRINT),
            'tree_export.json',
            [
                'mimeType' => \yii\web\Response::FORMAT_JSON,
            ]
        );
    }
}
