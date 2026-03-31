<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-full bg-[#0b1120]">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com"></script>
    <link href="https://cdnjs.cloudflare.com" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .glass-card { background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.05); }
        .neon-shadow-indigo { box-shadow: 0 0 20px rgba(0, 4, 255, 0.2); }
        .active-nav { background: linear-gradient(90deg, rgba(0, 4, 255, 0.15) 0%, transparent 100%); border-left: 4px solid #6366f1; color: white !important; }
    </style>
    <?php $this->head() ?>
</head>
<body class="h-full text-slate-300">
<?php $this->beginBody() ?>

<div class="flex h-screen overflow-hidden">
    <aside class="w-72 glass-card border-r border-slate-800 flex flex-col z-30">
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/50">
                <i class="fas fa-shopping-cart text-white text-xl"></i>
            </div>
            <span class="text-xl font-black text-white tracking-tighter uppercase">Market<span class="text-indigo-500"></span></span>
        </div>

        <nav class="flex-1 px-4 space-y-1">
            <a href="<?= Url::to(['/site/index']) ?>" class="flex items-center gap-4 px-4 py-4 rounded-xl hover:bg-white/5 transition <?= Yii::$app->controller->id == 'site' ? 'active-nav' : '' ?>">
                <i class="fas fa-chart-line text-lg"></i> <span class="font-bold">Dashboard</span>
            </a>
            <a href="<?= Url::to(['/site/catagory']) ?>" class="flex items-center gap-4 px-4 py-4 rounded-xl hover:bg-white/5 transition <?= Yii::$app->controller->id == 'category' ? 'active-nav' : '' ?>">
                <i class="fas fa-layer-group text-lg"></i> <span class="font-bold">Catagory</span>
            </a>
            <a href="<?= Url::to(['/site/product']) ?>" class="flex items-center gap-4 px-4 py-4 rounded-xl hover:bg-white/5 transition <?= Yii::$app->controller->id == 'product' ? 'active-nav' : '' ?>">
                <i class="fas fa-box text-lg"></i> <span class="font-bold">Products</span>
            </a>
            <a href="<?= Url::to(['/site/order']) ?>" class="flex items-center gap-4 px-4 py-4 rounded-xl hover:bg-white/5 transition <?= Yii::$app->controller->id == 'order' ? 'active-nav' : '' ?>">
                <i class="fas fa-truck text-lg"></i> <span class="font-bold">Orders</span>
            </a>
            <a href="<?= Url::to(['/site/blog']) ?>" class="flex items-center gap-4 px-4 py-4 rounded-xl hover:bg-white/5 transition <?= Yii::$app->controller->id == 'order' ? 'active-nav' : '' ?>">
                <i class="fas fa-truck text-lg"></i> <span class="font-bold">Blog</span>
            </a>
            <a href="<?= Url::to(['/site/admin']) ?>" class="flex items-center gap-4 px-4 py-4 rounded-xl hover:bg-white/5 transition <?= Yii::$app->controller->id == 'order' ? 'active-nav' : '' ?>">
                <i class="fas fa-truck text-lg"></i> <span class="font-bold">Users</span>
            </a>
        </nav>

        <div class="p-6 border-t border-white/5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full border-2 border-indigo-500 p-0.5">
                    <img src="https://ui-avatars.com" class="rounded-full">
                </div>
                <div class="text-xs">
                    <p class="text-white font-bold uppercase"><?= Yii::$app->user->identity->username ?? 'Admin' ?></p>
                    <p class="text-indigo-400">Onlayn</p>
                </div>
            </div>
            <?= Html::beginForm(['/site/logout'], 'post') ?>
                <button type="submit" class="w-full py-3 rounded-xl bg-red-500/10 text-red-500 text-sm font-bold hover:bg-red-500 hover:text-white transition">
                    <i class="fas fa-power-off mr-2"></i> Chiqish
                </button>
            <?= Html::endForm() ?>
        </div>
    </aside>
    <main class="flex-1 flex flex-col min-w-0">
        <header class="h-20 flex items-center justify-between px-10 border-b border-white/5 bg-[#0b1120]/50 backdrop-blur-md sticky top-0 z-20">
            <h2 class="text-xl font-bold text-white"><?= Html::encode($this->title) ?></h2>
            <div class="flex items-center gap-6">
                <div class="text-right">
                    <p class="text-sm font-bold text-white"><?= date('d F, Y') ?></p>
                    <p class="text-xs text-slate-500 uppercase tracking-widest"><?= date('H:i') ?></p>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-10">
            <div class="max-w-7xl mx-auto">
                <?= $content ?>
            </div>
        </div>
    </main>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
