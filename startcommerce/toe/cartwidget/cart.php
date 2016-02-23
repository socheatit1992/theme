<div class="cart-mini toeWidget">
    <div class="toeWidgetTitle">
        <div class="cart-ico">
            <a href="<?php echo frame::_()->getModule('pages')->getLink(array('mod' => 'user', 'action' => 'getShoppingCart'))?>" class="cart-link">
                <img src="<?php echo bloginfo('template_directory').'/img/cart-ico.png'; ?>" alt="<?php lang::_e('Shopping cart'); ?>" />
            </a>
        </div>
        <div class="cart-mini-state">   
            <?php 
            $count_items = 0;
            
            foreach($this->cart as $inCartId => $c) { 
                $count_items += $c['qty'];
            }
            
            if ($count_items > 1) {
                $txt = lang::_('items');
            } else {$txt = lang::_('item');}
            
            echo '<span class="cart_items"> '.$count_items.' '.lang::_("$txt").' - '.frame::_()->getModule('currency')->display( $this->total ).'</span>'; 
            ?>
        </div>
        <a href="<?php echo frame::_()->getModule('pages')->getLink(array('mod' => 'user', 'action' => 'getShoppingCart'))?>" class="cart-link"><?php lang::_e('Cart')?></a>
        <span class="cart-spliter">|</span>
        <a href="#" onclick="toeClearCart({reload: false}); return false;" class="clear-cart"><?php lang::_e('Clear Cart'); ?></a>
        
    </div>
</div>