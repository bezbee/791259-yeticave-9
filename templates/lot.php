<section class="lot-item container">
    <h2><?=$lot['title']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lot['image']; ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['category']; ?></span></p>
            <p class="lot-item__description"><?=$lot['description']; ?></p>
        </div>
        <div class="lot-item__right">
            <?php
            if(isset($_SESSION['user']) and strtotime($lot['end_by']) > strtotime('now') and $is_current_user_created['user_id'] !== $_SESSION['user']['id']): ?>
            <div class="lot-item__state">
                <div class="lot-item__timer timer <?php
                if (showTime($lot['end_by']) <= "1:00") {
                    print("timer--finishing");
                };?>">
                    <?=showTime($lot['end_by']); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=$lot['price']; ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=$lot['bid_step']; ?></span>
                    </div>
                </div>

                <form class="lot-item__form <?=$form_class;?>" action="" method="post" autocomplete="off">
                    <?php
                    $classname = $errors['cost'] ? "form__item--invalid"  : "";
                    $error_message = $errors['cost']; ?>
                    <p class="lot-item__form-item form__item <?=$classname;?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="Минимум <?=$price_plus_bid;?>">
                        <span class="form__error"><?=$error_message;?></span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <?php endif; ?>
            <div class="history">
                <h3>История ставок (<span>10</span>)</h3>
                <?php
                foreach($bid_list as $bid): ?>
                <table class="history__list">
                    <tr class="history__item">
                        <td class="history__name"><?=$bid['name'];?></td>
                        <td class="history__price"><?=$bid['offer'] . ' p'; ?></td>
                        <td class="history__time"><?=calculate_bid_times($bid['added_on']);
                        ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
