<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 */
?>

<?php $view->component('start') ?>


<h1>Register Page</h1>


<form action="/register" method="post" class="form">
    <div class="form__group">
        <label for="name" class="form__label">Name</label>
        <input type="text" class="form__control" id="name" name="name">
        <?php if ($session->has('name.errors')) { ?>
            <ul class="form__errors">
                <?php foreach ($session->getFlash('name.errors') as $error) { ?>
                    <li class="form__errors__error">
                        <?= $error ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
    <div class="form__group">
        <label for="login" class="form__label">Login</label>
        <input type="text" class="form__control" id="login" name="login">
        <?php if ($session->has('login.errors')) { ?>
            <ul class="form__errors">
                <?php foreach ($session->getFlash('login.errors') as $error) { ?>
                    <li class="form__errors__error">
                        <?= $error ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <div class="form__group">
            <label for="email" class="form__label">Email address</label>
            <input type="email" class="form__control" id="email" name="email" aria-describedby="emailHelp">
            <?php if ($session->has('email.errors')) { ?>
                <ul class="form__errors">
                    <?php foreach ($session->getFlash('email.errors') as $error) { ?>
                        <li class="form__errors__error">
                            <?= $error ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <div class="form__group">
            <label for="password" class="form__label">Password</label>
            <input type="password" class="form__control" id="password" name="password">
            <?php if ($session->has('password.errors')) { ?>
                <ul class="form__errors">
                    <?php foreach ($session->getFlash('password.errors') as $error) { ?>
                        <li class="form__errors__error">
                            <?= $error ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <button type="submit" class="form__button form__button--primary">Submit</button>


        <?php $view->component('end') ?>