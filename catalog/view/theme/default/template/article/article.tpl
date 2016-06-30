<?php echo $header; ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" ><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="article-info">
    <?php if ($thumb ) { ?>
    <div class="left">
	      <img   height="<?php echo $image_thumb_height; ?>" width="<?php echo $image_thumb_width; ?>" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image"   />
    </div>
    <?php } ?>
    <div class="right">
      <h1><?php echo $heading_title; ?></h1>
      <div class="article-content"><?php echo htmlspecialchars_decode($article_info['content']); ?></div>
      <!-- tag begin -->
		  <?php if ($tags) { ?>
		  <div class="tags"><b><?php echo $text_tags; ?></b>
		    <?php foreach ($tags as $tag) { ?>
		    <a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a>&nbsp;
		    <?php } ?>
		  </div>
		  <?php } ?>
	   <!-- tag end -->

	   <div class="share">
	     
	  </div>
    </div>
  </div>
  <?php if ($articles) { ?>
  <div id="tab-related" class="tab-content">
  	<h2><span><?php echo $tab_related; ?> (<?php echo count($articles); ?>)</span></h2>
    <div class="box-article" id="related-jcarousel" >
    <ul class="jcarousel-skin-opencart">
     <?php foreach ($articles as $article) { ?>
     	<li>
	      <div>
	        <?php if ($article['thumb']) { ?>
	        <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['title']; ?>" /></a></div>
	        <?php } ?>
	        <div class="title"><a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></div>
	      </div>
	      </li>
      <?php } ?>
      </ul>
    </div>
  </div>
  <?php } ?>

 <?php echo $content_bottom; ?></div>

<?php echo $footer; ?>