<script type="text/javascript">
// <!--
    if(typeof(toeSetNavigationSelected) != 'undefined') {
        toeSetNavigationSelected('confirnation');
        toeSetNavigationPassed(['cart', 'checkout']);
    }
// -->
</script>
<div id="orderConfirm">
    <div class="clear"></div>
    <h2 id="checkout-confirm"><?php lang::_e('Order Info')?></h2>
    <hr class="wave-line" />
    <?php foreach($this->blokSteps as $sKey => $sInfo) {
        if($sInfo['blokSteps']) continue;
        if(empty($this->$sKey)) continue;
    ?>
        <div class="toe_checkout_part_box six columns confirmation_<?php echo $sInfo['title']; ?>">
            <h2><?php lang::_e($sInfo['title'])?></h2>
            <?php echo $this->$sKey?>
        </div>
    <?php }?>
    
    <hr class="wave-line" />
</div>
<div>
    <div class="four columns">
        <a href="<?php echo frame::_()->getModule('pages')->getLink(array('mod' => 'checkout', 'action' => 'getAllHtml'))?>" class="btn button-blue" style="margin-top:0; width:auto !important;"><?php lang::_e('Back')?></a>
    </div>
    <div class="four columns"></div>
    <div class="payInform four columns"><?php echo $this->processHtml?></div>
</div>