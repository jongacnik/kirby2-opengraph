<?php $opengraph = $page->opengraph() ?>
<meta name="description" content="<?= $opengraph['description'] ?>" />
<meta name="twitter:card" value="<?= $opengraph['description'] ?>" />
<meta property="og:title" content="<?= $opengraph['title'] ?>" />
<meta property="og:url" content="<?= thisUrl() ?>" />
<meta property="og:description" content="<?= $opengraph['description'] ?>" />
<?php if ($opengraph['image']) : ?>
<meta property="og:image" content="<?= $opengraph['image'] ?>" />
<?php endif ?>