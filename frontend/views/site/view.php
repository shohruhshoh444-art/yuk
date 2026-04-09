<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;
$images = !empty($model->image) ? explode(',', $model->image) : [];
$mainImg = !empty($images[0]) ? trim($images[0]) : 'img/no-image.png';
?>

<div class="product-view-page py-5 bg-light">
    <div class="container bg-white p-4 rounded shadow-sm">
        <div class="row">
            <div class="col-md-5">
                <div class="gallery-wrapper d-flex">
                    <div class="thumb-list mr-3 d-none d-md-block">
                        <?php foreach ($images as $img): $img = trim($img); ?>
                            <div class="thumb-item mb-2 border rounded overflow-hidden" style="width: 60px; height: 60px; cursor: pointer;">
                                <img src="<?= Url::to('@web/' . $img) ?>" class="w-100 h-100 img-thumb" style="object-fit: cover;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="main-image-container border rounded overflow-hidden position-relative flex-grow-1" style="height: 450px;">
                        <img id="main-product-img" src="<?= Url::to('@web/' . $mainImg) ?>"
                            class="w-100 h-100" style="object-fit: contain; cursor: zoom-in;"
                            data-toggle="modal" data-target="#imageModal">
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 small">
                        <li class="breadcrumb-item"><a href="<?= Url::home() ?>">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active"><?= Html::encode($model->category->name_uz ?? 'Kategoriya') ?></li>
                    </ol>
                </nav>

                <h1 class="h3 font-weight-bold"><?= Html::encode($model->title) ?></h1>

                <div class="stock-box">
                    <div class="stock-info">
                        <span class="stock-status">
                            <span class="dot-active"></span> Sotuvda mavjud
                        </span>
                        <span class="stock-number">
                            Faqat <b><?= $model->stock ?> ta</b> qoldi
                        </span>
                    </div>
                    <div class="stock-line">
                        <?php
                        $width = ($model->stock > 10) ? '100%' : ($model->stock * 10) . '%';
                        $color = ($model->stock <= 5) ? '#e74c3c' : '#2ecc71';
                        ?>
                        <div class="stock-bar" style="width: <?= $width ?>; background-color: <?= $color ?>;"></div>
                    </div>
                </div>

                <style>
                    .stock-box {
                        margin-bottom: 20px;
                        padding: 10px 0;
                    }

                    .stock-info {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 8px;
                        font-family: sans-serif;
                    }

                    .stock-status {
                        font-size: 14px;
                        color: #7f8c8d;
                        display: flex;
                        align-items: center;
                    }

                    .dot-active {
                        height: 8px;
                        width: 8px;
                        background-color: #2ecc71;
                        border-radius: 50%;
                        margin-right: 7px;
                    }

                    .stock-number {
                        font-size: 14px;
                        color: #2c3e50;
                    }

                    .stock-number b {
                        color: #e74c3c;
                    }

                    .stock-line {
                        height: 6px;
                        width: 100%;
                        background-color: #ecf0f1;
                        border-radius: 10px;
                        overflow: hidden;
                    }

                    .stock-bar {
                        height: 100%;
                        border-radius: 10px;
                        transition: width 0.3s ease;
                    }
                </style>


                <hr>

                <div class="price-box mb-4">
                    <span class="text-muted" style="text-decoration: line-through;"><?= number_format($model->price * 1.2, 0, '.', ' ') ?> UZS</span>
                    <h2 class="text-danger font-weight-bold"><?= number_format($model->price, 0, '.', ' ') ?> UZS</h2>
                    <div class="p-2 bg-light rounded mt-2 border-left border-primary" style="font-size: 14px;">
                        <i class="fa fa-credit-card text-primary mr-2"></i>
                        <b><?= number_format($model->price / 12, 0) ?> UZS</b> dan / 12 oyga muddatli to'lov
                    </div>
                </div>

                <div class="action-buttons row">
                    <div class="col-md-6 mb-2">
                        <button
                            class="btn btn-primary btn-block btn-lg <?= ($model->stock > 0) ? 'toggle-cart' : '' ?> font-weight-bold"
                            data-id="<?= $model->id ?>"
                            style="background: <?= ($model->stock > 0) ? '#7000ff' : '#6c757d' ?>; border: none; 
                            <?= ($model->stock <= 0) ? 'opacity: 0.6; cursor: not-allowed; pointer-events: none;' : '' ?>"
                            <?= ($model->stock <= 0) ? 'disabled' : '' ?>>
                            <?php if ($model->stock > 0): ?>
                                <i class="fa fa-shopping-cart mr-2"></i> Savatga qo'shish
                            <?php else: ?>
                                <i class="fa fa-times mr-2"></i> Sotuvda yo'q
                            <?php endif; ?>
                        </button>
                    </div>

                    <div class="col-md-6 mb-2">
                        <?php $isOut = ($model->stock <= 0); ?>

                        <a href="<?= $isOut ? 'javascript:void(0)' : Url::to(['site/buy-now', 'id' => $model->id]) ?>"
                            class="btn btn-outline-dark btn-block btn-lg font-weight-bold"
                            style="border: 2px solid #1f1f1f; color: #1f1f1f; border-radius: 8px; 
                         <?= $isOut ? 'opacity: 0.5; cursor: not-allowed; pointer-events: none;' : '' ?>"
                            <?= $isOut ? 'title="Mahsulot tugagan"' : '' ?>>

                            <i class="fa <?= $isOut ? 'fa-times' : 'fa-bolt' ?> mr-2"></i>
                            <?= $isOut ? 'Sotuvda yo\'q' : 'Bir bosishda xarid qilish' ?>
                        </a>
                    </div>


                </div>
            </div>
        </div>

        <?php if (!empty($relatedProducts)): ?>
            <div class="related-products mt-5">
                <h4 class="font-weight-bold mb-4 border-bottom pb-2">O'xshash mahsulotlar</h4>
                <div class="row">
                    <?php foreach ($relatedProducts as $rel): ?>
                        <div class="col-lg-3 col-md-4 col-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm transition-hover rounded-lg overflow-hidden">
                                <a href="<?= Url::to(['site/view', 'id' => $rel->id]) ?>" class="text-decoration-none text-dark">
                                    <div style="height: 200px; padding: 10px;">
                                        <img src="<?= Url::to('@web/' . explode(',', $rel->image)[0]) ?>" class="w-100 h-100" style="object-fit: contain;">
                                    </div>
                                    <div class="card-body p-2">
                                        <p class="small text-truncate mb-1"><?= Html::encode($rel->title) ?></p>
                                        <div class="font-weight-bold text-danger"><?= number_format($rel->price, 0, '.', ' ') ?> UZS</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-body p-0 text-center">
                <button type="button" class="close text-white position-absolute" data-dismiss="modal" style="right: 10px; top: 10px; z-index: 999; font-size: 40px;">&times;</button>
                <img id="modal-img-content" src="<?= Url::to('@web/' . $mainImg) ?>" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover:hover {
        transform: translateY(-5px);
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .thumb-item:hover,
    .thumb-item.active {
        border-color: #6b00f8 !important;
        border-width: 2px !important;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: ">";
    }
</style>

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