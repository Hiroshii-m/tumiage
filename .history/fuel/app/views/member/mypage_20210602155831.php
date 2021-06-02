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
                        <a href="<?php Uri::create('member/mypage', array('month' => ($currentMonth - 1)), array('currentMonth' => ':month')) ?>"><i class="fas fa-chevron-left"></i></a>
                        <span class="p-stack__head"><?=date('Y年m月')?></span>
                        <a href=""><i class="fas fa-chevron-right"></i></a>
                    </p>
                    <div class="p-stack__body">
                        <div class="p-stack__area">
                            <table class="p-stack__table">
                                <tbody>
                                    <tr class="u-text-center">
                                        <th class="p-stack__cell">日付</th>
                                        <th class="p-stack__cell">文字数</th>
                                        <th class="p-stack__cell">増加率</th>
                                    </tr>
                                    <!-- 今月のデータを全て表示 -->
                                    <?php if(!empty($post_tdata)){ ?>
                                        <?php foreach($post_tdata as $key => $val): ?>
                                        <tr>
                                            <th class="p-stack__cell"><?=date('m/d', strtotime($val['created_at']))?></th>
                                            <th class="p-stack__cell"><?=$val['text_num']?></th>
                                            <th class="p-stack__cell"><?= (!empty($post_tdata[$key-1]['text_num'])) ? $val['text_num'] - $post_tdata[$key - 1]['text_num'] : '-'; ?></th>
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
                                    <?php if(!empty($post_month)){ ?>
                                    <tr>
                                        <th class="p-stack__cell">月平均</th>
                                        <th class="p-stack__cell"><?= round($post_month[0]->month_sum/$month_count, 2) ?></th>
                                    </tr>
                                    <tr>
                                        <th class="p-stack__cell">月合計</th>
                                        <th class="p-stack__cell"><?= $post_month[0]->month_sum ?></th>
                                    </tr>
                                    <?php } ?>
                                    <?php if(!empty($post_year)){ ?>
                                    <tr>
                                        <th class="p-stack__cell">年平均</th>
                                        <th class="p-stack__cell"><?= round($post_year[0]->year_sum/$year_count, 2) ?></th>
                                    </tr>
                                    <tr>
                                        <th class="p-stack__cell">年合計</th>
                                        <th class="p-stack__cell"><?= $post_year[0]->year_sum ?></th>
                                    </tr>
                                    <?php } ?>
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