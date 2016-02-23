<?php if(isset($this->oldPrice)) { ?>
    <s><?php echo frame::_()->getModule('currency')->display($this->oldPrice)?></s>
<?php }?>
<?php if($this->showFromPriceLabel) { ?>
    <?php lang::_e('From ')?>
<?php }?>
<?php echo frame::_()->getModule('currency')->display($this->price)?>