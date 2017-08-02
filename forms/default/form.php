<!--  Form wrapper -->
<div id="gmw-cl-default-form-wrapper" class="gmw-cl-form-wrapper">
	
	<!--  Form header -->
	<div id="gmw-cl-form-header">
		<h3 id="gmw-cl-title"><?php _e( 'Your Location', 'GMW' ); ?></h3>
		<span id="gmw-cl-close-btn">X</span>
	</div>
	
	<!--  Form -->
	<form id="gmw-cl-form" name="gmw_cl_form" onsubmit="return false">
	
		<!-- Form Info wrapper -->
		<div id="gmw-cl-info-wrapper">
		
			<div id="gmw-cl-enter-location-title" class="gmw-cl-form-title">
				<?php _e('Enter Your Location', 'GMW'); ?>
			</div>
			
			<div id="gmw-cl-input-fields">
				<input type="text" name="gmw-cl_address" id="gmw-cl-address" autocomplete="off" value="" placeholder="zipcode or full address..." />
				<a href="#" id="gmw-cl-submit-address" class="gmw-cl-button" title="Submit your location" /><?php _e( 'Go', 'GMW' ); ?></a>
			</div>
			
			<div id="gmw-cl-get-location-title" class="gmw-cl-form-title">
				<?php _e( 'or', 'GMW' ); ?>
			</div>
			<a href="#" id="gmw-cl-trigger" class="gmw-cl-button">
				<?php _e('Get your current location', 'GMW'); ?>
			</a>
		</div>
		
		<div id="gmw-cl-respond-wrapper">
			<div id="gmw-cl-message"></div>
			<div id="gmw-cl-map" style="width:100%;height:100px;display:none;"></div>
			<div id="gmw-cl-spinner"><img src="<?php echo GMW_IMAGES; ?>/gmw-loader.gif" /></div>
		</div>
	</form>
</div>