<?php foreach($this->categories as $c) { ?>
<article class="toeCategotyListPage product-text product-single-txt twelve columns">
	<div class="entry-content row">
        <div class="thumb three columns">
            <?php if($imgSrc = frame::_()->getModule('products')->getCategoryImage($c)) { ?>
				<a href="<?php echo frame::_()->getModule('products')->getLinkToCategory($c, $c->slug)?>"><?php echo html::img($imgSrc, false);?></a>
			<?php } else {
				echo '&nbsp;';
			}?> 
        </div>
        <div class="toeCategoryListDescription nine columns nopadding">
            <h3 class="entry-title"><a href="<?php echo frame::_()->getModule('products')->getLinkToCategory($c, $c->slug)?>"><?php echo $c->name?></a></h3>
            <?php if (!empty($c->description)) echo nl2br($c->description).'<br />'; ?>
            <a href="<?php echo frame::_()->getModule('products')->getLinkToCategory($c, $c->slug)?>"><?php lang::_e('Watch the products'); ?></a>
        </div>
    </div><!-- .entry-content -->
</article>
<?php }?>