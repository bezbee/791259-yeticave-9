<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php
        foreach($list_of_user_bids as $bid): ?>
        <tr class="rates__item">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?=$bid['image'];?>" width="54" height="40" alt="Сноуборд">
                </div>
                <h3 class="rates__title"><a href="lot.php?id=<?=$bid['lot']; ?>"><?=$bid['title'];?></a></h3>
            </td>
            <td class="rates__category">
                <?=$bid['category'];?>
            </td>
            <td class="rates__timer">
                <div class="timer <?php
                if(strtotime($bid['end_by']) <= strtotime('now') )  {
                    echo 'timer--end';
                } else if (strtotime($bid['end_by']) < 3600) {
                    echo 'timer--finishing';
                } else {
                    echo '';
                }
                ?>">
                    <?php
                if(strtotime($bid['end_by']) <= strtotime('now') )  {
                    echo 'Торги окончены';
                } else {
                    echo showTimeAddSec($bid['end_by']);
                }
                  ?>
                </div>
            </td>
            <td class="rates__price">
                <?=$bid['offer'];?>
            </td>
            <td class="rates__time">
                <?=calculate_bid_times($bid['added_on']);?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>
