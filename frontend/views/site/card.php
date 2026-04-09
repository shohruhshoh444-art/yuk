<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
?>
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= \yii\helpers\Url::to(['site/about']) ?>">Products</a></li>
            <li class="breadcrumb-item active">Cart</li>
            <li class="breadcrumb-item"><a href="<?= \yii\helpers\Url::to(['site/checkout']) ?>">Checkout</a></li>
        </ul>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Cart Start -->
<div class="cart-page">
    <div class="container-fluid">
        <div class="row">
            <?php

            use yii\helpers\Url;

            /** @var array $products */
            ?>

            <div class="col-lg-8">
                <div class="cart-page-inner">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="img" style="display: flex; align-items: center; gap: 12px;">
                                                    <?php
                                                    $productModel = $item['model'];
                                                    $rawImage = $productModel->image;
                                                    $noImage = Yii::getAlias('@web/img/no-image.png');

                                                    $images = !empty($rawImage) ? explode(',', $rawImage) : [];
                                                    $firstImg = !empty($images) ? trim($images[0]) : '';

                                                    if ($firstImg) {
                                                        if (strpos($firstImg, 'http') === 0) {
                                                            $imagePath = $firstImg;
                                                        } else {
                                                            $imagePath = Yii::getAlias('@web/') . $firstImg;
                                                        }
                                                    } else {
                                                        $imagePath = $noImage;
                                                    }
                                                    ?>

                                                    <div style="width: 50px; height: 50px; overflow: hidden; border: 1px solid #eee; border-radius: 6px; flex-shrink: 0;">
                                                        <img src="<?= $imagePath ?>"
                                                            alt="<?= \yii\helpers\Html::encode($productModel->title) ?>"
                                                            style="width: 100%; height: 100%; object-fit: contain;"
                                                            onerror="this.src='<?= $noImage ?>'">
                                                    </div>

                                                    <span style="font-weight: 500; color: #333;">
                                                        <?= \yii\helpers\Html::encode($productModel->title) ?>
                                                    </span>
                                                </div>

                                            </td>
                                            <td>$<?= number_format($item['price'], 0) ?></td>
                                            <td>
                                                <div class="qty">
                                                    <!-- Minus tugmasi -->
                                                    <button class="btn-minus cart-update" data-id="<?= $item['model']->id ?>" data-action="minus">
                                                        <i class="fa fa-minus"></i>
                                                    </button>

                                                    <input type="text" value="<?= $item['qty'] ?>" class="qty-input" readonly>

                                                    <?php if ($item['qty'] < $item['model']->stock): ?>
                                                        <button class="btn-plus cart-update" data-id="<?= $item['model']->id ?>" data-action="plus">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm btn-light" style="cursor: not-allowed; opacity: 0.5;" title="Omborda boshqa qolmagan">
                                                            <i class="fa fa-ban"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="row-total" data-price="<?= $item['price'] ?>">
                                                $<?= number_format($item['total'], 0) ?>
                                            </td>
                                            <td>
                                                <a href="<?= \yii\helpers\Url::to(['site/remove-cart', 'id' => $item['model']->id]) ?>" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <h4>Savatchangiz bo'sh</h4>
                                            <a href="<?= \yii\helpers\Url::to(['site/index']) ?>" class="btn btn-primary">Xaridni davom ettirish</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="cart-page-inner">
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                        <div class="col-md-12">
                            <div class="cart-summary shadow-sm border p-3 bg-white">
                                <div class="cart-content">
                                    <h1>Cart Summary</h1>
                                    <p>Sub Total<span>$<?= number_format($totalSum, 0) ?></span></p>
                                    <p>Shipping Cost<span>$1</span></p>
                                    <hr>
                                    <h2>Grand Total<span>$<?= number_format($totalSum + 1, 0) ?></span></h2>
                                </div>
                                <div class="cart-btn d-flex justify-content-between mt-3">
                                    <button class="btn btn-outline-dark">Update Cart</button>
                                    <a href="<?= \yii\helpers\Url::to(['site/checkout']) ?>" class="btn btn-danger font-weight-bold">
                                        Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Cart End -->
<?php
$updateUrl = \yii\helpers\Url::to(['site/update-cart']);
$this->registerJs("
    $('.cart-update').on('click', function() {
        var btn = $(this);
        var id = btn.data('id');
        var action = btn.data('action');
        var row = btn.closest('tr');
        var input = row.find('.qty-input');
        var currentQty = parseInt(input.val());
        var price = parseFloat(row.find('.row-total').data('price'));

        // Miqdorni o'zgartirish
        if (action === 'plus') {
            currentQty++;
        } else if (action === 'minus' && currentQty > 1) {
            currentQty--;
        }

        // AJAX orqali sessiyani yangilash
        $.ajax({
            url: '{$updateUrl}',
            type: 'GET',
            data: {id: id, qty: currentQty},
            success: function(res) {
                if (res.success) {
                    input.val(currentQty);
                    // Qatordagi Totalni hisoblash
                    var newRowTotal = currentQty * price;
                    row.find('.row-total').text('$' + newRowTotal.toLocaleString());
                    
                    // O'ng tarafdagi umumiy hisobni (Summary) yangilash (agar kerak bo'lsa)
                    location.reload(); // Savatcha summasini to'liq yangilash uchun eng xavfsiz yo'l
                }
            }
        });
    });
");
?>