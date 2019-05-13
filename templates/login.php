<form class="form container <?=$form_class;?>" action="" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <?php
    $classname = $errors['email'] ? "form__item--invalid"  : "";
    $error_message = $errors['email'];
    $value = isset($_POST['email']) ? $_POST['email'] : "";
    ?>
    <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value;?>">
        <span class="form__error"><?=$error_message;?></span>
    </div>
    <?php
    $classname = $errors['password'] ? "form__item--invalid"  : "";
    $error_message = $errors['password']; ?>
    <div class="form__item form__item--last <?=$classname;?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=$error_message?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
