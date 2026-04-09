<?php

$latestBlog = \common\models\Blog::find()->where(['status' => 1])->one();



/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

$session = Yii::$app->session;
$cart = $session->get('cart', []);
$cartCount = 0;
foreach ($cart as $qty) {
    $cartCount += $qty;
}

$wishlistCount = 0;
if (!Yii::$app->user->isGuest) {
    $wishlistCount = \common\models\Wishlist::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->count();
} else {
    $wishlistCount = count($session->get('wishlist', []));
}

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="eCommerce Store" name="keywords">
    <meta content="Professional eCommerce Store" name="description">
    <link href="<?= Yii::getAlias('@web/img/favicon.ico') ?>" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web/lib/slick/slick.css') ?>" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web/lib/slick/slick-theme.css') ?>" rel="stylesheet">
    <link href="<?= Yii::getAlias('@web/css/style.css') ?>" rel="stylesheet">

    <?php $this->head() ?>
</head>


<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <body>
        <!-- Top bar Start -->
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <i class="fa fa-envelope"></i>
                        estore@email.com
                    </div>
                    <div class="col-sm-6">
                        <i class="fa fa-phone-alt"></i>
                        +777-777-7777
                    </div>
                </div>
            </div>
        </div>
        <!-- Top bar End -->

        <!-- Nav Bar Start -->
        <div class="nav">
            <div class="container">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">MENU</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>



                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="/" class="nav-item nav-link active">Home</a>
                            <a href="<?= \yii\helpers\Url::to(['site/about']) ?>" class="nav-item nav-link">Products</a>
                            <a href="<?= \yii\helpers\Url::to(['site/card']) ?>" class="nav-item nav-link">Product Cart</a>
                            <a href="<?= \yii\helpers\Url::to(['site/checkout']) ?>" class="nav-item nav-link">Checkout</a>
                            <a href="<?= \yii\helpers\Url::to(['site/contact']) ?>" class="nav-item nav-link">Contact Us</a>
                            <a href="<?= $latestBlog ? \yii\helpers\Url::to(['site/promotions', 'id' => $latestBlog->id]) : '#' ?>" class="nav-item nav-link">
                                Blog
                            </a>
                        </div>


                        <div class="navbar-nav ml-auto">
                            <div class="nav-item dropdown">
                                <?php if (Yii::$app->user->isGuest): ?>
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">User Account</a>
                                    <div class="dropdown-menu">
                                        <a href="<?= \yii\helpers\Url::to(['site/login']) ?>" class="dropdown-item">Login</a>
                                        <a href="<?= \yii\helpers\Url::to(['site/signup']) ?>" class="dropdown-item">Register</a>
                                    </div>
                            </div>
                        <?php else: ?>
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">My Account</a>
                            <div class="dropdown-menu">
                                <a href="<?= \yii\helpers\Url::to(['site/profil']) ?>" class="dropdown-item">Profil</a>

                            </div>
                        <?php endif; ?>

                        </div>
                </nav>
            </div>
        </div>
        <!-- Nav Bar End -->
        <!-- Bottom Bar Start -->
        <div class="bottom-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="logo">
                            <a href="/">
                                <img src="/img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="search">
                            <input type="text" placeholder="Search">
                            <button><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="user">
                            <a href="<?= Url::to(['site/wishlist']) ?>" class="btn wishlist">
                                <i class="fa fa-heart text-danger"></i>
                                <span>(<?= $wishlistCount ?>)</span>
                            </a>

                            <a href="<?= Url::to(['site/card']) ?>" class="btn cart">
                                <i class="fa fa-shopping-cart text-primary"></i>
                                <span>(<?= $cartCount ?>)</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Bottom Bar End -->


        <main role="main" class="flex-shrink-0">
            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </main>
        <!-- Footer Start -->
        <div class="footer ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Get in Touch</h2>
                            <div class="contact-info">
                                <p><i class="fa fa-map-marker"></i>123 E Store, Los Angeles, USA</p>
                                <p><i class="fa fa-envelope"></i>email@example.com</p>
                                <p><i class="fa fa-phone"></i>+123-456-7890</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Follow Us</h2>
                            <div class="contact-info">
                                <div class="social">
                                    <a href=""><i class="fab fa-twitter"></i></a>
                                    <a href=""><i class="fab fa-facebook-f"></i></a>
                                    <a href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a href=""><i class="fab fa-instagram"></i></a>
                                    <a href=""><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Company Info</h2>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms & Condition</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Purchase Info</h2>
                            <ul>
                                <li><a href="#">Pyament Policy</a></li>
                                <li><a href="#">Shipping Policy</a></li>
                                <li><a href="#">Return Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row payment align-items-center">
                    <div class="col-md-6">
                        <div class="payment-method">
                            <h2>We Accept:</h2>
                            <img src="/img/payment-method.png" alt="Payment Method" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-security">
                            <h2>Secured By:</h2>
                            <img src="/img/godaddy.svg" alt="Payment Security" />
                            <img src="/img/norton.svg" alt="Payment Security" />
                            <img src="/img/ssl.svg" alt="Payment Security" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->



        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>

</html>

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
