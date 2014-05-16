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

						ksort($param['options']);

						if( !isset( $param['std'] ) ) $param['std'] = '';

						foreach( $param['options'] as $value => $option ) {
							$output .= "<option value='$value' ". selected( $value, $param['std'], false ) .">$option</option>";
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
							$output .= '<i data-icon-id="'.$icon.'" class="fa fa-'.$icon.'" title="'.$icon.'"></i>';
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
		$icons = explode(' ', "adjust adn align-center align-justify align-left align-right ambulance anchor android angle-double-down angle-double-left angle-double-right angle-double-up angle-down angle-left angle-right angle-up apple archive arrow-circle-down arrow-circle-left arrow-circle-o-down arrow-circle-o-left arrow-circle-o-right arrow-circle-o-up arrow-circle-right arrow-circle-up arrow-down arrow-left arrow-right arrow-up arrows arrows-alt arrows-h arrows-v asterisk automobile backward ban bank bar-chart-o barcode bars beer behance behance-square bell bell-o bitbucket bitbucket-square bitcoin bold bolt bomb book bookmark bookmark-o briefcase btc bug building building-o bullhorn bullseye cab calendar calendar-o camera camera-retro car caret-down caret-left caret-right caret-square-o-down caret-square-o-left caret-square-o-right caret-square-o-up caret-up certificate chain chain-broken check check-circle check-circle-o check-square check-square-o chevron-circle-down chevron-circle-left chevron-circle-right chevron-circle-up chevron-down chevron-left chevron-right chevron-up child circle circle-o circle-o-notch circle-thin clipboard clock-o cloud cloud-download cloud-upload cny code code-fork codepen coffee cog cogs columns comment comment-o comments comments-o compass compress copy credit-card crop crosshairs css3 cube cubes cut cutlery dashboard database dedent delicious desktop deviantart digg dollar dot-circle-o download dribbble dropbox drupal edit eject ellipsis-h ellipsis-v empire envelope envelope-o envelope-square eraser eur euro exchange exclamation exclamation-circle exclamation-triangle expand external-link external-link-square eye eye-slash facebook facebook-square fast-backward fast-forward fax female fighter-jet file file-archive-o file-audio-o file-code-o file-excel-o file-image-o file-movie-o file-o file-pdf-o file-photo-o file-picture-o file-powerpoint-o file-sound-o file-text file-text-o file-video-o file-word-o file-zip-o files-o film filter fire fire-extinguisher flag flag-checkered flag-o flash flask flickr floppy-o folder folder-o folder-open folder-open-o font forward foursquare frown-o gamepad gavel gbp ge gear gears gift git git-square github github-alt github-square gittip glass globe google google-plus google-plus-square graduation-cap group h-square hacker-news hand-o-down hand-o-left hand-o-right hand-o-up hdd-o header headphones heart heart-o history home hospital-o html5 image inbox indent info info-circle inr instagram institution italic joomla jpy jsfiddle key keyboard-o krw language laptop leaf legal lemon-o level-down level-up life-bouy life-ring life-saver lightbulb-o link linkedin linkedin-square linux list list-alt list-ol list-ul location-arrow lock long-arrow-down long-arrow-left long-arrow-right long-arrow-up magic magnet mail-forward mail-reply mail-reply-all male map-marker maxcdn medkit meh-o microphone microphone-slash minus minus-circle minus-square minus-square-o mobile mobile-phone money moon-o mortar-board music navicon openid outdent pagelines paper-plane paper-plane-o paperclip paragraph paste pause paw pencil pencil-square pencil-square-o phone phone-square photo picture-o pied-piper pied-piper-alt pied-piper-square pinterest pinterest-square plane play play-circle play-circle-o plus plus-circle plus-square plus-square-o power-off print puzzle-piece qq qrcode question question-circle quote-left quote-right ra random rebel recycle reddit reddit-square refresh renren reorder repeat reply reply-all retweet rmb road rocket rotate-left rotate-right rouble rss rss-square rub ruble rupee save scissors search search-minus search-plus send send-o share share-alt share-alt-square share-square share-square-o shield shopping-cart sign-in sign-out signal sitemap skype slack sliders smile-o sort sort-alpha-asc sort-alpha-desc sort-amount-asc sort-amount-desc sort-asc sort-desc sort-down sort-numeric-asc sort-numeric-desc sort-up soundcloud space-shuttle spinner spoon spotify square square-o stack-exchange stack-overflow star star-half star-half-empty star-half-full star-half-o star-o steam steam-square step-backward step-forward stethoscope stop strikethrough stumbleupon stumbleupon-circle subscript suitcase sun-o superscript support table tablet tachometer tag tags tasks taxi tencent-weibo terminal text-height text-width th th-large th-list thumb-tack thumbs-down thumbs-o-down thumbs-o-up thumbs-up ticket times times-circle times-circle-o tint toggle-down toggle-left toggle-right toggle-up trash-o tree trello trophy truck try tumblr tumblr-square turkish-lira twitter twitter-square umbrella underline undo university unlink unlock unlock-alt unsorted upload usd user user-md users video-camera vimeo-square vine vk volume-down volume-off volume-up warning wechat weibo weixin wheelchair windows won wordpress wrench xing xing-square yahoo yen youtube youtube-play youtube-square");

		return array_unique($icons);
	}

}
