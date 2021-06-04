<main id="l-main">
    <div class="c-form js-sp-menu-target">
        <h2 class="c-form__title">退会ページ</h2>
        <div class="u-err-msg">
            <?php if(!empty($error)): ?>
                <?php foreach($error as $key=>$val): ?>
                    <li><?=$val;?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?=$loginform?>
        <p>*一度退会すると、これまで登録したデータを復元することはできません。</p>
    </div>
</main>