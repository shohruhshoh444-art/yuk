<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $blog common\models\Blog */
/* @var $products common\models\Product[] */
?>

<style>
    .view-blog-page {
        background: #fdfdfd;
        padding-bottom: 80px;
        font-family: 'Inter', sans-serif;
    }

    /* Banner qismi */
    .blog-hero {
        position: relative;
        height: 450px;
        background: #333;
        overflow: hidden;
        display: flex;
        align-items: center;
        color: white;
    }

    .blog-hero-img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.5;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        text-align: center;
    }

    .hero-title {
        font-size: 42px;
        font-weight: 800;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .blog-details {
        max-width: 900px;
        margin: -60px auto 50px;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
        position: relative;
        z-index: 3;
    }

    .blog-text {
        font-size: 17px;
        line-height: 1.8;
        color: #444;
    }

    /* Mahsulotlar gridi */
    .section-title {
        font-weight: 800;
        margin-bottom: 40px;
        text-align: center;
        color: #333;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }

    .p-card {
        background: white;
        border: 1px solid #eee;
        border-radius: 15px;
        padding: 20px;
        transition: 0.3s;
        display: flex;
        flex-direction: column;
    }

    .p-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .p-img {
        width: 100%;
        height: 200px;
        object-fit: contain;
        margin-bottom: 15px;
    }

    .p-title {
        font-weight: 600;
        height: 45px;
        overflow: hidden;
        margin-bottom: 10px;
        color: #333;
    }

    .p-price {
        font-size: 22px;
        font-weight: 700;
        color: #7000ff;
        margin-bottom: 15px;
    }
</style>

<div class="view-blog-page">
    <div class="blog-hero">
        <?php
        $images = explode(',', $blog->image);
        $img = !empty($images[0]) ? trim($images[0]) : 'no-image.png';
        ?>
        <img src="<?= Yii::getAlias('@web/') . $img ?>" class="blog-hero-img" onerror="this.src='<?= Yii::getAlias('@web/img/no-image.png') ?>'">
        <div class="container hero-content">
            <h1 class="hero-title"><?= Html::encode($blog->title) ?></h1>
            <p class="lead">Aksiya muddati: <?= Html::encode($blog->start_date) ?> — <?= Html::encode($blog->end_date) ?></p>
        </div>
    </div>

    <div class="container">
        <div class="blog-details">
            <div class="blog-text">
                <?= $blog->content
                ?>
            </div>
        </div>

        <div class="related-products">
            <h2 class="section-title">Aksiyadagi mahsulotlar</h2>

            <div class="product-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <?php
                        $pImgs = explode(',', $product->image);
                        $pImg = !empty($pImgs[0]) ? trim($pImgs[0]) : 'no-image.png';

                        $cart = Yii::$app->session->get('cart', []);
                        $isInCart = array_key_exists($product->id, $cart);
                        $isOut = ($product->stock <= 0);
                        ?>
                        <div class="p-card">
                            <img src="<?= Yii::getAlias('@web/') . $pImg ?>" class="p-img" onerror="this.src='<?= Yii::getAlias('@web/img/no-image.png') ?>'">
                            <div class="p-title"><?= Html::encode($product->title) ?></div>
                            <div class="p-price">$<?= number_format($product->price, 0) ?></div>

                            <?php
                            $cart = Yii::$app->session->get('cart', []);
                            $isInCart = array_key_exists($product->id, $cart);
                            $isOut = ($product->stock <= 0);
                            ?>

                            <button
                                class="btn-buy <?= ($isOut || $isInCart) ? '' : 'toggle-cart' ?>"
                                data-id="<?= $product->id ?>"
                                <?= ($isOut || $isInCart) ? 'disabled' : '' ?>
                                style="width: 100%; border: none; padding: 12px; border-radius: 12px; transition: 0.3s; color: white; font-weight: 600;
                                background: <?= $isOut ? '#bdc3c7' : ($isInCart ? '#28a745' : '#7000ff') ?>;
                                <?= ($isOut || $isInCart) ? 'cursor: not-allowed;' : 'cursor: pointer;' ?>">

                                <?php if ($isOut): ?>
                                    <i class="fa fa-times-circle"></i> Sotuvda yo'q
                                <?php elseif ($isInCart): ?>
                                    <i class="fa fa-check-circle"></i> Savatda
                                <?php else: ?>
                                    <i class="fa fa-shopping-cart"></i> Savatga qo'shish
                                <?php endif; ?>
                            </button>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center w-100 py-5">
                        <p class="text-muted">Ushbu aksiyaga tegishli mahsulotlar topilmadi.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$cartUrl = \yii\helpers\Url::to(['site/toggle-cart']);
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$js = <<<JS
$(document).on('click', '.img-thumb', function() {
    let newSrc = $(this).attr('src');
    
    $('#main-product-img').attr('src', newSrc);
    $('#modal-img-content').attr('src', newSrc);
    
    $('.thumb-item').removeClass('active border-primary').css('border-color', '#eee');
    $(this).closest('.thumb-item').addClass('active border-primary').css('border-color', '#7000ff');
});

$(document).on('click', '.toggle-cart', function(e) {
    e.preventDefault();
    let btn = $(this);
    let productId = btn.data('id');

    $.ajax({
        url: '{$cartUrl}',
        type: 'POST',
        data: {
            id: productId,
            '{$csrfParam}': '{$csrfToken}'
        },
        success: function(res) {
            if (res.status === 'added') {
                btn.html('<i class="fa fa-check"></i> Savatda')
                   .removeClass('btn-primary')
                   .addClass('btn-success disabled')
                   .css('background-color', '#28a745');
                
                if (res.cartCount !== undefined) {
                    $('.cart-count').text(res.cartCount);
                }
            } else if (res.status === 'removed') {
                btn.html('Savatga qo\'shish')
                   .removeClass('btn-success disabled')
                   .addClass('btn-primary')
                   .css('background-color', '#7000ff');
            }
        },
        error: function(xhr) {
            console.error('Xatolik:', xhr.responseText);
            alert('Savatga qo\'shishda xatolik yuz berdi.');
        }
    });
});
JS;
$this->registerJs($js);
?>