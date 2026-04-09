<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Sevimli mahsulotlaringiz';

$session = Yii::$app->session;
$cart = $session->get('cart', []);
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center"><i class="fa fa-heart text-danger"></i> Sevimli mahsulotlaringiz</h2>

    <div class="table-responsive shadow-sm" style="background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #eee;">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr class="text-secondary text-uppercase" style="font-size: 13px;">
                    <th>Mahsulot</th>
                    <th>Narxi</th>
                    <th class="text-center">Savatga qo'shish</th>
                    <th class="text-center">O'chirish</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($wishlistItems)): ?>
                    <?php foreach ($wishlistItems as $item): ?>
                        <?php if ($item->product): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php
                                        $imgRaw = $item->product->image;
                                        $noImage = Url::to('@web/img/no-image.png');
                                        $images = !empty($imgRaw) ? explode(',', $imgRaw) : [];
                                        $firstImg = !empty($images) ? trim($images[0]) : null;

                                        if ($firstImg) {
                                            $imagePath = (strpos($firstImg, 'http') === 0) ? $firstImg : Url::to('@web/' . $firstImg);
                                        } else {
                                            $imagePath = $noImage;
                                        }
                                        ?>

                                        <div style="width: 65px; height: 65px; overflow: hidden; border-radius: 10px; border: 1px solid #f0f0f0;" class="mr-3 shadow-sm d-flex align-items-center justify-content-center bg-white">
                                            <img src="<?= $imagePath ?>"
                                                alt="<?= Html::encode($item->product->title) ?>"
                                                style="width: 100%; height: 100%; object-fit: contain;"
                                                onerror="this.src='<?= $noImage ?>'">
                                        </div>

                                        <a href="<?= Url::to(['site/view', 'id' => $item->product->id]) ?>" class="font-weight-bold text-dark ml-2 text-decoration-none">
                                            <?= Html::encode($item->product->title) ?>
                                        </a>
                                    </div>

                                </td>
                                <td class="font-weight-bold text-danger">
                                    $<?= number_format($item->product->price, 0, '.', ',') ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($cart[$item->product->id])): ?>
                                        <button class="btn btn-sm btn-success px-3 shadow-sm disabled" style="border-radius: 20px;">
                                            <i class="fa fa-check"></i> Savatda
                                        </button>
                                    <?php else: ?>
                                        <a href="javascript:void(0)"
                                            class="btn btn-sm btn-danger px-3 shadow-sm add-to-cart-btn"
                                            data-id="<?= $item->product->id ?>"
                                            style="border-radius: 20px;">
                                            <i class="fa fa-shopping-cart"></i> Qo'shish
                                        </a>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-trash"></i>', ['site/remove-wishlist', 'id' => $item->id], [
                                        'class' => 'btn btn-sm btn-outline-danger shadow-sm',
                                        'style' => 'border-radius: 20px; padding: 5px 12px;',
                                        'data' => [
                                            'confirm' => 'Ushbu mahsulotni ro\'yxatdan o\'chirasizmi?',
                                            'method' => 'post',
                                        ],
                                    ]); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <i class="fa fa-heart-o mb-3 text-muted" style="font-size: 3.5rem; display: block;"></i>
                            <p class="text-muted font-italic">Hozircha sevimlilar ro'yxati bo'sh.</p>
                            <a href="<?= Url::to(['site/index']) ?>" class="btn btn-danger px-5 shadow" style="border-radius: 25px;">Xaridni boshlash</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$cartUrl = Url::to(['site/toggle-cart']);
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$js = <<<JS
$(document).on('click', '.add-to-cart-btn', function(e) {
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
                btn.removeClass('btn-danger').addClass('btn-success disabled')
                   .html('<i class="fa fa-check"></i> Savatda')
                   .css('pointer-events', 'none');
                
                if (res.cartCount !== undefined && $('.cart-count').length) {
                    $('.cart-count').text(res.cartCount);
                }
            }
        },
        error: function(xhr) {
            console.error('Xatolik yuz berdi:', xhr.responseText);
        }
    });
});
JS;
$this->registerJs($js);
?>