<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Buyurtmalar Boshqaruvi';

// Statuslar uchun ranglar va ikonkalarni belgilaymiz
$statusConfig = [
    0 => ['label' => 'Yangi', 'class' => 'status-new', 'icon' => '🔥'],
    1 => ['label' => 'Jarayonda', 'class' => 'status-active', 'icon' => '⚡'],
    2 => ['label' => 'Yetkazildi', 'class' => 'status-completed', 'icon' => '✅'],
    3 => ['label' => 'Bekor qilindi', 'class' => 'status-cancelled', 'icon' => '❌'],
];
?>

<style>
    /* Asosiy konteyner va karta */
    .orders-wrapper { background: #f4f7fa; min-height: 100vh; padding: 2rem 0; }
    .card-orders { border: none; border-radius: 20px; box-shadow: 0 15px 35px rgba(50,50,93,.1), 0 5px 15px rgba(0,0,0,.07); overflow: hidden; }
    
    /* Jadval stillari */
    .table thead th { 
        background: #f8f9fe; 
        color: #8898aa; 
        font-size: 12px; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        padding: 1.2rem;
        border: none;
    }
    .table td { vertical-align: middle !important; padding: 1.2rem; border-top: 1px solid #e9ecef; }
    
    /* Mijoz ma'lumotlari */
    .customer-info { display: flex; align-items: center; }
    .avatar-placeholder { 
        width: 40px; height: 40px; border-radius: 10px; 
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white; display: flex; align-items: center; justify-content: center;
        margin-right: 12px; font-weight: bold;
    }
    
    /* Status Select Custom */
    .status-select {
        border-radius: 30px;
        padding: 5px 15px;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        -webkit-appearance: none;
        text-align: center;
        width: 140px;
    }
    .status-new { background: #fff3cd; color: #856404; }
    .status-active { background: #e1f5fe; color: #01579b; }
    .status-completed { background: #d4edda; color: #155724; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
    
    /* Narx va to'lov */
    .price-badge { font-size: 16px; font-weight: 800; color: #2d3748; }
    .payment-badge { font-size: 10px; background: #edf2f7; color: #4a5568; padding: 3px 8px; border-radius: 5px; text-transform: uppercase; }

    /* Tugmalar */
    .btn-delete { 
        width: 38px; height: 38px; border-radius: 10px; 
        background: #fff; color: #f5365c; border: 1px solid #f5365c;
        display: inline-flex; align-items: center; justify-content: center; transition: 0.3s;
    }
    .btn-delete:hover { background: #f5365c; color: #fff; transform: scale(1.1); }
</style>

<div class="orders-wrapper">
    <div class="container-fluid">
        <div class="card card-orders">
            <div class="card-header bg-white py-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 font-weight-bold" style="color: #32325d;">📦 Buyurtmalar Oqimi</h4>
                    <p class="text-muted small mb-0">Hozirgi vaqtdagi barcha faol va yakunlangan buyurtmalar</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 mr-2"><i class="fa fa-download"></i> Excel</button>
                    <div class="badge badge-primary p-2 rounded-pill px-3">Jami: <?= count($orders) ?></div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th>Mijoz</th>
                            <th>To'lov & Yetkazish</th>
                            <th>Umumiy Summa</th>
                            <th>Holati</th> 
                            <th>Sana</th>
                            <th class="text-right">Boshqarish</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="font-weight-bold text-muted">#<?= $order->id ?></td>
                                <td>
                                    <div class="customer-info">
                                        <div class="avatar-placeholder">
                                            <?= mb_substr($order->full_name, 0, 1) ?>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark" style="font-size: 14px;"><?= Html::encode($order->full_name) ?></div>
                                            <small class="text-muted"><i class="fa fa-phone mr-1"></i> <?= Html::encode($order->phone) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="payment-badge"><?= Html::encode($order->payment_method) ?></span><br>
                                    <small class="text-info font-weight-bold"><?= Html::encode($order->delivery_type) ?></small>
                                </td>
                                <td>
                                    <div class="price-badge"><?= number_format($order->total_price, 0, '.', ' ') ?> <small>so'm</small></div>
                                </td>

                                <td>
                                    <?php
                                    $currentStatus = $statusConfig[$order->status] ?? $statusConfig[0];
                                    ?>
                                    <select class="status-select <?= $currentStatus['class'] ?>"
                                        onchange="if(confirm('Statusni o\'zgartirmoqchimisiz?')) location.href = '<?= Url::to(['site/update-status', 'id' => $order->id]) ?>&status=' + this.value;">
                                        <?php foreach ($statusConfig as $key => $cfg): ?>
                                            <option value="<?= $key ?>" <?= $order->status == $key ? 'selected' : '' ?>>
                                                <?= $cfg['icon'] ?> <?= $cfg['label'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td>
                                    <div class="text-dark small font-weight-bold"><?= date('d.m.Y', $order->created_at) ?></div>
                                    <div class="text-muted small"><?= date('H:i', $order->created_at) ?></div>
                                </td>

                                <td class="text-right pr-4">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <?= Html::a('<i class="fa fa-eye"></i>', ['view', 'id' => $order->id], ['class' => 'btn btn-sm btn-outline-info mr-2 rounded-pill', 'title' => 'Ko\'rish']) ?>
                                        
                                        <?= Html::a('🗑', ['orders', 'del' => $order->id], [
                                            'class' => 'btn-delete',
                                            'data' => [
                                                'confirm' => 'Diqqat! Buyurtmani o\'chirish qaytarilmas jarayon. Rozimisiz?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-0 py-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm justify-content-center mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Oldingi</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">Keyingi</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
