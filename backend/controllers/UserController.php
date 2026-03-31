<?php
namespace backend\controllers;

use Yii;
use common\models\User;
use yii\web\Controller;
use yii\filters\VerbFilter;

class UserController extends Controller
{
    public function actionIndex()
    {
        $users = User::find()->orderBy(['id' => SORT_DESC])->all();
        return $this->render('index', ['users' => $users]);
    }

    public function actionUpdateRole($id, $role)
    {
        $user = User::findOne($id);
        if ($user) {
            $user->role = (int)$role;
            if ($user->save(false)) {
                Yii::$app->session->setFlash('success', "{$user->username} ning roli muvaffaqiyatli o'zgartirildi.");
            }
        }
        return $this->redirect(['index']);
    }
}
