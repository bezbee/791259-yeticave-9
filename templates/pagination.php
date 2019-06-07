<ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a href="<?=$url;?>
<?= $cur_page === 1 ? $cur_page : $cur_page - 1; ?>">Назад</a></li>
    <?php
    foreach($pages as $page): ?>

    <li class="pagination-item <?php if ($page === $cur_page) : ?> pagination-item-active<?php endif; ?>"><a href="<?=$url;?><?=$page;?>"><?=$page;?></a></li>
    <?php endforeach ?>
    <li class="pagination-item pagination-item-next"><a href="<?=$url;?><?=$page;?>">Вперед</a></li>
</ul>
