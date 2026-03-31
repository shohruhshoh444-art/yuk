<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Foydalanuvchilar boshqaruvi';

// Rollar xaritasi
$roleLabels = [
    10 => ['label' => 'User', 'class' => 'bg-primary'],
    20 => ['label' => 'Moderator', 'class' => 'bg-info'],
    30 => ['label' => 'Admin', 'class' => 'bg-danger'],
];
?>

<div class="user-index container-fluid py-4">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-dark py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-white"><i class="fas fa-users-cog mr-2"></i> Foydalanuvchilar ro'yxati</h5>
            <span class="badge badge-light px-3"><?= count($users) ?> ta a'zo</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Foydalanuvchi</th>
                            <th>Email</th>
                            <th class="text-center">Hozirgi rol</th>
                            <th class="text-center">Rol tayinlash</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="text-center text-muted">#<?= $user->id ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle mr-2"><?= strtoupper(substr($user->username, 0, 1)) ?></div>
                                        <strong><?= Html::encode($user->username) ?></strong>
                                    </div>
                                </td>
                                <td><?= Html::encode($user->email) ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $roleLabels[$user->role]['class'] ?? 'bg-secondary' ?> text-white px-3 py-2">
                                        <?= $roleLabels[$user->role]['label'] ?? 'Noma\'lum' ?>
                                    </span>
                                </td>
                                <td class="text-center" style="width: 200px;">
                                    <select class="custom-select custom-select-sm role-selector"
                                        onchange="location.href = '<?= \yii\helpers\Url::to(['site/update-role', 'id' => $user->id]) ?>&role=' + this.value;">
                                        <option value="">O'zgartirish...</option>
                                        <?php foreach ($roleLabels as $val => $info): ?>
                                            <option value="<?= $val ?>" <?= $user->role == $val ? 'selected' : '' ?>><?= $info['label'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                           

                                <!-- 2. MANA SHU YERGA QO'YASIZ (Status ustuni) -->
                                <td class="text-center">
                                    <a href="<?= \yii\helpers\Url::to(['site/update-status', 'id' => $user->id, 'status' => ($user->status == 10 ? 9 : 10)]) ?>"
                                        style="text-decoration: none; color: inherit;"
                                        onclick="return confirm('Foydalanuvchi holatini o\'zgartirmoqchimisiz?')">

                                        <span class="dot <?= $user->status == 10 ? 'bg-success' : 'bg-danger' ?>"></span>
                                        <?= $user->status == 10 ? 'Faol' : 'Bloklangan' ?>

                                    </a>
                                </td>

                                <td class="text-center">
                                    <span class="dot <?= $user->status == 10 ? 'bg-success' : 'bg-danger' ?>"></span>
                                    <?= $user->status == 10 ? 'Faol' : 'Bloklangan' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 35px;
        height: 35px;
        background: #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #4a5568;
    }

    .dot {
        height: 10px;
        width: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
    }

    .table td {
        vertical-align: middle;
    }

    .role-selector {
        border-radius: 20px;
        border: 1px solid #cbd5e0;
    }

    .role-selector:focus {
        border-color: #a777e3;
        box-shadow: 0 0 0 0.2rem rgba(167, 119, 227, 0.25);
    }
</style>