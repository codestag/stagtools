<?php

class stag_shortcodes {

	var	$conf;
	var	$popup;
	var	$params;
	var	$shortcode;
	var $cparams;
	var $cshortcode;
	var $popup_title;
	var $no_preview;
	var $has_child;
	var	$output;
	var	$errors;

	function __construct( $popup ) {
		if( file_exists( dirname(__FILE__) . '/config.php' ) ) {
			$this->conf = dirname(__FILE__) . '/config.php';
			$this->popup = $popup;

			$this->format_shortcode();
		} else {
			$this->append_error( __('Config file does not exist', 'stag') );
		}
	}

	function append_output( $output ) {
		$this->output = $this->output . "\n" . $output;
	}

	function reset_output( $output ) {
		$this->output = '';
	}

	function append_error( $error ) {
		$this->errors = $this->errors . "\n" . $error;
	}

	function format_shortcode() {
		global $stagtools;
		require_once( $this->conf );

		if( isset( $stag_shortcodes[$this->popup]['child_shortcode'] ) ) {
			$this->has_child = true;
		}

		if( isset( $stag_shortcodes ) && is_array( $stag_shortcodes ) ) {
			$this->params = $stag_shortcodes[$this->popup]['params'];
			$this->shortcode = $stag_shortcodes[$this->popup]['shortcode'];
			$this->popup_title = $stag_shortcodes[$this->popup]['popup_title'];

			$this->append_output( "\n" . '<div id="_stag_shortcode" class="hidden">' . $this->shortcode . '</div>' );
			$this->append_output( "\n" . '<div id="_stag_popup" class="hidden">' . $this->popup . '</div>' );

			if( isset( $stag_shortcodes[$this->popup]['no_preview'] ) && $stag_shortcodes[$this->popup]['no_preview'] ) {
				$this->no_preview = true;
			}

			foreach( $this->params as $pkey => $param) {

				// prefix the name and id with stag_
				$pkey = 'stag_' . $pkey;

				$row_start  = '<tbody>' . "\n";
				$row_start .= '<tr class="form-row">' . "\n";
				$row_start .= '<td class="label">' . $param['label'] . '</td>' . "\n";
				$row_start .= '<td class="field">' . "\n";

				$row_end	= '<span class="stag-form-desc">' . $param['desc'] . '</span>' . "\n";
				$row_end   .= '</td>' . "\n";
				$row_end   .= '</tr>' . "\n";					
				$row_end   .= '</tbody>' . "\n";

				switch( $param['type'] ) {
					
					case 'text' :
						$output = $row_start;
						$output .= '<input type="text" class="stag-form-text stag-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />'."\n";
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'textarea' :
						$output = $row_start;
						$output .= '<textarea rows="8" cols="30" class="stag-form-textarea stag-input" name="' . $pkey . '" id="' . $pkey . '">' . $param['std'] . '</textarea>'."\n";
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'select' :
						$output = $row_start;
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="stag-form-select stag-input">' . "\n";

						foreach( $param['options'] as $value => $option ) {
							$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
						}

						$output .= '</select>' . "\n";
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'checkbox' :
						$output = $row_start;
						$output .= '<label for="' . $pkey . '" class="stag-form-checkbox">' . "\n";
						$output .= '<input type="checkbox" class="stag-input" name="' . $pkey . '" id="' . $pkey . '" ' . ( $param['std'] ? 'checked' : '' ) . ' />' . "\n";
						$output .= ' ' . $param['checkbox_text'] . '</label>' . "\n";
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'image';
						$output = $row_start;
						$output .= '<a href="#" data-type="image" data-text="Insert Image" class="stag-open-media button" title="' . esc_attr__( 'Choose Image', 'stag' ) . '">' . __( 'Choose Image', 'stag' ) . '</a>';
						$output .= '<input class="stag-input" type="text" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />';
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'video';
						$output = $row_start;
						$output .= '<a href="#" data-type="video" data-text="Insert Video" class="stag-open-media button" title="' . esc_attr__( 'Choose Video', 'stag' ) . '">' . __( 'Choose Video', 'stag' ) . '</a>';
						$output .= '<input class="stag-input" type="text" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />';
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'icons':
						$output = $row_start;
						$output .= '<div class="stag-all-icons">';

						foreach( $this->fontIcons() as $icon ) {
							$output .= '<i data-icon-id="'.$icon.'" class="stag-icon icon-'.$icon.'" rel="icon-'.$icon.'"></i>';
						}

						$output .= '</div>';
						$output .= '<input class="stag-input" type="hidden" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />';
						$output .= $row_end;
						$this->append_output( $output );
					break;

					case 'widget_area':
						if ( $stagtools->is_scs_active() ){
							$output = $row_start;

							$output .= "<p>Hello Custom Widget Area</p>";

							$output .= $row_end;
							$this->append_output( $output );
						} else {
							return false;
						}
					break;

				}
			}

			if( isset( $stag_shortcodes[$this->popup]['child_shortcode'] ) ) {
				$this->cparams = $stag_shortcodes[$this->popup]['child_shortcode']['params'];
				$this->cshortcode = $stag_shortcodes[$this->popup]['child_shortcode']['shortcode'];

				$prow_start  = '<tbody>' . "\n";
				$prow_start .= '<tr class="form-row has-child">' . "\n";
				$prow_start .= '<td><a href="#" id="form-child-add" class="button-secondary">' . $stag_shortcodes[$this->popup]['child_shortcode']['clone_button'] . '</a>' . "\n";
				$prow_start .= '<div class="child-clone-rows">' . "\n";
				
				// for js use
				$prow_start .= '<div id="_stag_cshortcode" class="hidden">' . $this->cshortcode . '</div>' . "\n";
				
				// start the default row
				$prow_start .= '<div class="child-clone-row">' . "\n";
				$prow_start .= '<ul class="child-clone-row-form">' . "\n";

				$this->append_output( $prow_start );

				foreach( $this->cparams as $cpkey => $cparam ) {
					$cpkey = 'stag_' . $cpkey;

					$crow_start  = '<li class="child-clone-row-form-row">' . "\n";
					$crow_start .= '<div class="child-clone-row-label">' . "\n";
					$crow_start .= '<label>' . $cparam['label'] . '</label>' . "\n";
					$crow_start .= '</div>' . "\n";
					$crow_start .= '<div class="child-clone-row-field">' . "\n";
					
					$crow_end	  = '<span class="child-clone-row-desc">' . $cparam['desc'] . '</span>' . "\n";
					$crow_end   .= '</div>' . "\n";
					$crow_end   .= '</li>' . "\n";

					switch( $cparam['type'] ) {

						case 'text':
							$coutput  = $crow_start;
							$coutput .= '<input type="text" class="stag-form-text stag-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= $crow_end;
							$this->append_output( $coutput );
						break;

						case 'textarea':
							$coutput  = $crow_start;
							$coutput .= '<textarea rows="10" cols="30" name="' . $cpkey . '" id="' . $cpkey . '" class="stag-form-textarea stag-cinput">' . $cparam['std'] . '</textarea>' . "\n";
							$coutput .= $crow_end;
							$this->append_output( $coutput );
						break;

						case 'select' :
							$coutput  = $crow_start;
							$coutput .= '<select name="' . $cpkey . '" id="' . $cpkey . '" class="stag-form-select stag-cinput">' . "\n";

							foreach( $cparam['options'] as $value => $option ) {
								$coutput .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
							}

							$coutput .= '</select>' . "\n";
							$coutput .= $crow_end;
							$this->append_output( $coutput );
						break;

						case 'checkbox' :
							$coutput  = $crow_start;
							$coutput .= '<label for="' . $cpkey . '" class="stag-form-checkbox">' . "\n";
							$coutput .= '<input type="checkbox" class="stag-cinput" name="' . $cpkey . '" id="' . $cpkey . '" ' . ( $cparam['std'] ? 'checked' : '' ) . ' />' . "\n";
							$coutput .= ' ' . $cparam['checkbox_text'] . '</label>' . "\n";
							$coutput .= $crow_end;
							$this->append_output( $coutput );
						break;

					}
				}

				$prow_end    = '</ul>' . "\n";
				$prow_end   .= '<a href="#" class="child-clone-row-remove">Remove</a>' . "\n";
				$prow_end   .= '</div>' . "\n";
				$prow_end   .= '</div>' . "\n";
				$prow_end   .= '</td>' . "\n";
				$prow_end   .= '</tr>' . "\n";
				$prow_end   .= '</tbody>' . "\n";

				$this->append_output( $prow_end );

			}

		}

	}

	function fontIcons() {
		$icons = explode(' ', "glass music search envelope-alt heart star star-empty user film th-large th th-list ok remove zoom-in zoom-out off signal cog trash home file-alt time road download-alt download upload inbox play-circle repeat refresh list-alt lock flag headphones volume-off volume-down volume-up qrcode barcode tag tags book bookmark print camera font bold italic text-height text-width align-left align-center align-right align-justify list indent-left indent-right facetime-video picture pencil map-marker adjust tint edit share check move step-backward fast-backward backward play pause stop forward fast-forward step-forward eject chevron-left chevron-right plus-sign minus-sign remove-sign ok-sign question-sign info-sign screenshot remove-circle ok-circle ban-circle arrow-left arrow-right arrow-up arrow-down share-alt resize-full resize-small plus minus asterisk exclamation-sign gift leaf fire eye-open eye-close warning-sign plane calendar random comment magnet chevron-up chevron-down retweet shopping-cart folder-close folder-open resize-vertical resize-horizontal bar-chart twitter-sign facebook-sign camera-retro key cogs comments thumbs-up-alt thumbs-down-alt star-half heart-empty signout linkedin-sign pushpin external-link signin trophy github-sign upload-alt lemon phone check-empty bookmark-empty phone-sign twitter facebook github unlock credit-card rss hdd bullhorn bell certificate hand-right hand-left hand-up hand-down circle-arrow-left circle-arrow-right circle-arrow-up circle-arrow-down globe wrench tasks filter briefcase fullscreen group link cloud beaker cut copy paper-clip save sign-blank reorder list-ul list-ol strikethrough underline table magic truck pinterest pinterest-sign google-plus-sign google-plus money caret-down caret-up caret-left caret-right columns sort sort-down sort-up envelope linkedin undo legal dashboard comment-alt comments-alt bolt sitemap umbrella paste lightbulb exchange cloud-download cloud-upload user-md stethoscope suitcase bell-alt coffee food file-text-alt building hospital ambulance medkit fighter-jet beer h-sign plus-sign-alt double-angle-left double-angle-right double-angle-up double-angle-down angle-left angle-right angle-up angle-down desktop laptop tablet mobile-phone circle-blank quote-left quote-right spinner circle reply github-alt folder-close-alt folder-open-alt expand-alt collapse-alt smile frown meh gamepad keyboard flag-alt flag-checkered terminal code reply-all mail-reply-all star-half-empty location-arrow crop code-fork unlink question info exclamation superscript subscript eraser puzzle-piece microphone microphone-off shield calendar-empty fire-extinguisher rocket maxcdn chevron-sign-left chevron-sign-right chevron-sign-up chevron-sign-down html5 css3 anchor unlock-alt bullseye ellipsis-horizontal ellipsis-vertical rss-sign play-sign ticket minus-sign-alt check-minus level-up level-down check-sign edit-sign external-link-sign share-sign compass collapse collapse-top expand eur gbp usd inr jpy cny krw btc file file-text sort-by-alphabet sort-by-alphabet-alt sort-by-attributes sort-by-attributes-alt sort-by-order sort-by-order-alt thumbs-up thumbs-down youtube-sign youtube xing xing-sign youtube-play dropbox stackexchange instagram flickr adn bitbucket bitbucket-sign tumblr tumblr-sign long-arrow-down long-arrow-up long-arrow-left long-arrow-right apple windows android linux dribbble skype foursquare trello female male gittip sun moon archive bug vk weibo renren");

		return $icons;
	}

}

?>
