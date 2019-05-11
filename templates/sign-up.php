<form class="form container" action="" method="post" autocomplete="off" <?=$form_class; ?> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <?php
    $classname = $errors['email'] ? "form__item--invalid"  : "";
    $error_message = $errors['email'];
    $value = isset($_POST['email']) ? $_POST['email'] : "";
    ?>
    <div class="form__item <?=$classname; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value; ?>">
        <span class="form__error"><?=$error_message?></span>
    </div>
    <?php
     $classname = $errors['password'] ? "form__item--invalid"  : "";
     $error_message = $errors['password']; ?>
    <div class="form__item <?=$classname; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=$error_message; ?></span>
    </div>
     <?php
     $classname = $errors['name'] ? "form__item--invalid"  : "";
     $error_message = $errors['name'];
     $value = isset($_POST['name']) ? $_POST['name'] : "";?>
    <div class="form__item <?=$classname; ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=$value ?>">
        <span class="form__error"><?=$error_message; ?></span>
    </div>
    <?php
    $classname = $errors['message'] ? "form__item--invalid"  : "";
    $error_message = $errors['message']; ?>
    <div class="form__item <?=$classname; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"></textarea>
        <span class="form__error"><?=$error_message; ?></span>
    </div>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
