<style>
    .cabinet-wrapper {
        display: flex;
        gap: 25px;
        margin-top: 30px;
        font-family: 'Poppins', sans-serif;
    }

    .sidebar-card {
        width: 300px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        height: fit-content;
    }

    .sidebar-header {
        padding: 30px 20px;
        text-align: center;
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        color: #fff;
    }

    .avatar-placeholder {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: bold;
        margin: 0 auto 15px;
        border: 3px solid #fff;
    }

    .sidebar-menu {
        padding: 15px 0;
    }

    .menu-item {
        width: 100%;
        border: none;
        background: none;
        padding: 15px 25px;
        text-align: left;
        font-size: 15px;
        color: #555;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
    }

    .menu-item:hover {
        background: #f8f9ff;
        color: #6e8efb;
    }

    .menu-item.active {
        background: #f0f3ff;
        color: #6e8efb;
        border-right: 4px solid #6e8efb;
        font-weight: 600;
    }

    .main-content-card {
        flex: 1;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        padding: 35px;
        min-height: 500px;
    }

    .tab-pane {
        display: none;
        animation: fadeIn 0.4s ease;
    }

    .tab-pane.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .custom-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        transition: 0.3s;
        margin-top: 8px;
    }

    .custom-input:focus {
        border-color: #6e8efb;
        outline: none;
        box-shadow: 0 0 0 3px rgba(110, 142, 251, 0.1);
    }

    .btn-save {
        background: #6e8efb;
        color: #fff;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-save:hover {
        background: #5a7be2;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(110, 142, 251, 0.3);
    }

    .order-item {
        border: 1px solid #f0f0f0;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 15px;
        transition: 0.3s;
    }

    .order-item:hover {
        border-color: #6e8efb;
        background: #fcfdff;
    }
</style>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Mening profilim';
?>

<div class="container">
    <div class="cabinet-wrapper">
        <div class="sidebar-card">
            <div class="sidebar-header">
                <div class="avatar-placeholder">
                    <?= strtoupper(substr(Yii::$app->user->identity->username, 0, 1)) ?>
                </div>
                <h5 class="mb-1"><?= Html::encode(Yii::$app->user->identity->username) ?></h5>
                <small style="opacity: 0.8;"><?= Html::encode(Yii::$app->user->identity->email) ?></small>
            </div>
            <div class="sidebar-menu">
                <button class="menu-item active" onclick="openCabinetTab(event, 'info')"><i class="fa fa-user-circle"></i> Profil ma'lumotlari</button>
                <button class="menu-item" onclick="openCabinetTab(event, 'orders')"><i class="fa fa-shopping-bag"></i> Buyurtmalarim</button>
                <button class="menu-item" onclick="openCabinetTab(event, 'favorites')"><i class="fa fa-heart"></i> Sevimlilarim</button>
                <button class="menu-item" onclick="openCabinetTab(event, 'password')"><i class="fa fa-key"></i> Xavfsizlik</button>

                <?= Html::beginForm(['/site/logout'], 'post') ?>
                <button type="submit" class="menu-item text-danger" style="border-top: 1px solid #f5f5f5; margin-top: 10px;">
                    <i class="fa fa-sign-out-alt"></i> Chiqish
                </button>
                <?= Html::endForm() ?>
            </div>
        </div>

        <div class="main-content-card">

            <div id="info" class="tab-pane active">
                <h3 class="mb-4">Profil sozlamalari</h3>
                <?php $form = ActiveForm::begin([
                    'action' => ['site/update-profile'],
                    'method' => 'post',
                ]); ?>

                <?= $form->field($model, 'username')->textInput(['class' => 'custom-input']) ?>
                <?= $form->field($model, 'email')->textInput(['class' => 'custom-input']) ?>

                <div class="mt-4">
                    <?= Html::submitButton('Saqlash', ['class' => 'btn-save']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>

            <div id="password" class="tab-pane">
                <h3 class="mb-4">Parolni yangilash</h3>
                <div style="max-width: 450px;">
                    <?php $form = ActiveForm::begin(['action' => ['site/change-password']]); ?>
                    <div class="form-group">
                        <label>Yangi parol</label>
                        <?= Html::passwordInput('User[new_password]', '', ['class' => 'custom-input', 'placeholder' => 'Yangi parolni kiriting']) ?>
                    </div>
                    <div class="mt-4">
                        <?= Html::submitButton('Parolni yangilash', ['class' => 'btn-save', 'style' => 'background: #333;']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>


            <div id="orders" class="tab-pane">
                <h3 class="mb-4">Xaridlar tarixi</h3>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="order-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-primary font-weight-bold">#<?= $order->id ?> Buyurtma</span><br>
                                <small class="text-muted"><?= date('d.m.Y H:i', $order->created_at) ?></small>
                            </div>
                            <div class="text-right">
                                <div class="badge badge-success px-3 py-2 mb-1"><?php echo $order->status === 'completed' ? 'Bajarildi' : 'Kutilmoqda'; ?></div><br>
                                <strong class="text-dark"><?= number_format($order->total_price, 0) ?>uzs</strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center py-5">Hozircha buyurtmalar mavjud emas.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<script>
    function openCabinetTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-pane");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
            tabcontent[i].classList.remove("active");
        }
        tablinks = document.getElementsByClassName("menu-item");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        document.getElementById(tabName).style.display = "block";
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>