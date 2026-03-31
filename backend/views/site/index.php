<?php

use yii\helpers\Url;

$this->title = 'Dashboard';


$bugungiDaromad = \common\models\Order::find()->sum('total_price') ?? 0; 
$jamiTovarlar = \common\models\Product::find()->count();
$yangiBuyurtmalar = \common\models\Order::find()->where(['status' => '1'])->count();
$oxirgiBuyurtmalar = \common\models\Order::find()
    ->orderBy(['created_at' => SORT_DESC])
    ->limit(5)
    ->all();

?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="glass-card p-8 rounded-3xl relative overflow-hidden group hover:neon-shadow-indigo transition">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20"></div>
        <p class="text-slate-400 text-xs font-black uppercase tracking-widest mb-4">Bugungi Daromad</p>
        <div class="flex items-end gap-2">
            <h2 class="text-4xl font-black text-emerald-400 font-mono"><?= number_format($bugungiDaromad, 0, '.', ' ') ?></h2>
            <span class="text-emerald-600 font-bold mb-1 italic">UZS</span>
        </div>
        <div class="mt-4 flex items-center gap-2 text-xs text-emerald-500 font-bold">
            <i class="fas fa-arrow-trend-up"></i> <span>Bazadagi real qiymat</span>
        </div>
    </div>
    <div class="glass-card p-8 rounded-3xl relative overflow-hidden group hover:neon-shadow-indigo transition border-l-4 border-indigo-500">
        <p class="text-slate-400 text-xs font-black uppercase tracking-widest mb-4">Jami Mahsulotlar</p>
        <div class="flex items-end gap-2 text-white">
            <h2 class="text-5xl font-black"><?= $jamiTovarlar ?></h2>
            <span class="text-slate-500 font-bold mb-1 tracking-tighter italic text-sm">donada</span>
        </div>
    </div>
    <div class="glass-card p-8 rounded-3xl relative overflow-hidden group hover:neon-shadow-indigo transition border-l-4 border-amber-500">
        <p class="text-slate-400 text-xs font-black uppercase tracking-widest mb-4">Yangi Buyurtmalar</p>
        <div class="flex items-end gap-2 text-amber-400">
            <h2 class="text-5xl font-black"><?= $yangiBuyurtmalar ?></h2>
            <span class="text-amber-600 font-bold mb-1 italic text-sm font-mono tracking-tighter">ta</span>
        </div>
    </div>
</div>

<div class="mt-12 glass-card rounded-3xl overflow-hidden shadow-2xl">
    <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center">
        <h3 class="font-bold text-lg text-white">
            <i class="fas fa-history mr-2 text-indigo-500"></i> Oxirgi tranzaksiyalar
        </h3>
        <a href="<?= Url::to(['/site/order']) ?>" class="text-indigo-400 text-sm font-bold hover:text-white transition underline decoration-indigo-500/30">
            Hammasini ko'rish
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-800/30 text-slate-500 text-[10px] uppercase font-black tracking-widest">
                <tr>
                    <th class="p-6">ID</th>
                    <th class="p-6">Mijoz</th>
                    <th class="p-6">Sana</th>
                    <th class="p-6">Summa</th>
                    <th class="p-6">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-white/5">
                <?php if (!empty($oxirgiBuyurtmalar)): ?>
                    <?php foreach ($oxirgiBuyurtmalar as $order): ?>
                        <tr class="hover:bg-white/5 transition">
                            <td class="p-6 font-mono text-indigo-400">#<?= $order->id ?></td>
                            <td class="p-6 text-white font-bold">
                                <?= $order->customer_name ?? 'Mijoz #'.$order->id ?>
                            </td>
                            <td class="p-6 text-slate-500">
                                <?= date('d.m.Y H:i', $order->created_at) ?>
                            </td>
                            <td class="p-6 text-emerald-400 font-bold">
                                <?= number_format($order->total_price, 0, '.', ' ') ?> UZS
                            </td>
                            <td class="p-6">
                                <?php if ($order->status == 'yangi'): ?>
                                    <span class="px-3 py-1 bg-amber-500/20 text-amber-500 rounded-full text-[10px] font-black uppercase tracking-tighter">Yangi</span>
                                <?php elseif ($order->status == 'tolandi'): ?>
                                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-500 rounded-full text-[10px] font-black uppercase tracking-tighter">To'landi</span>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-slate-700 text-slate-400 rounded-full text-[10px] font-black uppercase tracking-tighter"><?= $order->status ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-10 text-center text-slate-500 italic">
                            Hozircha buyurtmalar mavjud emas...
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

