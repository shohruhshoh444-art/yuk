<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Order;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

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
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($category_id = null)
    {
        $categories = \common\models\Category::find()->all();
        $query = \common\models\Product::find()->where(['status' => 1]);
        if ($category_id) {
            $query->andWhere(['category_id' => $category_id]);
        }
        $products = $query->orderBy(['id' => SORT_DESC])->all();
        $blogs = \common\models\Blog::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'categories' => $categories,
            'products' => $products,
            'blogs' => $blogs,
            'active_category' => $category_id
        ]);
    }




    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

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
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    public function actionView($id)
    {
        $product = \common\models\Product::findOne($id);
        if (!$product) {
            throw new \yii\web\NotFoundHttpException("Mahsulot topilmadi.");
        }

        return $this->render('view', [
            'product' => $product,
        ]);
    }

    public function actionRemoveCart($id)
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);
        return $this->redirect(['card']);
    }


    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout($category_id = null)
    {
        $about = new \stdClass();
        $about->id = 1;
        $categories = \common\models\Category::find()->all();
        $query = \common\models\Product::find();
        if ($category_id) {
            $query->andWhere(['category_id' => $category_id]);
        }

        $products = $query->all();

        return $this->render('about', [
            'about' => $about,
            'products' => $products,
            'categories' => $categories,
            'active_category' => $category_id,
        ]);
    }

    public function actionCard()
    {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }

        $cart = $session->get('cart', []);
        $products = [];
        $totalSum = 0;

        if (!empty($cart)) {
            foreach ($cart as $id => $qty) {
                if (strpos($id, 'blog_') === 0) {
                    $blogId = str_replace('blog_', '', $id);
                    $blog = \common\models\Blog::findOne($blogId);
                    if ($blog) {
                        $price = 0;
                        $total = $price * $qty;

                        $products[] = [
                            'model' => $blog,
                            'qty' => $qty,
                            'price' => $price,
                            'total' => $total
                        ];
                        $totalSum += $total;
                    }
                } else {
                    $product = \common\models\Product::findOne($id);
                    if ($product) {
                        $total = $product->price * $qty;

                        $products[] = [
                            'model' => $product,
                            'qty' => $qty,
                            'price' => $product->price,
                            'total' => $total
                        ];
                        $totalSum += $total;
                    }
                }
            }
        }

        return $this->render('card', [
            'products' => $products,
            'totalSum' => $totalSum
        ]);
    }



    public function actionCheckout()
    {
        // Agar mehmon bo'lsa, login sahifasiga yuboramiz (user_id kerakligi uchun)
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', "Buyurtma berish uchun avval tizimga kiring.");
            return $this->redirect(['site/login']);
        }

        $orderModel = new \common\models\Order();
        $cart = Yii::$app->session->get('cart', []);
        $products = [];
        $totalSum = 0;

        // Savatchani hisoblash
        if (!empty($cart)) {
            foreach ($cart as $id => $qty) {
                $model = \common\models\Product::findOne($id);
                if ($model) {
                    $products[] = [
                        'model' => $model,
                        'qty' => $qty,
                    ];
                    $totalSum += $model->price * $qty;
                }
            }
        } else {
            // Savat bo'sh bo'lsa, indexga qaytaramiz
            Yii::$app->session->setFlash('info', "Savatchangiz bo'sh.");
            return $this->redirect(['index']);
        }

        // Formadan ma'lumot kelsa
        if ($orderModel->load(Yii::$app->request->post())) {
            $orderModel->user_id = Yii::$app->user->id;
            $orderModel->total_price = (float)$totalSum;
            $orderModel->created_at = time();
            // updated_at bu yerda bo'lmasligi kerak, chunki bazada yo'q
            $orderModel->status = 1;

            if ($orderModel->save()) {
                Yii::$app->session->remove('cart');
                Yii::$app->session->setFlash('success', "Buyurtmangiz muvaffaqiyatli qabul qilindi!");
                return $this->redirect(['index']);
            } else {
                // Agar baribir saqlanmasa, xatolarni ko'ramiz
                Yii::$app->session->setFlash('error', "Xatolik: " . json_encode($orderModel->getErrors()));
            }
        }


        return $this->render('checkout', [
            'orderModel' => $orderModel,
            'products'   => $products,
            'totalSum'   => $totalSum,
        ]);
    }




    public function actionPlaceOrder()
    {
        $model = new \common\models\Order();
        $session = Yii::$app->session;

        if ($model->load(Yii::$app->request->post())) {
            $cart = $session->get('cart', []);
            if (empty($cart)) {
                Yii::$app->session->setFlash('error', "Savatchangiz bo'sh!");
                return $this->redirect(['site/card']);
            }
            $total = 0;
            foreach ($cart as $id => $qty) {
                $product = \common\models\Product::findOne($id);
                if ($product) {
                    $total += $product->price * $qty;
                }
            }
            $model->user_id = Yii::$app->user->id ?? null;
            $model->total_price = $total + 1;
            $model->status = 0;
            $model->created_at = time();

            if (empty($model->payment_method)) {
                $model->payment_method = 'yetqazilganda';
            }

            if ($model->save()) {
                $session->remove('cart');
                Yii::$app->session->setFlash('success', "Xaridingiz uchun rahmat! Buyurtmangiz muvaffaqiyatli qabul qilindi.");
                return $this->redirect(['site/index']);
            } else {
                $errors = json_encode($model->getErrors(), JSON_UNESCAPED_UNICODE);
                Yii::$app->session->setFlash('error', "Xatolik yuz berdi: " . $errors);
            }
        }

        return $this->redirect(['site/checkout']);
    }







    public function actionProfil()
    {
        if (Yii::$app->user->isGuest) return $this->goHome();

        $user = Yii::$app->user->identity;
        $passwordModel = new \frontend\models\ChangePasswordForm();
        $orders = \common\models\Order::find()->where(['user_id' => $user->id])->orderBy(['id' => SORT_DESC])->all();

        return $this->render('profil', [
            'model' => $user,
            'passwordModel' => $passwordModel,
            'orders' => $orders
        ]);
    }
    public function actionUpdateProfile()
    {
        $model = \common\models\User::findOne(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Ma'lumotlar muvaffaqiyatli yangilandi!");
            } else {
                $errorMsg = "";
                foreach ($model->getErrors() as $errors) {
                    foreach ($errors as $error) {
                        $errorMsg .= $error . " ";
                    }
                }
                Yii::$app->session->setFlash('error', "Xatolik: " . $errorMsg);
            }
        }
        return $this->redirect(['profil']);
    }

    public function actionChangePassword()
    {
        $user = Yii::$app->user->identity;
        $post = Yii::$app->request->post('User');

        if (!empty($post['new_password'])) {
            $user->setPassword($post['new_password']);
            $user->generateAuthKey();
            if ($user->save()) {
                Yii::$app->session->setFlash('success', "Parol muvaffaqiyatli o'zgartirildi.");
            }
        }
        return $this->redirect(['profil']);
    }



    public function actionAddToWishlist($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) {
            return ['success' => false, 'message' => 'Avval tizimga kiring!'];
        }

        $userId = Yii::$app->user->id;
        $exists = (new \yii\db\Query())
            ->from('wishlist')
            ->where(['user_id' => $userId, 'product_id' => $id])
            ->exists();

        if ($exists) {
            Yii::$app->db->createCommand()->delete('wishlist', ['user_id' => $userId, 'product_id' => $id])->execute();
            return ['success' => true, 'status' => 'removed'];
        } else {
            Yii::$app->db->createCommand()->insert('wishlist', [
                'user_id' => $userId,
                'product_id' => $id,
                'created_at' => date('Y-m-d H:i:s')
            ])->execute();
            return ['success' => true, 'status' => 'added'];
        }
    }

    public function actionAddFromBlog($category_id)
    {
        $product = \common\models\Product::find()
            ->where(['category_id' => $category_id, 'status' => 1])
            ->one();

        if ($product) {
            $session = Yii::$app->session;
            $cart = $session->get('cart', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]++;
            } else {
                $cart[$product->id] = 1;
            }

            $session->set('cart', $cart);
            Yii::$app->session->setFlash('success', "Aksiyadagi mahsulot savatchaga qo'shildi!");
        } else {
            Yii::$app->session->setFlash('error', "Ushbu kategoriya bo'yicha mahsulot topilmadi.");
        }

        return $this->redirect(['site/card']);
    }


    public function actionAddBlogToCart($id)
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart', []);
        $key = 'blog_' . $id;

        if (isset($cart[$key])) {
            $cart[$key]++;
        } else {
            $cart[$key] = 1;
        }

        $session->set('cart', $cart);
        return $this->redirect(['site/card']);
    }







    public function actionAddCart($id)
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart', []);
        $cart[$id] = ($cart[$id] ?? 0) + 1;
        $session->set('cart', $cart);
        return $this->redirect(['site/card']);
    }

    public function actionAddWishlist($id)
    {
        $session = Yii::$app->session;
        $wishlist = $session->get('wishlist', []);
        if (!isset($wishlist[$id])) {
            $wishlist[$id] = 1;
        }
        $session->set('wishlist', $wishlist);
        Yii::$app->session->setFlash('success', "Mahsulot sevimlilarga qo'shildi!");
        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionWishlist($id = null)
    {
        if ($id !== null) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (Yii::$app->user->isGuest) {
                return ['status' => 'error', 'message' => 'Avval tizimga kiring!'];
            }

            $userId = Yii::$app->user->id;
            $exists = \common\models\Wishlist::find()
                ->where(['user_id' => $userId, 'product_id' => $id])
                ->exists();

            if (!$exists) {
                $model = new \common\models\Wishlist();
                $model->user_id = $userId;
                $model->product_id = $id;
                $model->created_at = time();

                if ($model->save()) {
                    return ['status' => 'success', 'message' => 'Mahsulot saqlandi!'];
                }
            }
            return ['status' => 'info', 'message' => 'Bu mahsulot allaqachon mavjud.'];
        }

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $wishlistItems = \common\models\Wishlist::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->with('product')
            ->all();

        return $this->render('wishlist', [
            'wishlistItems' => $wishlistItems,
        ]);
    }



    public function actionUpdateCart($id, $qty)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $session = Yii::$app->session;
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id] = (int)$qty;
            $session->set('cart', $cart);
            return ['success' => true];
        }
        return ['success' => false];
    }





    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
    public function actionLang($lang)
    {
        Yii::$app->session->set('lang', $lang);
        return $this->goBack();
    }
}
