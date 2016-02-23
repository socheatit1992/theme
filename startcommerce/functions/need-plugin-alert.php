<?php
if(is_admin()) {
	toeAddBootstrap();
	add_action('admin_footer', 'toeShowRequirePluginPopupHtml');
	function toeShowRequirePluginPopupHtml() {
	?>
	<div id="toeTplRequirePluginPopup" class="modal fade" style="">  
		<div class="modal-dialog text-center">
			<div class="modal-content">
				<div class="modal-header">
					<a class="close" data-dismiss="modal">X</a>
					<h3 class="alert alert-danger"><strong>Warning!</strong></h3>
				</div>
				<div class="modal-body">
					<div class="alert alert-danger">To use this template you need to have installed and activated Ready! Ecommerce plugin on your site! You can find it for FREE on wordpress site here <a href="http://wordpress.org/plugins/ready-ecommerce/" target="_blank">http://wordpress.org/plugins/ready-ecommerce/</a> or click on "Get It" button bellow.</div>
				</div>
				<div class="modal-footer">
					<a href="http://wordpress.org/plugins/ready-ecommerce/" target="_blank" class="btn btn-primary">Get It</a>
				</div>
			</div>
		</div>
	</div>
	   <script type="text/javascript">
	   // <!--
	   jQuery(document).ready(function(){
			jQuery('#toeTplRequirePluginPopup').modal();
	   });
	   // -->
	   </script>		
	<?php
	}
}