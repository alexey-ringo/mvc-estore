<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4 padding-right">
                
                <?php if (isset($errors) && is_array($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li> - <?=$error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                
                <?php endif; ?>
                <div class="signup-form">
                    <a href="/user/register"><h2>Регистрация нового пользователя</h2></a>
                    <h2>Вход в личный кабинет</h2>
                    <form action="#" method="post">
                        <input type="email" name="email" placeholder="E-mail" value="<?=$email; ?>"/>
                        <input type="password" name="password" placeholder="Пароль" value="<?=$password; ?>"/>
                        <input type="submit" name="submit" class="btn btn-default" value="Вход"/>
                    </form>
                    
                </div>
                
                <br>
                <br>
                
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>