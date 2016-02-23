<div class="toeRatesBlock<?php echo $this->post->ID?>">
    <ul class="toeRating">
        <?php for($i = 1; $i <= $this->count; $i++) {?>
        <li>
            <a href="#" onclick="toeRateProduct(<?php echo $i?>, <?php echo $this->post->ID?>); return false;" class="toeRatingLink<?php echo $i?> toeStarOff"><?php echo $i?></a>
        </li> 
        <?php }?>
    </ul>
</div>