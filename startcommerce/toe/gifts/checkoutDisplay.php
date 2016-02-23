<?php if(!empty($this->gifts['data']) && is_array($this->gifts['data'])) {?>
<br />
<h3><?php lang::_e('Choose your gift')?></h3>
<table class="gift-table twelve">
<?php foreach($this->gifts['data'] as $g) { ?>
    <tr class="gift-table">
        <td>
            <?php if(!empty($g['img'])) { ?>
                <?php echo html::img($g['img'], 0)?>
            <?php }?>
        </td>
        <td>
            <b><?php lang::_e($g['label'])?>:</b>
            <?php if(!empty($g['description'])) {?>
                <p><?php lang::_e(nl2br($g['description']))?></p>
            <?php }?>
        </td>
        <td>
        <?php 
            $giftContent = '';
            switch($g['type']) {
                case 'product':
                    echo $g['freeProductLink'];
                    break;
            }
            echo $giftContent;
        ?>
        </td>
    </tr>
<?php }?>
    <?php /*if(!empty($this->gifts['total'])) { ?>
    <tr>
        <td><?php lang::_e('Total gift bonus')?></td>
        <td><?php echo frame::_()->getModule('currency')->display($this->gifts['total'])?></td>
    </tr>
    <?php }*/?>
</table>
<?php }?>