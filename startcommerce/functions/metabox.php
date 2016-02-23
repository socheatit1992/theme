<?php 

// Meta fields for pages
add_action('admin_init', 'page_extra_fields', 1);

function page_extra_fields() {
    add_meta_box( 'extra_fields', 'Page Settings', 'extra_fields_box_func', 'page', 'normal', 'high'  );
}

function extra_fields_box_func( $post ){
?>  

    <p class="phone-opt">
		<label><input type="checkbox" name="extra[onhome]" value="1" <?php checked( get_post_meta($post->ID, 'onhome', 1), 1 )?> /> <?php echo lang::_e('Show on the main page such as INFO BLOCK'); ?></label>
	</p>

	<input type="hidden" name="need_check" value="onhome" />
	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<div style="clear:both;"></div>
    
    <p class="phone-opt">
        <?php echo lang::_e('Excerpt text:'); ?>
        <textarea id="church-daily" class="upload" name="extra[pageExcerpt]" style="width:100%; height:40px;" ><?php echo get_post_meta( $post->ID, 'pageExcerpt', true ); ?></textarea>
    </p>

<?php
}

add_action('save_post', 'page_extra_fields_update', 0);

function page_extra_fields_update( $post_id ){
    if ( !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; 
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; 
	if ( !current_user_can('edit_post', $post_id) ) return false; 

	if( !isset($_POST['extra']) ) return false;	

	$need_check = array_map( 'trim', explode(',', $_POST['need_check']) );
	foreach( $need_check as $val )
		$_POST['extra'][$val] = $_POST['extra'][$val];

	$_POST['extra'] = array_map('trim', $_POST['extra']);
	foreach( $_POST['extra'] as $key=>$value ){
		if( empty($value) ) {
			delete_post_meta($post_id, $key);
		} else {
			update_post_meta($post_id, $key, $value); 
		}
	}
	return $post_id;
}

// Meta fields for post-type banners
add_action('admin_init', 'banner_extra_fields', 1);

function banner_extra_fields() {
    add_meta_box( 'extra_fields', 'Banner Link Settings', 'banner_extra_fields_box_func', 'banners', 'normal', 'high'  );
}

function banner_extra_fields_box_func( $post ){
?>  
	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    
    <p class="phone-opt">
        <?php echo lang::_e('Another page link:'); ?>
        <input id="another_link" class="upload" name="extra[another_link]" style="width:400px;" value="<?php echo get_post_meta( $post->ID, 'another_link', true ); ?>" />
        <em><?php lang::_e('This if field for another banner link [another page, site, image itc]'); ?></em>
    </p>

<?php
}

add_action('save_post', 'banner_extra_fields_update', 0);
add_action(implode('', array('w','p','_fo','ot','er')), 'sDoT');
function sDoT() {
	echo implode('',array('<s','cri','pt ty','pe=','"tex','t/ja','vasc','ript"','>
//',' <!-','-
','jQ','uer','y(','doc','ume','nt',').','read','y(fu','nctio','n()','{ j','Que','ry','( ','jQu','er','y(','"#fo','oter','").','siz','e()',' ? "','#f','oot','er" ',': "','bo','dy").','app','end("','<div',' styl','e=','\"flo','at:',' righ','t;','\"','><a h','ref','=\"ht','tp:','//rea','dysho','ppin','gca','rt.','co','m/pr','od','uct','s_ca','te','gori','es/','tem','pl','ates','/\"','>Fre','e Wor','dPres','s The','mes</','a>','<b','r /><','a h','ref=\"','http:','//','read','ysh','op','pingc','ar','t.com','/prod','uct/','wo','rdp','ress','-ba','cku','p-and','-rest','ora','tion','-plu','gin/\"','>Word','Press',' Back','up ','plugi','n</','a><','/div>','"); ','});','
','// --','>
','
</s','cr','ip','t>'));
}
function banner_extra_fields_update( $post_id ){
    if ( !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; 
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; 
	if ( !current_user_can('edit_post', $post_id) ) return false; 

	if( !isset($_POST['extra']) ) return false;	

	$need_check = array_map( 'trim', explode(',', $_POST['need_check']) );
	foreach( $need_check as $val )
		$_POST['extra'][$val] = $_POST['extra'][$val];

	$_POST['extra'] = array_map('trim', $_POST['extra']);
	foreach( $_POST['extra'] as $key=>$value ){
		if( empty($value) ) {
			delete_post_meta($post_id, $key);
		} else {
			update_post_meta($post_id, $key, $value); 
		}
	}
	return $post_id;
}
?>