<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->getTitle() ?></title>
    <link rel="shortcut icon" href="<?=PROOT?>assets/images/favicon.ico">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <?= $this->content('head') ?>
</head>

<body>

<?= $this->renderBody() ?>

<?= $this->content('scripts') ?>

</body>

</html>