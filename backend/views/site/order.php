<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Buyurtmalar Ro\'yxati';

$statusLabels = [
    0 => ['label' => 'Yangi', 'class' => 'badge-warning'],
    1 => ['label' => 'Faol (Jarayonda)', 'class' => 'badge-info'],
    2 => ['label' => 'Yetkazildi', 'class' => 'badge-success'],
    3 => ['label' => 'Bekor qilindi', 'class' => 'badge-danger'],
];
?>

<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-shopping-basket"></i> Kelib tushgan buyurtmalar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th>ID</th>
                            <th>Mijoz va Tel</th>
                            <th>To'lov/Yetkazish</th>
                            <th>Summa</th>
                            <th>Status</th> 
                            <th>Vaqti</th>
                            <th>Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="text-center">#<?= $order->id ?></td>
                                <td>
                                    <strong><?= Html::encode($order->full_name) ?></strong><br>
                                    <span class="text-muted small"><i class="fa fa-phone"></i> <?= Html::encode($order->phone) ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary small"><?= Html::encode($order->payment_method) ?></span><br>
                                    <small class="text-primary"><?= Html::encode($order->delivery_type) ?></small>
                                </td>
                                <td>
                                    <strong class="text-success"><?= number_format($order->total_price, 0, '.', ' ') ?> so'm</strong>
                                </td>

                                <td class="text-center">
                                    <?php
                                    $statusList = [
                                        0 => 'Yangi',
                                        1 => 'Faol (Jarayonda)',
                                        2 => 'Yetkazildi',
                                        3 => 'Bekor qilindi'
                                    ];

                                    $bgClass = 'bg-warning'; 
                                    if ($order->status == 1) $bgClass = 'bg-info text-white';
                                    if ($order->status == 2) $bgClass = 'bg-success text-white';
                                    if ($order->status == 3) $bgClass = 'bg-danger text-white';
                                    ?>

                                    <select class="form-control form-control-sm <?= $bgClass ?>"
                                        onchange="location.href = '<?= \yii\helpers\Url::to(['site/update-status', 'id' => $order->id]) ?>&status=' + this.value;">
                                        <?php foreach ($statusList as $key => $label): ?>
                                            <option value="<?= $key ?>" <?= $order->status == $key ? 'selected' : '' ?>>
                                                <?= $label ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>


                                <td><small><?= date('d.m.Y H:i', $order->created_at) ?></small></td>
                                <td class="text-center">
                                    <?= Html::a('🗑', ['orders', 'del' => $order->id], [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'data' => [
                                            'confirm' => 'Ushbu buyurtmani o\'chirmoqchimisiz?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>