<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

// FORMADAN BOSHLAYMIZ (Hammasini o'rab oladi)
$form = ActiveForm::begin(['id' => 'checkout-form']); ?>

<div class="row">
    <div class="col-lg-8">
        <div class="checkout-inner shadow-sm p-4" style="background: #fff; border-radius: 12px;">
            <h2 class="mb-4">Billing Address</h2>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($orderModel, 'full_name')->textInput([
                        'placeholder' => 'Ism-sharifingiz',
                        'value' => $orderModel->full_name ?: (!Yii::$app->user->isGuest ? Yii::$app->user->identity->username : ''),
                        'oninput' => "this.value = this.value.replace(/[0-9]/g, '');"
                    ])->label('Full Name') ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($orderModel, 'phone')->textInput([
                        'type' => 'tel',
                        'value' => '+998',
                        'maxlength' => 13,
                        'oninput' => "this.value = this.value.replace(/[^0-9+]/g, '');",
                    ])->label('Phone') ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($orderModel, 'address')->textarea(['rows' => 3, 'placeholder' => 'Yetkazib berish manzili'])->label('Address') ?>
                </div>
            </div>

            <div class="checkout-payment mt-4 pt-4 border-top">
                <h2 class="mb-3">To'lov usullari</h2>
                <?= $form->field($orderModel, 'payment_method')->radioList([
                    'Cash on Delivery' => 'Naqd pul (Yetkazilganda)',
                    'Paypal' => 'PayPal',
                    'Card' => 'Bank kartasi (Visa/Mastercard)'
                ], [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $check = $checked ? 'checked' : '';
                        return "
                        <div class='payment-method mb-2'>
                            <div class='custom-control custom-radio' style='padding: 10px; border: 1px solid #eee; border-radius: 8px;'>
                                <input type='radio' class='custom-control-input' id='payment-$index' name='$name' value='$value' $check required>
                                <label class='custom-control-label font-weight-bold' for='payment-$index' style='cursor: pointer; width: 100%;'>
                                    $label
                                </label>
                            </div>
                        </div>";
                    }
                ])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="checkout-summary shadow-sm p-4" style="background: #fff; border-radius: 12px;">
            <h1>Cart Total</h1>
            <?php
            $canPlaceOrder = true;
            foreach ($products as $item) {
                if ($item['model']->stock <= 0 || $item['qty'] > $item['model']->stock) {
                    $canPlaceOrder = false;
                    break;
                }
            }
            ?>



            <hr>
            <p class="sub-total d-flex justify-content-between">Sub Total<span>$<?= number_format($totalSum, 0) ?></span></p>
            <p class="ship-cost d-flex justify-content-between">Shipping Cost<span>$1</span></p>
            <h2 class="d-flex justify-content-between mt-3" style="color: #ff7466;">Grand Total<span>$<?= number_format($totalSum + 1, 0) ?></span></h2>

            <div class="checkout-btn mt-4">
                <?= Html::submitButton('Buyurtma berish', [
                    'class' => 'btn btn-lg btn-danger btn-block',
                    'style' => 'background: #890b00; border: none; border-radius: 12px; font-weight: bold; padding: 15px;'
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<style>
    .custom-control-input:checked~.custom-control-label::before {
        background-color: #ff7466;
        border-color: #ff7466;
    }
</style>