<main id="l-main" class="u-bgColor js-sp-menu-target">
    <div class="c-main">
        <h4>本サイトにお越しくださり、ありがとうございます。</h4>
        <h4>本サイトでは、作家さん、学生、サラリーマンの方が日々の記録を手助けします。</h4><br><br>
        <p>以下のボタンからユーザー登録、ログインをして利用することができます。</p><br>
        <a href="<?= Uri::create('signup') ?>" class="c-form__submit">ユーザー登録</a>
        <a href="<?= Uri::create('login') ?>" class="c-form__submit">ログイン</a>
        <br><br>
        <div><?= Asset::img('pic2.png') ?></div>
        <p>上記のページで今日、入力した文字数をうつだけで、自動的に月、年の合計文字数を計算し、Twitterへツイートすることができます。</p><br>
        <div><?= Asset::img('pic1.png') ?></div>
        
    </div>
</main>
