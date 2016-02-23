<div class="toeWidget">
    <div id="toeCurrencyWidgetContent<?php echo $this->uniqID?>">
        <ul id="currency">
            <?php 
                echo '<li class="current-list-item '.$this->default['code'].'">'.$this->default['code'].'</li>';
                foreach($this->all as $c) {
                    if ($c['id'] != $this->default['id']) {
						uri::oneHtmlEnc();
                        echo '<li class="'.$c['code'].'"><a href="';
                        echo uri::mod('currency', '', 'setCurrency', array('code' => $c['code'], 'redirect' => $this->redirect));
                        echo '">'.$c['code'].'</a></li>';
                    }
                } 
            ?>
        </ul>
    </div>
</div>