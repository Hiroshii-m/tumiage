<main id="l-main">
    <div class="c-form js-sp-menu-target">
        <h2 class="c-form__title">積み上げを記録</h2>
        <div class="u-err-msg">
            <?php if(!empty($error)): ?>
                <?php foreach($error as $key=>$val): ?>
                    <li><?=$val;?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!-- <label class="c-form__label" for="">
            日付
            <input class="c-form__input" type="date" name="date">
            <div class="u-err-msg">
                
            </div>
        </label>
        <label class="c-form__label" for="">
            打ち込んだ文字数
            <input class="c-form__input" type="text" name="email" value="">
            <div class="u-err-msg">
                
            </div>
        </label>
        
        <input class="c-form__submit" type="submit" value="登録する"> -->
        <?=$registform?>
    </div>
</main>