<?php

namespace frontend\controllers;

use common\models\Category;
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
use common\models\Product;
use common\models\Wishlist;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
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
                    'toggle-wishlist' => ['POST'],
                    'toggle-cart' => ['POST'],
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
        $query = Product::find()->where(['status' => 1]);
        $active_cat = null;

        if ($category_id) {
            $active_cat = Category::findOne($category_id);
            if ($active_cat) {
                $ids = [$category_id];
                foreach ($active_cat->childs as $child) {
                    $ids[] = $child->id;
                }
                $query->andWhere(['category_id' => $ids]);

                if (!empty($active_cat->childs)) {
                    $displayCategories = $active_cat->childs;
                } else {
                    $displayCategories = Category::find()->where(['parent_id' => $active_cat->parent_id])->all();
                }
            }
        } else {
            $displayCategories = Category::find()->where(['parent_id' => null])->all();
        }

        $products = $query->all();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'productsHtml' => $this->renderPartial('_product_list', ['products' => $products]),
                'categoriesHtml' => $this->renderPartial('_category_sidebar', [
                    'categories' => $displayCategories,
                    'active_cat' => $active_cat
                ]),
            ];
        }

        return $this->render('index', [
            'products' => $products,
            'categories' => $displayCategories,
            'active_category' => $category_id,
            'active_cat_model' => $active_cat,
            'blogs' => \common\models\Blog::find()->where(['status' => 1])->all(),
        ]);
    }





    public function actionAjaxFilter()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $catId = Yii::$app->request->post('id');

        $query = \common\models\Product::find()->where(['status' => 1]);
        if ($catId) $query->andWhere(['category_id' => $catId]);
        $products = $query->all();

        $parentId = null;
        $isRoot = true;
        if ($catId) {
            $currentCat = \common\models\Category::findOne($catId);
            if ($currentCat) {
                $categories = !empty($currentCat->childs) ? $currentCat->childs : \common\models\Category::find()->where(['parent_id' => $currentCat->parent_id])->all();
                $parentId = $currentCat->parent_id;
                $isRoot = false;
            }
        } else {
            $categories = \common\models\Category::find()->where(['parent_id' => null])->all();
        }

        return [
            'products' => $this->renderPartial('_product_list', ['products' => $products]),
            'categories' => $this->renderPartial('_category_list', ['categories' => $categories]),
            'parent_id' => $parentId,
            'is_root' => $isRoot
        ];
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
        $model = \common\models\Product::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException("Mahsulot topilmadi.");
        }

        $relatedProducts = \common\models\Product::find()
            ->where(['category_id' => $model->category_id, 'status' => 1])
            ->andWhere(['!=', 'id', $id]) // joriy mahsulot chiqmasligi uchun
            ->limit(4)
            ->all();

        return $this->render('view', [
            'model' => $model,
            'relatedProducts' => $relatedProducts,
        ]);
    }
    public function actionViewBlog($id)
    {
        $blog = \common\models\Blog::findOne($id);

        if (!$blog) {
            throw new \yii\web\NotFoundHttpException("Aksiya topilmadi.");
        }

        $products = \common\models\Product::find()
            ->where(['category_id' => $blog->category_id, 'status' => 1])
            ->limit(8)
            ->all();

        return $this->render('viewblog', [
            'blog' => $blog,
            'products' => $products,
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
        $query = \common\models\Product::find()->where(['status' => 1]);
        $active_cat = null;

        if ($category_id) {
            $active_cat = \common\models\Category::findOne($category_id);
            if ($active_cat) {
                $query->andWhere(['category_id' => $category_id]);
                $categories = !empty($active_cat->childs) ? $active_cat->childs : \common\models\Category::find()->where(['parent_id' => null])->all();
            } else {
                $categories = \common\models\Category::find()->where(['parent_id' => null])->all();
            }
        } else {
            $categories = \common\models\Category::find()->where(['parent_id' => null])->all();
        }

        $count = $query->count(); 
        $pagination = new \yii\data\Pagination([
            'totalCount' => $count,
            'pageSize' => 4, 
        ]);

        $products = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        // ------------------------

        return $this->render('about', [
            'products' => $products,
            'categories' => $categories,
            'active_cat' => $active_cat,
            'pagination' => $pagination, 
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
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', "Buyurtma berish uchun avval tizimga kiring.");
            return $this->redirect(['site/login']);
        }

        $orderModel = new \common\models\Order();
        $cart = Yii::$app->session->get('cart', []);
        $products = [];
        $totalSum = 0;
        if (!empty($cart)) {
            foreach ($cart as $id => $qty) {
                $model = \common\models\Product::findOne($id);
                if ($model) {
                    if ($model->stock <= 0) {
                        continue;
                    }

                    $products[] = [
                        'model' => $model,
                        'qty' => $qty,
                    ];
                    $totalSum += $model->price * $qty;
                }
            }
        }

        if (empty($products)) {
            Yii::$app->session->setFlash('error', "Savatchangiz bo'sh yoki mahsulotlar tugab qolgan.");
            return $this->redirect(['site/card']);
        }

        if ($orderModel->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($products as $item) {
                    $freshProduct = \common\models\Product::findOne($item['model']->id);

                    if (!$freshProduct || $freshProduct->stock <= 0) {
                        throw new \Exception("Kechirasiz, '" . $freshProduct->title . "' hozirgina tugab qoldi.");
                    }

                    if ($item['qty'] > $freshProduct->stock) {
                        throw new \Exception("'" . $freshProduct->title . "' dan omborda yetarli emas (Mavjud: " . $freshProduct->stock . " ta).");
                    }
                }

                $orderModel->user_id = Yii::$app->user->id;
                $orderModel->total_price = (float)$totalSum;
                $orderModel->created_at = time();
                $orderModel->status = 1;

                if ($orderModel->save()) {
                    foreach ($products as $item) {
                        $product = \common\models\Product::findOne($item['model']->id);
                        $product->stock -= $item['qty'];
                        if (!$product->save(false)) {
                            throw new \Exception("Omborni yangilashda xatolik yuz berdi.");
                        }
                    }

                    $transaction->commit();
                    Yii::$app->session->remove('cart');
                    Yii::$app->session->setFlash('success', "Buyurtmangiz muvaffaqiyatli qabul qilindi!");
                    return $this->redirect(['index']);
                } else {
                    throw new \Exception("Buyurtmani saqlab bo'lmadi.");
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->refresh();
            }
        }

        return $this->render('checkout', [
            'orderModel' => $orderModel,
            'products'   => $products,
            'totalSum'   => $totalSum,
        ]);
    }



    public function actionPromotions()
    {
        $promotions = \common\models\Blog::find()
            ->where(['status' => 1])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('promotions', [
            'promotions' => $promotions,
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

    public function actionWishlist($id = null)
    {
        if (Yii::$app->request->isAjax && $id !== null) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (Yii::$app->user->isGuest) {
                return ['status' => 'error', 'message' => 'Avval tizimga kiring!'];
            }

            $userId = Yii::$app->user->id;
            $model = \common\models\Wishlist::findOne(['user_id' => $userId, 'product_id' => $id]);

            if ($model) {
                $model->delete();
                return ['status' => 'removed'];
            } else {
                $newWish = new \common\models\Wishlist();
                $newWish->user_id = $userId;
                $newWish->product_id = $id;
                $newWish->created_at = time();
                if ($newWish->save()) {
                    return ['status' => 'added'];
                }
            }
        }

        $wishlistItems = \common\models\Wishlist::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->with('product')->all();

        return $this->render('wishlist', ['wishlistItems' => $wishlistItems]);
    }
    public function actionBuyNow($id)
    {
        $session = Yii::$app->session;
        $cart = $session->get('cart', []);

        $cart[$id] = 1;

        $session->set('cart', $cart);

        return $this->redirect(['site/checkout']);
    }


    public function actionToggleCart()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $session = Yii::$app->session;
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $status = 'removed';
        } else {
            $cart[$id] = 1;
            $status = 'added';
        }

        $session->set('cart', $cart);

        return [
            'status' => $status,
            'cartCount' => count($cart),
        ];
    }



    public function actionToggleWishlist($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) {
            return ['status' => 'error', 'message' => 'Avval tizimga kiring!'];
        }

        $userId = Yii::$app->user->id;
        $model = \common\models\Wishlist::findOne(['user_id' => $userId, 'product_id' => $id]);

        if ($model) {
            $model->delete();
            return ['status' => 'removed', 'message' => "O'chirildi"];
        } else {
            $newWish = new \common\models\Wishlist();
            $newWish->user_id = $userId;
            $newWish->product_id = $id;
            $newWish->created_at = time();
            if ($newWish->save()) {
                return ['status' => 'added', 'message' => 'Saqlandi!'];
            }
        }

        return ['status' => 'error', 'message' => 'Xatolik yuz berdi'];
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        $cartItem = Cart::where('product_id', $productId)->where('user_id', auth()->id())->first();

        // 1. Bazada mahsulot bormi?
        if ($product->stock <= 0) {
            return "Kechirasiz, mahsulot tugagan.";
        }

        // 2. Agar savatda allaqachon bo'lsa va stock cheklangan bo'lsa
        if ($cartItem && $product->stock <= 1) {
            return "Ushbu mahsulotdan faqat 1 ta sotib olish mumkin.";
        }

        // Agar hammasi joyida bo'lsa, savatga qo'shish yoki sonini oshirish
        // ... savatga qo'shish kodi ...
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
