<section class="lots">
    <div class="lots__header">
        <?php
        if(empty($lots)):?>
            <h2>Открытыx лотов в категории "<?=$dict[$cat]; ?>" нет</h2>
        <?php elseif($cat):  ?>
            <h2>Все лоты в категории "<?=$dict[$cat]; ?>"</h2>
        <?php else: ?>
            <h2>Открытие лоты</h2>
        <?php endif; ?>
    </div>
     <ul class="lots__list">
        <?php foreach ($lots as $key => $item): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$item['image']; ?>" width="350" height="260" alt="<?=htmlspecialchars($item['title']); ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=htmlspecialchars($item['category']); ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$item['id']; ?>"><?=htmlspecialchars($item['title']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount"><?=$item['bid_count'] ? 'Кол-во ставок: ' . $item['bid_count'] : 'Стартовая цена'; ?></span>
                            <span class="lot__cost"><?=formatPrice(htmlspecialchars($item['price'])); ?></span>
                        </div>
                        <div class="lot__timer timer <?php
                        if (showTime($item['end_by']) <= "1:00") {
                            print("timer--finishing");
                        }
                        ?>">
                            <?= showTime($item['end_by']); ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php if($pages_count > 1) {
 echo $pagination;
};
?>
