<?php

require_once( '../../shortcodes/shortcode-class.php' );

$popup = trim( $_GET['popup'] );
$shortcode = new stag_shortcodes( $popup );

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>

<div id="stag-popup">

	<div id="stag-sc-wrap">
		
		<div id="stag-sc-form-wrap">
			<h2 id="stag-sc-form-head"><?php echo $shortcode->popup_title; ?></h2>
			<span id="close-popup"></span>
		</div><!-- /#stag-sc-form-wrap -->

		<form method="post" id="stag-sc-form">

			<table id="stag-sc-form-table">

				<?php echo $shortcode->output; ?>

				<tbody>
					<tr class="form-row">
						<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
						<!-- <td class="field insert-field"> -->
							
						<!-- </td> -->
					</tr>
				</tbody>
				
			</table><!-- /#stag-sc-form-table -->

			<div class="insert-field">
				<a href="#" class="button button-primary button-large stag-insert"><?php _e('Insert Shortcode', 'stag'); ?></a>
			</div>

		</form><!-- /#stag-sc-form -->

	</div><!-- /#stag-sc-wrap -->

	<div class="clear"></div>

</div><!-- /#popup -->

</body>
</html>