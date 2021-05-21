<!DOCTYPE html>
<html lang="ja">
    <?= $head; ?>
</html>
<body>
    <!-- ヘッダー -->
    <?= $header; ?>
    <?= $contents; ?>
    <!-- フッター -->
    <?= $footer; ?>
    <?= Asset::js('app.js'); ?>
</body>
</html>