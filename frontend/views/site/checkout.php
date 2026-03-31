<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
?>
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= \yii\helpers\Url::to(['site/index']) ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= \yii\helpers\Url::to(['site/about']) ?>">Products</a></li>
            <li class="breadcrumb-item active">Checkout</li>
            <li class="breadcrumb-item"><a href="<?= \yii\helpers\Url::to(['site/contact']) ?>">Contact US</a></li>
        </ul>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Checkout Start -->
<div class="checkout">
    <div class="container-fluid">
        <div class="row">

            <?php

            use yii\widgets\ActiveForm;
            ?>

            <div class="row">
                <div class="col-lg-8">
                    <?php $form = ActiveForm::begin([
                        'id' => 'checkout-form',
                        'action' => ['site/place-order'], 
                        'method' => 'post',
                    ]); ?>

                    <div class="checkout-inner">
                        <div class="billing-address">
                            <h2>Billing Address</h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($orderModel, 'full_name')->textInput(['placeholder' => 'Ism-sharifingiz']) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($orderModel, 'phone')->textInput(['placeholder' => '+998...']) ?>
                                </div>
                                <div class="col-md-12">
                                    <?= $form->field($orderModel, 'address')->textarea(['placeholder' => 'Yetkazib berish manzili']) ?>
                                </div>
                                <?= $form->field($orderModel, 'delivery_type')->hiddenInput(['value' => 'Standard'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

                <div class="col-lg-4">
                    <div class="checkout-inner">
                        <div class="checkout-summary">
                            <h1>Cart Total</h1>
                            <?php foreach ($products as $item): ?>
                                <p><?= Html::encode($item['model']->name) ?> (x<?= $item['qty'] ?>)
                                    <span>$<?= number_format($item['model']->price * $item['qty'], 0) ?></span>
                                </p>
                            <?php endforeach; ?>
                            <p class="sub-total">Sub Total<span>$<?= number_format($totalSum, 0) ?></span></p>
                            <p class="ship-cost">Shipping Cost<span>$1</span></p>
                            <h2>Grand Total<span>$<?= number_format($totalSum + 1, 0) ?></span></h2>
                        </div>

                        <div class="checkout-payment">
                            <div class="payment-methods">
                                <h1>Payment Methods</h1>
                                <?= $form->field($orderModel, 'payment_method')->radioList([
                                    'Cash on Delivery' => 'Cash on Delivery',
                                    'Paypal' => 'Paypal',
                                    'Card' => 'Direct Bank Transfer'
                                ], [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        $check = $checked ? 'checked' : '';
                                        return "
                <div class='payment-method'>
                    <div class='custom-control custom-radio'>
                        <input type='radio' class='custom-control-input' id='payment-$index' name='$name' value='$value' $check>
                        <label class='custom-control-label' for='payment-$index'>$label</label>
                    </div>
                </div>";
                                    }
                                ])->label(false) ?>

                            </div>
                            <div class="checkout-btn">
                                <?= Html::submitButton('Place Order', ['class' => 'btn', 'form' => 'checkout-form']) ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- Checkout End -->