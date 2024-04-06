<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 */
?>

<?php $view->component('start_basic') ?>


<h1>Log in Page</h1>


<form action="/login" method="post" class="form">

    <?php if ($session->has('attempt.error')) { ?>
        <ul class="form__errors">
            <?php foreach ($session->getFlash('attempt.error') as $error) { ?>
                <li class="form__errors__error">
                    <?= $error ?>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
    <div class="form__group">
        <label for="login" class="form__label">login</label>
        <input type="login" class="form__control" id="login" name="login" aria-describedby="loginHelp">
        <?php if ($session->has('login.errors')) { ?>
            <ul class="form__errors">
                <?php foreach ($session->getFlash('login.errors') as $error) { ?>
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
</form>


<?php $view->component('end') ?>