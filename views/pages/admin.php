<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 */
?>

<?php $view->component('start') ?>

<h1>Admin Page</h1>

<?php foreach ($session->get('auth.allUsers') as $user) { ?>
    <?php /**
      * @var App\Kernel\Database\DataModels\UserModel $user
      *  */ ?>
    <?php dump($user); ?>
    <form action="/admin/deleteUser" method='post'>
        <button name="user" value="<?= $user->id ?>">Delete</button>
    </form>
    <form action="/admin/switchUserType" method='post'>
        <button name="user" value="<?= $user->id ?>">Switch Type</button>
    </form>
<?php } ?>


<?php $view->component('end') ?>