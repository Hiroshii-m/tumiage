<section id="l-sidebar">
    <aside class="c-sidebar">
        <h2 class="c-sidebar__tit">メニュー</h2>
        <ul class="c-sidebar__body">
            <li class="c-sidebar__list">
                <a href="<?= Uri::create('member/registstack') ?>registstack.php" class="c-sidebar__text">今日の積み上げを記録</a>
            </li>
            <li class="c-sidebar__list">
                <a href="<?= Uri::create('member/updatepass') ?>updatepass.php" class="c-sidebar__text">パスワードを変更する</a>
            </li>
            <li class="c-sidebar__list">
                <a href="<?= Uri::create('member/withdraw') ?>withdraw.php" class="c-sidebar__text">退会する</a>
            </li>
        </ul>
    </aside>
</section><!-- /サイドバー -->