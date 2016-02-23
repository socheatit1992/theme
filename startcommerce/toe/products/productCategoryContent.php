<form action="" method="post" class="toeAddToCartForm" id="toeAddToCartForm<?php echo $this->post->ID?>" onsubmit="toeAddToCart(this); return false;">
<div class="grid-item-view <?php if($_COOKIE['catalogView'] == 'grid' || $_COOKIE['catalogView'] == null) echo 'active-catalog-view' ?>">
    <div class="items-image-block">
        <a href="<?php echo get_permalink($this->post->ID); ?>" title="<?php echo get_the_title();?>">
            <?php 
                $imgsrc = $this->image['big'][0];
            ?>
            <img class="productPict" src="<?php get_image($imgsrc, 138, 84, 'height'); ?>" alt="<?php echo $product['title'];?>" />
        </a>
    </div>
    <a href="<?php echo get_permalink($this->post->ID); ?>" class="item-name-link"><?php echo get_the_title();?></a>
    <div class="item-list-price product_price <?php if(frame::_()->getModule('products')->markAsSale($this->post->ID) == true) {echo 'hot-price'; } ?>">
        <span><?php echo $this->priceHtml?></span>
    </div>
    
    <div class="item-rating"><?php echo $this->ratingBox; ?></div>
</div>

<div id="item-<?php echo $this->post->ID; ?>" class="item list-item-view <?php if($_COOKIE['catalogView'] == 'list') echo 'active-catalog-view' ?>">
    <div class="category_product">
        <div class="product_wrap">
            <div class="item-img product_main items-image-block">
                <!--toeImage-->
                <?php
                    $imgsrc = $this->image['big'][0];
                ?>
                <a href="<?php echo get_permalink($this->post->ID); ?>" title="<?php echo get_the_title();?>">
                    <img src="<?php get_image($imgsrc, 138, 84, 'height'); ?>" alt="<?php echo get_the_title();?>" class="productPict" />
                </a>
                <!--/toeImage-->
            </div>
            <div class="item-description product_info">
                <div class="product_main_info">
                    <div class="product_block_wrapper">
                        <!--toetitle-->
                        <a href="<?php echo get_permalink($this->post->ID); ?>"><?php echo get_the_title();?></a>
                        <!--/toetitle-->
                        <div class="item-rating"><?php echo $this->ratingBox; ?></div>
                        <div class="item-price product_price item-list-price <?php if(frame::_()->getModule('products')->markAsSale($this->post->ID) == true) {echo 'hot-price'; } ?>">
                            <span><?php echo $this->priceHtml?></span>
                        </div>
                        <!--toeshort_description-->
                        <p><?php echo get_the_excerpt(); ?></p>
                        <!--/toeshort_description-->
                        <div class="item-controls">
                            <?php echo $this->actionButtons; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
    </div>
</div>
</form>