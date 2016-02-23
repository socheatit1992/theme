<?php foreach($this->brands as $b) { ?>
<article class="toeCategotyListPage product-text product-single-txt twelve columns">
    <div class="entry-content row">
        <div class="thumb three columns">
            <?php if($imgSrc = frame::_()->getModule('products')->getBrandImage($b)) { ?>
				<a href="<?php echo frame::_()->getModule('products')->getLinkToBrand($b, $b->slug)?>"><?php echo html::img($imgSrc, false);?></a>
			<?php } else {
				echo '&nbsp;';
			}?> 
        </div>
        <div class="toeCategoryListDescription nine columns nopadding">
            <h3 class="entry-title"><a href="<?php echo frame::_()->getModule('products')->getLinkToBrand($b, $b->slug)?>"><?php echo $b->name?></a></h3>
            <?php if (!empty($b->description)) echo nl2br($b->description).'<br />'; ?>
            <a href="<?php echo frame::_()->getModule('products')->getLinkToCategory($b, $b->slug)?>"><?php lang::_e('Watch the products'); ?></a>
        </div>
    </div><!-- .entry-content -->
</article>
<?php }?>
