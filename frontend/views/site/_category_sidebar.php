<div class="sidebar shadow-sm p-4 rounded" style="background: #1e1e1e; color: #ccc;">
    <h4 class="text-white border-bottom pb-2">SHOP</h4>
    <ul class="list-unstyled">
        <?php if ($active_cat): ?>
            <li class="mb-2">
                <a href="javascript:void(0)" data-id="<?= $active_cat->parent_id ?>" class="category-filter text-info">
                    <i class="fa fa-arrow-left"></i> Назад
                </a>
            </li>
        <?php endif; ?>

        <?php foreach ($categories as $cat): ?>
            <li class="mb-2">
                <a href="javascript:void(0)" data-id="<?= $cat->id ?>" class="category-filter text-white">
                    <i class="fa fa-folder-o text-warning"></i> <?= $cat->name_uz ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
