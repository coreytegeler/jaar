<!doctype html>
<html lang="<?= site()->language() ? site()->language()->code() : 'en' ?>">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title><?= $site->title()->html() ?></title>
  <meta name="description" content="<?= $site->description()->html() ?>">

  <?php $version = 1.1; ?>
  <?= js('assets/js/jquery-3.3.1.min.js') ?>
  <?= js('assets/js/jquery-ui.min.js') ?>
  <?= js('assets/js/scripts.js?v='.$version) ?>
  <?= css('assets/css/style.css?v='.$version) ?>

</head>
<body>