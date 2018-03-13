<?php if( !isset( $_POST['request'] ) ) { ?>
<!doctype html>
<html lang="<?= site()->language() ? site()->language()->code() : 'en' ?>">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title><?= $site->title()->html() ?></title>
  <meta name="description" content="<?= $site->description()->html() ?>">
</head>
<body data-site-url="<?= $site->url() ?>">
  <main class="main" role="main" id="<?= $page->slug() ?>">
    <nav>
      <?php echo page( 'home' )->text()->kirbytext();?>
    </nav>
    <div id="card" <?= ($page->slug() != 'home' ? 'class="show"' : '')?>>
<?php } ?>