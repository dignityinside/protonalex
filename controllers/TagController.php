<?php

namespace app\controllers;

use Yii;

/**
 * Class TagController
 *
 * @package app\controllers
 *
 * @author Alexander Schilling
 */
class TagController extends \yii\web\Controller
{

    /**
     * @param null $q
     * @param null $id
     *
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSearch($q = null, $id = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['id' => '', 'text' => '']];

        if ($q !== null) {
            $data = \app\models\Tag::find()
                       ->select('name AS id, name AS text')
                       ->where('name LIKE :q', [':q' => '%' . addcslashes($q, '%_') . '%'])
                       ->limit(20)
                       ->asArray()
                       ->all();

            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => $this->findModel($id)->name];
        }

        return $out;
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return \app\models\Tag the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = \app\models\Tag::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
    }
}
