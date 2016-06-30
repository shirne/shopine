<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <h1><?php echo $heading_title; ?></h1>
    <?php if ($thumb || $description) { ?>
    <div class="category-info">
        <?php if ($thumb) { ?>
        <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
        <?php } ?>
        <?php if ($description) { ?>
        <?php echo $description; ?>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if ($categories) { ?>
    <div class="category-list">
        <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
    <?php if ($articles) { ?>
    <div class="article-list">
        <?php foreach ($articles as $article) { ?>
        <div class="article">
            <?php if ($article['thumb']) { ?>
            <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" title="<?php echo $article['title']; ?>" alt="<?php echo $article['title']; ?>" /></a></div>
            <?php } ?>
            <div class="title"><a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></div>
            <div class="content"><?php echo $article['content']; ?></div>

        </div>
        <?php } ?>
    </div>
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php } ?>
    <?php if (!$categories && !$articles) { ?>
    <div class="content"><?php echo $text_empty; ?></div>

    <?php } ?>
    <?php echo $content_bottom; ?></div>

    <?php echo $footer; ?>