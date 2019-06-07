<form class="form form--add-lot container form--invalid <?=$form_class; ?>" action="" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php
        $classname = $errors['lot-name']  ? "form__item--invalid" : "";
        $error_message = $errors['lot-name'];
        $value = isset($user_lot['lot-name']) ? $user_lot['lot-name'] : "";?>
        <div class="form__item <?=$classname;?>">
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=$value;?>">
            <span class="form__error"><?=$error_message; ?></span>
        </div>
        <?php
        $classname = $errors['category'] ? "form__item--invalid" : "";
        $error_message = $errors['category'];
        ?>
        <div class="form__item <?=$classname;?>">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="category">
                <option value="">Выберите категорию</option>
                <?php foreach ($categories as $key => $cat): ?>
                <option value="<?=$cat['id']; ?>"
                <?= $category === $cat['id'] ? "selected" : "";?>
                ><?=$cat['category']; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error"><?=$error_message?></span>
        </div>
    </div>
    <?php
    $classname = $errors['message'] ? "form__item--invalid" : "";
    $error_message = $errors['message'];
    $value = isset($user_lot['message']) ? $user_lot['message'] : "";
   ?>
    <div class="form__item form__item--wide <?=$classname;?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?=htmlspecialchars($value);?></textarea>
        <span class="form__error"><?=$error_message;?></span>
    </div>
    <?php
    $classname = $errors['lot-image'] ? "form__item--invalid" : "";
    $error_message = $errors['lot-image']; ?>
    <div class="form__item form__item--file <?=$classname;?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot-img" value="" name="lot-image">
            <label for="lot-img">
                Добавить
            </label>
            <span class="form__error"><?=$error_message;?></span>
        </div>
    </div>
    <div class="form__container-three">
        <?php
        $classname = $errors['lot-rate'] ? "form__item--invalid" : "";
        $error_message = $errors['lot-rate'];
        $value = isset($user_lot['lot-rate']) ? $user_lot['lot-rate'] : "";?>

        <div class="form__item form__item--small <?=$classname;?>">
            <label for="lot-rate">Начальная цена <sup>*</sup></label>
            <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?=$value;?>">
            <span class="form__error"><?=$error_message;?></span>
        </div>
        <?php
        $classname = $errors['lot-step'] ? "form__item--invalid" : "";
        $error_message = $errors['lot-step'];
        $value = isset($user_lot['lot-step']) ? $user_lot['lot-step'] : "";?>
        <div class="form__item form__item--small <?=$classname;?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?=$value;?>">
            <span class="form__error"><?=$error_message;?></span>
        </div>
        <?php
        $classname = $errors['lot-date'] ? "form__item--invalid" : "";
        $error_message = $errors['lot-date'];
        $value = isset($user_lot['lot-date']) ? $user_lot['lot-date'] : "";?>
        <div class="form__item <?=$classname;?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input  type="date" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=$value?>"> <!--class="form__input-date" id="lot-date" -->
            <span class="form__error"><?=$error_message;?></span>
        </div>
    </div>
    <span class="form__error form__error--bottom"><?= all_null_recursive($errors) ? '' : 'Пожалуйста, исправьте ошибки в форме.' ?></span>
    <button type="submit" class="button">Добавить лот</button>
</form>

