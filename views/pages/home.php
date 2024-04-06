<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Auth\AuthInterface $auth
 */
?>

<?php $view->component('start') ?>

<h1>Home Page</h1>

<p><a href="/register"><button>Regiser</button></a></p>
<p><a href="/login"><button>Log In</button></a></p>
<p><a href="/app"><button>Open App</button></a></p>
<?php if ($auth->isAdmin()) { ?>
    <p><a href="/admin"><button>Admin page</button></a></p>
<?php } ?>

<?php $view->component('end') ?>