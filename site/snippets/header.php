<!doctype html>
<html lang="<?= site()->language() ? site()->language()->code() : 'en' ?>">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title><?= $site->title()->html() ?></title>
  <meta name="description" content="<?= $site->description()->html() ?>">

  <?= js('assets/js/jquery-3.3.1.min.js') ?>
  <?= js('assets/js/scripts.js') ?>
  <?= css('assets/css/style.css') ?>

</head>
<body>