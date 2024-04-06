<?php
/**
 * @var \App\Kernel\Auth\AuthInterface $auth
 */

$user = $auth->currUser();
?>

<header>
    <a href="\home"><button>Home</button></a>
    <?php if ($auth->isLoggedIn()) { ?>
        <form action="\logout" method='post'><button>Logout</button></form>
        <h3>User:
            <?php echo $user->email; ?>
        </h3>
    <?php } else { ?>
        <form action="\login" method='get'><button>Log in</button></form>
    <?php } ?>
</header>