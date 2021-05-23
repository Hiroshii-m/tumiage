<?php
$sucMsg = Session::get_flash('sucMsg');
if(!empty($sucMsg)):
?>
<div class="p-flash js-show-msg u-bgColor-success">
    <?=$sucMsg?>
</div>
<?php
endif;
$errMsg = Session::get_flash('errMsg');
if(!empty($errMsg)):
?>
<div class="p-flash js-show-msg u-bgColor-error">
    <?=$errMsg?>
</div>
<?php endif; ?>
<header id="l-header" class="u-bgColor">
    <div class="c-header u-flex-between">
        <a class="c-header__logo u-flex">
            <h3>記録アップ!</h3>
        </a>
        <nav class="c-header__nav js-header-nav">
            <ul class="c-header__list u-flex js-header-list">
                <?php if(!Auth::check()){ ?>
                <li class="c-header__item">
                    <a href="" class="c-header__text">ログイン</a>
                </li>
                <li class="c-header__item">
                    <a href="" class="c-header__text">ユーザー登録</a>
                </li>
                <?php }else{ ?>
                <li class="c-header__item">
                    <a href="" class="c-header__text">マイページ</a>
                </li>
                <li class="c-header__item">
                    <a href="" class="c-header__text">ログアウト</a>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>