<?php
/**
 * @var \App\Kernel\View\ViewInterface $view
 * @var \App\Kernel\Session\SessionInterface $session
 * @var \App\Kernel\Auth\AuthInterface $auth
 */
?>

<?php $view->component('start') ?>


<?php if ($auth->isLoggedIn()) { ?>
    <div class="box">
        <header>
            <img src="" alt="">
            <h1>My personal list</h1>
        </header>
        <section>
            <div class="add">
                <input type="text" id="task_name">
                <select id="add_column_select">
                    <option value="Waiting">Waiting</option>
                    <option value="Postponed">Postponed</option>
                    <option value="In Progress">In Progress</option>
                </select>
                <button id="add_btn">Add</button>
            </div>
        </section>
        <section>
            <div class="options">
                <button id="toggle_sort_btn" class="disabled_btn">Show completed first</button>
                <button id="toggle_filter_btn" class="disabled_btn">Hide completed tasks</button>
            </div>
        </section>

        <section class="tasks_board">
            <div class="tasks_block Waiting">

            </div>
            <div class="tasks_block Postponed">

            </div>
            <div class="tasks_block InProgress">

            </div>
        </section>

        <footer>
            <div class="footer_links">
                <div class="uni links">
                    <p><a href="">LMS</a></p>
                    <p><a href="">Офф. Сайт</a></p>
                    <p><a href="">ЭИОС</a></p>
                </div>

                <div class="bia links">
                    <p><a href="">ВК</a></p>
                    <p><a href="">Telegram</a></p>
                    <p><a href="">GitHub</a></p>
                </div>
            </div>
            <div class="info">
                <p>Автор: Илья Бедрицкий 2252</p>
                <p>Все права защищены</p>
            </div>
        </footer>
    </div>
    <section class="edit_dialog hidden"></section>

    <script src="assets/js/app.js"></script>
<?php } ?>

<?php $view->component('end') ?>