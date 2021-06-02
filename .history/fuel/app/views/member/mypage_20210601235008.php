<main id="l-main" class="u-bgColor js-sp-menu-target">
        <div class="c-main">
            <!-- ニュース -->
            <section id="l-news">
                <div class="c-container c-news">
                    <h2 class="c-container__tit">お知らせ</h2>
                    <ul class="c-news__body">
                        <li>
                            <span class="c-news__date">2021/05/27</span>
                            <span>現在、サイト制作中です。</span>
                        </li>
                    </ul>
                </div>
            </section><!-- /ニュース -->
            <!-- 記録表示 -->
            <section id="l-stack">
                <div class="c-container p-stack">
                    <h2 class="c-container__tit">積み上げデータ</h2>
                    <p class="p-stack__term">
                        <span><i class="fas fa-chevron-left"></i></span>
                        <span class="p-stack__head"><?=date('Y年m月')?></span>
                        <span><i class="fas fa-chevron-right"></i></span>
                    </p>
                    <div class="p-stack__body">
                        <div class="p-stack__area">
                            <table class="p-stack__table">
                                <tbody>
                                    <tr>
                                        <th class="p-stack__cell">日付</th>
                                        <th class="p-stack__cell">文字数</th>
                                        <th class="p-stack__cell">増加率</th>
                                    </tr>
                                    <!-- 今月のデータを全て表示 -->
                                    <?php if(!empty($post_tdata)){ ?>
                                        <?php foreach($post_tdata as $key => $val): ?>                                    
                                        <tr>
                                            <th class="p-stack__cell"><?=$post_tdata[$key]->created_at?></th>
                                            <th class="p-stack__cell"><?=$post_tdata[$key]->text_num?></th>
                                            <th class="p-stack__cell">+5</th>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <table class="p-stack__table">
                                <tbody>
                                    <tr>
                                        <th class="p-stack__cell">項目</th>
                                        <th class="p-stack__cell">文字数</th>
                                    </tr>
                                    <tr>
                                        <th class="p-stack__cell">月平均</th>
                                        <th class="p-stack__cell">100011</th>
                                    </tr>
                                    <tr>
                                        <th class="p-stack__cell">月合計</th>
                                        <th class="p-stack__cell">10000</th>
                                    </tr>
                                    <tr>
                                        <th class="p-stack__cell">年平均</th>
                                        <th class="p-stack__cell">100011</th>
                                    </tr>
                                    <tr>
                                        <th class="p-stack__cell">年合計</th>
                                        <th class="p-stack__cell">10000</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <!-- サイドバー -->
    <?=$sidebar?>
</main>

<div class="u-upArrow">
    <i class="fas fa-chevron-circle-up"></i>
</div>