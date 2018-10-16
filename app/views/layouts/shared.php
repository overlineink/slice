<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->getTitle() ?></title>
    <link rel="stylesheet" href="<?=PROOT?>assets/css/bulma.min.css">
    <script defer src="<?=PROOT?>assets/js/all.js"></script>
    <link rel="shortcut icon" href="<?=PROOT?>assets/images/favicon.ico">
    <?= $this->content('head') ?>
</head>

<body>

<?= $this->renderBody() ?>

<?= $this->content('scripts') ?>

</body>

</html>