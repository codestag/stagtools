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
							$output .= '<i data-icon-id="'.$icon.'" class="stag-icon icon-'.$icon.'" title="'.$icon.'"></i>';
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
		$icons = explode(' ', "glass music search envelope-o heart star star-o user film th-large th th-list check times search-plus search-minus power-off signal cog trash-o home file-o clock-o road download arrow-circle-o-down arrow-circle-o-up inbox play-circle-o repeat refresh list-alt lock flag headphones volume-off volume-down volume-up qrcode barcode tag tags book bookmark print camera font bold italic text-height text-width align-left align-center align-right align-justify list dedent outdent indent video-camera picture-o pencil map-marker adjust tint edit pencil-square-o share-square-o check-square-o arrows step-backward fast-backward backward play pause stop forward fast-forward step-forward eject chevron-left chevron-right plus-circle minus-circle times-circle check-circle question-circle info-circle crosshairs times-circle-o check-circle-o ban arrow-left arrow-right arrow-up arrow-down mail-forward share expand compress plus minus asterisk exclamation-circle gift leaf fire eye eye-slash exclamation-triangle plane calendar random comment magnet chevron-up chevron-down retweet shopping-cart folder folder-open arrows-v arrows-h bar-chart-o twitter-square facebook-square camera-retro key gears cogs comments thumbs-o-up thumbs-o-down star-half heart-o sign-out linkedin-square thumb-tack external-link sign-in trophy github-square upload lemon-o phone square-o bookmark-o phone-square twitter facebook github unlock credit-card rss hdd-o bullhorn bell certificate hand-o-right hand-o-left hand-o-up hand-o-down arrow-circle-left arrow-circle-right arrow-circle-up arrow-circle-down globe wrench tasks filter briefcase arrows-alt group users chain link cloud flask cut scissors copy files-o paperclip save floppy-o square bars list-ul list-ol strikethrough underline table magic truck pinterest pinterest-square google-plus-square google-plus money caret-down caret-up caret-left caret-right columns unsorted sort envelope linkedin rotate-left undo legal gavel dashboard tachometer comment-o comments-o bolt sitemap umbrella paste clipboard lightbulb-o exchange cloud-download cloud-upload user-md stethoscope suitcase bell-o coffee cutlery file-text-o building-o hospital-o ambulance medkit fighter-jet beer h-square plus-square angle-double-left angle-double-right angle-double-up angle-double-down angle-left angle-right angle-up angle-down desktop laptop tablet mobile-phone mobile circle-o quote-left quote-right spinner circle reply github-alt folder-o folder-open-o smile-o frown-o meh-o gamepad keyboard-o flag-o flag-checkered terminal code reply-all star-half-empty star-half-o location-arrow crop code-fork chain-broken question info exclamation superscript subscript eraser puzzle-piece microphone microphone-slash shield calendar-o fire-extinguisher rocket maxcdn chevron-circle-left chevron-circle-right chevron-circle-up chevron-circle-down html5 css3 anchor unlock-alt bullseye ellipsis-h ellipsis-v rss-square play-circle ticket minus-square minus-square-o level-up level-down check-square pencil-square external-link-square share-square compass caret-square-o-down caret-square-o-up caret-square-o-right eur gbp usd inr jpy rub krw btc file file-text sort-alpha-asc sort-alpha-desc sort-amount-asc sort-amount-desc sort-numeric-asc sort-numeric-desc thumbs-up thumbs-down youtube-square youtube xing xing-square youtube-play dropbox stack-overflow instagram flickr adn bitbucket bitbucket-square tumblr tumblr-square long-arrow-down long-arrow-up long-arrow-left long-arrow-right apple windows android linux dribbble skype foursquare trello female male gittip sun-o moon-o archive bug vk weibo renren pagelines stack-exchange arrow-circle-o-right arrow-circle-o-left caret-square-o-left dot-circle-o wheelchair vimeo-square try plus-square-o");

		return array_unique($icons);
	}

}

?>
