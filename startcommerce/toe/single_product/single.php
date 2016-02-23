<div id="toeSPWidgetContent<?php echo $this->uniqID?>">
<?php if (!empty($this->product)):?>
<div class="slider-img">
    <?php
        $imgsrc = $this->product['image']['big'][0];
    ?>
     <a href="<?php echo $this->product['guid'];?>" >
        <img src="<?php get_image($imgsrc, 460, 263, 'height'); ?>" alt="<?php echo get_the_title();?>" />
    </a>
</div>
<div class="slider-text">
    <h2><a href="<?php echo $this->product['guid'];?>"><?php echo $this->product['title'];?></a></h2>
    <?php if ($this->params['show_description']) :?>
        <div class="product_short_description">
            <p>
            <?php echo $this->product['description'];?>
            </p>
        </div>
    <?php endif;?>
    
    <a href="<?php echo $this->product['guid'];?>" class="btn"><?php echo lang::_e('Look Closer'); ?></a>
</div>
<?php endif; ?>
</div>