<main id="l-main">
    <div class="c-form js-sp-menu-target">
        <h2 class="c-form__title">パスワード変更</h2>
        <div class="u-err-msg">
            <?php if(!empty($error)): ?>
                <?php foreach($error as $key=>$val): ?>
                    <li><?=$val;?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?=$edituserform?>
    </div>
</main>