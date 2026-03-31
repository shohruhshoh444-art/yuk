<?php

namespace backend\controllers;

use common\models\Blog;
use common\models\Category;
use common\models\LoginForm;
use common\models\Order;
use common\models\Product;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'index',
                            'blog',
                            'logout',
                            'orders',
                            'order', 
                            'catagory',
                            'category',
                            'product',
                            'update-status'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->isGuest && Yii::$app->user->identity->role >= 20;
                        }
                    ],
                    [
                        'actions' => ['users', 'update-role', 'admin'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->isGuest && Yii::$app->user->identity->role == 30;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }









    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'catCount' => \common\models\Category::find()->count(),
            'prodCount' => \common\models\Product::find()->count(),
            'orderCount' => \common\models\Order::find()->count(),
            'userCount' => \common\models\User::find()->count(),
            'blogCount' => \common\models\Blog::find()->count(),
            'categories' => \common\models\Category::find()->orderBy(['id' => SORT_DESC])->all(),
            'orders' => \common\models\Order::find()->orderBy(['id' => SORT_DESC])->all(),
            'users' => \common\models\User::find()->all(),
            'products' => \common\models\Product::find()->all(),
            'newProd' => new \common\models\Product(),
            'newCat' => new \common\models\Category(),

        ]);
    }





    public function actionAddProduct()
    {
        $model = new Product();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->asJson(['success' => true]);
        }
        return $this->asJson(['success' => false]);
    }
    public function actionCatagory($id = null, $del = null)
    {
        if ($del) {
            $modelDel = \common\models\Category::findOne($del);
            if ($modelDel) {
                $modelDel->delete();
            }
            return $this->redirect(['catagory']);
        }
        $newCat = $id ? \common\models\Category::findOne($id) : new \common\models\Category();

        if (Yii::$app->request->isPost) {
            if ($newCat->load(Yii::$app->request->post()) && $newCat->save()) {
                Yii::$app->session->setFlash('success', "Muvaffaqiyatli saqlandi!");
                return $this->redirect(['catagory']);
            } else {
                $errors = json_encode($newCat->getErrors(), JSON_UNESCAPED_UNICODE);
                Yii::$app->session->setFlash('error', "Saqlanmadi! Xatolar: " . $errors);
            }
        }
        return $this->render('catagory', [
            'catCount' => \common\models\Category::find()->count(),
            'prodCount' => \common\models\Product::find()->count(),
            'orderCount' => \common\models\Order::find()->count(),
            'userCount' => \common\models\User::find()->count(),
            'categories' => \common\models\Category::find()->orderBy(['id' => SORT_DESC])->all(),
            'newCat' => $newCat,
        ]);
    }



    public function actionProduct($id = null, $del = null)
    {
        if ($del) {
            $modelDel = \common\models\Product::findOne($del);
            if ($modelDel) {
                if ($modelDel->image && file_exists(Yii::getAlias('@frontend/web/') . $modelDel->image)) {
                    unlink(Yii::getAlias('@frontend/web/') . $modelDel->image);
                }
                $modelDel->delete();
            }
            return $this->redirect(['product']);
        }

        $newProd = $id ? \common\models\Product::findOne($id) : new \common\models\Product();

        if ($newProd->load(Yii::$app->request->post())) {
            $newProd->imageFile = \yii\web\UploadedFile::getInstance($newProd, 'imageFile');

            if ($newProd->validate()) {
                if ($newProd->imageFile) {
                    $path = 'uploads/products/';
                    $fullPath = Yii::getAlias('@frontend/web/') . $path;

                    if (!is_dir($fullPath)) {
                        \yii\helpers\FileHelper::createDirectory($fullPath);
                    }

                    $fileName = time() . '_' . $newProd->imageFile->baseName . '.' . $newProd->imageFile->extension;

                    if ($newProd->imageFile->saveAs($fullPath . $fileName)) {
                        $newProd->image = $path . $fileName;
                    }
                }

                if ($newProd->save(false)) {
                    Yii::$app->session->setFlash('success', "Mahsulot muvaffaqiyatli saqlandi!");
                    return $this->redirect(['product']);
                }
            } else {
                Yii::$app->session->setFlash('error', "Xatolik: " . json_encode($newProd->getErrors(), JSON_UNESCAPED_UNICODE));
            }
        }

        return $this->render('product', [
            'products' => \common\models\Product::find()->orderBy(['id' => SORT_DESC])->all(),
            'categories' => \common\models\Category::find()->all(),
            'newProd' => $newProd,
            'catCount' => \common\models\Category::find()->count(),
            'prodCount' => \common\models\Product::find()->count(),
            'orderCount' => \common\models\Order::find()->count(),
            'userCount' => \common\models\User::find()->count(),
        ]);
    }


    public function actionOrder($del = null)
    {
        if ($del !== null) {
            $order = \common\models\Order::findOne($del);
            if ($order) {
                if ($order->delete()) {
                    Yii::$app->session->setFlash('success', "Buyurtma muvaffaqiyatli o'chirildi.");
                } else {
                    Yii::$app->session->setFlash('error', "Buyurtmani o'chirishda xatolik yuz berdi.");
                }
            }
            return $this->redirect(['order']);
        }

        $orders = \common\models\Order::find()->orderBy(['id' => SORT_DESC])->all();

        return $this->render('order', [
            'orders' => $orders,
            'catCount' => \common\models\Category::find()->count(),
            'prodCount' => \common\models\Product::find()->count(),
            'orderCount' => count($orders),
            'userCount' => \common\models\User::find()->count(),
        ]);
    }

    public function actionUpdateStatus($id, $status)
    {
        $model = \common\models\Order::findOne($id);
        if ($model) {
            $model->status = (int)$status; 

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', "Status o'zgardi!");
            } else {
                Yii::$app->session->setFlash('error', "Saqlashda xato yuz berdi.");
            }
        }
        return $this->redirect(['order']);
    }

    public function actionBlog($id = null, $del = null)
    {
        if ($del) {
            $modelDel = \common\models\Blog::findOne($del);
            if ($modelDel) $modelDel->delete();
            return $this->redirect(['blog']);
        }

        $newBlog = $id ? \common\models\Blog::findOne($id) : new \common\models\Blog();

        if ($newBlog->load(Yii::$app->request->post())) {
            $newBlog->imageFile = \yii\web\UploadedFile::getInstance($newBlog, 'imageFile');

            if ($newBlog->validate()) {

                if ($newBlog->imageFile) {
                    $dir = Yii::getAlias('@frontend/web/uploads/blogs/');
                    if (!is_dir($dir)) {
                        \yii\helpers\FileHelper::createDirectory($dir);
                    }

                    $fileName = time() . '.' . $newBlog->imageFile->extension;
                    if ($newBlog->imageFile->saveAs($dir . $fileName)) {
                        $newBlog->image = 'uploads/blogs/' . $fileName;
                    }
                }

                if ($newBlog->save(false)) {
                    Yii::$app->session->setFlash('success', "Aksiya muvaffaqiyatli saqlandi!");
                    return $this->redirect(['blog']);
                }
            }
        }

        return $this->render('blog', [
            'newBlog' => $newBlog,
            'blogs' => \common\models\Blog::find()->orderBy(['id' => SORT_DESC])->all(),
            'categories' => \common\models\Category::find()->all(),
            'catCount' => \common\models\Category::find()->count(),
            'prodCount' => \common\models\Product::find()->count(),
            'orderCount' => \common\models\Order::find()->count(),
            'userCount' => \common\models\User::find()->count(),
        ]);
    }



    public function actionAdmin()
    {
        if (Yii::$app->user->identity->role != 30) {
            throw new \yii\web\ForbiddenHttpException("Siz admin emassiz!");
        }

        $users = \common\models\User::find()->all();
        return $this->render('admin', ['users' => $users]);
    }


    public function actionUpdateRole($id, $role)
    {
        $user = \common\models\User::findOne($id);
        if ($user) {
            $user->role = (int)$role;
            if ($user->save(false)) {
                Yii::$app->session->setFlash('success', "Rol yangilandi!");
            }
        }
        return $this->redirect(['admin']);
    }










    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
