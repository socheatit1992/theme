<div class="pop-text">
<?php 
        $cart = frame::_()->getModule('user')->getModel('cart')->get();
        $count_items = 0;
    
        foreach($cart as $inCartId => $c) { 
            $count_items += $c['qty'];
        }
?>
<p><?php lang::_e("New product was added to shopping cart,<br />would you like go to Checkout or continue shopping?<br />Your cart has currently <span class='blue-text'>($count_items)</span> items.")?></p></div>
<div class="popup-buttons">
    <a href="<?php echo frame::_()->getModule('pages')->getLink(array('mod' => 'user', 'action' => 'getShoppingCart'))?>" class="button-blue"><?php lang::_e('Go to Cart ')?></a>
    <a id="pop-continue" href="#" onclick="closePopupWindow(); return false;" class="btn"><?php lang::_e('Continue Shoping')?></a>
</div>
