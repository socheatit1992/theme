<div class="new-products">
    <?php if(!empty($this->params['title'])) { ?>
        <h2><?php lang::_e($this->params['title'])?></h2>
    <?php }?>
    <hr class="wave-line" />
    <div class="clear"></div>
    
    <ul class="items-list">
        <?php if (!empty($this->products)):
              foreach ($this->products as $product) :?>
        <li>
            <div class="items-image-block">
                <a href="<?php echo $product['guid']?>" title="<?php echo $product['title'];?>">
                    <?php 
                        $imgsrc = $product['image']['thumb'][0];
                    ?>
                    <img class="productPict" src="<?php get_image($imgsrc, 138, 84, 'height'); ?>" alt="<?php echo $product['title'];?>" />
                </a>
            </div>
            <a href="<?php echo $product['guid']?>" class="item-name-link"><?php echo $product['title'];?></a>
            <?php if ($this->params['show_price']) :?>
            <div class="item-list-price <?php if(frame::_()->getModule('products')->markAsSale($product['productID']) == true) {echo 'hot-price'; } ?>">
                <?php if( $product['post']->toePriceOptExist ) lang::_e('From '); ?><?php echo $product['price'];?>
            </div>
            <?php endif;?>
            <div class="item-rating"><?php echo $product['ratingBox']; ?></div>
        </li>
        
        <?php endforeach;
        endif;  ?>
    </ul>
    
</div><!-- End new-products -->

<div class="clear"></div>