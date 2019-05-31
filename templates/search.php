<div class="container">
    <section class="lots">

        <?php
        if(!$lots): ?>
            <h2>«Ничего не найдено по вашему запросу»</h2>
       <?php else: ?>
            <h2>Результаты поиска по запросу «<span><?=htmlspecialchars($_GET['search']) ?? ''; ?></span>»</h2>'
        <?php endif;?>

        <ul class="lots__list">
            <?php
            foreach ($lots as $lot): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$lot['image']; ?>" width="350" height="260" alt="Сноуборд">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=htmlspecialchars($lot['category']); ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot['id'];?>"><?=htmlspecialchars($lot['title']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount"><?=htmlspecialchars($lot['bid_count']) ? 'Кол-во ставок: ' . $lot['bid_count'] : 'Стартовая цена'; ?></span>
                            <span class="lot__cost"><?=formatPrice(htmlspecialchars($lot['price'])); ?></span>
                        </div>
                        <div class="lot__timer timer <?php
                        if (showTime($lot['end_by']) <= "1:00") {
                            print("timer--finishing");
                        }
                        ?>">
                            <?=showTime($lot['end_by']); ?>
                        </div>
                    </div>
                </div>
            </li>
 <?php endforeach; ?>
        </ul>
    </section>
</div>
<?php if($pages_count > 1): ?>
<div class="container">
    <?=$pagination; ?>
</div>
<?php endif;?>
