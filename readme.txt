=== StagTools ===

Contributors: mauryaratan, codestag
Donate link: https://codest.ag/st-donate
Tags: widget, icons, retina, shortcodes, themeforest, font icons, fontawesome, font awesome 5, sidebar, social, social media, maps, google maps, flickr, dribbble, custom post type, codestag, mauryaratan, twitter
Requires at least: 5.0
Requires PHP: 7.3
Tested up to: 6.1.1
Stable tag: 2.3.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

StagTools is a powerful plugin to extend functionality to your WordPress themes offering shortcodes, FontAwesome icons and useful widgets.

== Description ==

StagTools powers your WordPress website with some regularly needed shortcodes including buttons, columns, alerts, font icons etc. It also includes several widgets and editor styles.

**Shortcodes:**

* Buttons ( optionally, with font icons )
* Columns
* Dropcaps
* Tabs
* Toggle
* Font Icons by [Font Awesome](http://fortawesome.github.io/Font-Awesome/)
* Google Maps with 5 predefined styles, and map types
* Custom Sidebars Area ( requires [Stag Custom Sidebars](https://wordpress.org/plugins/stag-custom-sidebars/) plugin )
* Image with CSS3 filters
* Videos ( supports [oEmbeds](https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F) )

**Widgets:** Twitter, Dribbble, Flickr

**Custom Post Types:** Portfolio, Slides, Team, Testimonials

= Get Involved =
If you are a developer, you can contribute to the source code on [StagTools Github Repository](https://github.com/mauryaratan/stagtools)

*Checkout our finely tuned WordPress themes over at [Codestag](https://codestag.com?ref=WordPress).*

== Frequently Asked Questions ==

= What is this plugin and why do I need it? =

The StagTools provides extra functionality to any WordPress theme. It includes shortcode builder, font icons and several widgets along with custom post types (only for Codestag Themes). This plugin is not requirement to use Codestag themes however it extends the theme functionality.

= Can I insert shortcodes manually instead of using shortcode generator? =

Yes; although we have a shortcode builder you can also see a list of [all available shortcodes](https://gist.github.com/mauryaratan/6071262) and use it manually in any supported area.

= Can I use this plugin with other themes? =

The StagTools was developed to work with any WordPress theme as it includes default styling. However, we provide our extra bit of styling to all of our [themes](https://codestag.com) at Codestag.

= Why shortcodes are prefixed with stag_ ? =
Simply to avoid any conflict with other shortcodes on your site enabled via any third-party plugin or theme.

= I love this plugin! Can I contribute? =
Yes you can! Join me on [Github Repository](https://github.com/mauryaratan/stagtools/) :)

== Screenshots ==

1. StagTools widgets will appear in you list of available widgets.
2. Shortcode builder is located on your WordPress editor at very last.
3. All widgets added by StagTools are highlighted.
4. Settings panel for adding twitter oAuth keys.
5. Editor styles; includes Intro Text/Run In and alerts.

== Installation ==

= Minimum Requirements =

* WordPress 4.0 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater

= Automatic Installation =

1. Log in and navigate to Plugins &rarr; Add New.
2. Type “StagTools” into the Search input and click the “Search Widgets” button.
3. Locate the “StagTools” in the list of search results and click “Install Now”.
4. Click the “Activate Plugin” link at the bottom of the install screen.
5. Navigate to Settings &rarr; StagTools to modify the plugin’s settings. The widgets will be available in Appearance &rarr; Widgets.

= Manual Installation =

1. Download the “StagTools” plugin from WordPress.org.
2. Unzip the package and move to your plugins directory.
3. Log into WordPress and navigate to the “Plugins” screen.
4. Locate “StagTools” in the list and click the “Activate” link.
5. Navigate to Settings &rarr; StagTools to learn about the plugin's features. The widgets will be available in Appearance &rarr; Widgets.

== Changelog ==

= 2.3.7 - March 23, 2023 =
* Fix: Escaping issues in Shortcodes
* Fix: Replace deprecated function calls
* Improvements: Support for WordPress 6.x.x
* Improvements: Many code improvements

= 2.3.6 - April 06, 2021 =
* New: Update FontAwesome library to v5.15.3
* Fix: Multiple shortcode output
* Improvements: Support for WordPress 5.7

= 2.3.5 - October 10, 2020 =
* Improve deprecated message formatting for Instagram widget and fix trailing comma error

= 2.3.4 - October 09, 2020 =
* Fix Stag shortcodes inserter error at Classic editor

= 2.3.3 - Aug 01, 2020 =
* Fix tweets not showing up at twitter widget
* Deprecate Instagram widget due to changes in Instagram's API

= 2.3.2 - June 22, 2020 =
* Compatible with WordPress 5.4.2
* Replace deprecated contextual help screen issue
* Fix undefined error under widgets

= 2.3.1 - January 11, 2019 =
* Fix broken Twitter API library

= 2.3 - January 5, 2019 =
* Compatibility with WordPress 5.0+
* Update FontAwesome to v5.6.3
* Added REST API support for all custom post types
* Remove deprecate function call to create_function
* Added themes list on settings page
* Fix StagTools popup not opening inside Gutenberg
* Fix JS translation for Classic editor custom buttons

= 2.2.6 - March 16, 2018 =
* Fixed an issue with Instagram widget
* Updated FontAwesome library to v5.0.8

= 2.2.5 - Feb 16, 2018 =
* Updated FontAwesome library to v5.0.6
* Wrap @ in anchor tags in Twitter widget
* Update Dribbble widget to use v2 API
* Fix Font awesome icons in icon buttons
* Replace uses of accent color in stylesheet with css variables with fallback, for better theming

= 2.2.4 - Dec 21, 2017 =
* Fix an issue with Instagram widget returning images with 403 response due to recent change to Instagram

= 2.2.3 - Dec 21, 2017 =
* Updated FontAwesome library to v5.0.2
* Added FontAwesome v4 shim for better fallback

= 2.2.2 - Dec 19, 2017 =
* Fix `[stag_social]` shortcode showing invalid icons since previous update

= 2.2.1 - Dec 18, 2017 =
* Compatible with FontAwesome v5.0.1

= 2.2.0 - Nov 19, 2017 =
* Compatible upto WordPress 4.9+
* Fixed an issue with Instagram widget not working due to public feed not being available any longer.
* Fixed an issue with Dribbble widget not working due to API authentication changes
* Added support for Widgets selective refresh
* Use new Codestag icon for editor button
* Fixed issue with Google Map error showing out of place
* Make use of CSS variables for StagTools' accent color, to easily customize accent colors in theme

= 2.1.3 - Nov 07, 2016 =
* Updated FontAwesome library to v4.7.0

= 2.1.2 - July 21, 2016 =
* Added a new settings for Google Maps API key under Settings > StagTools
* Minor tweak on settings page
* Updated FontAwesome library to v4.6.3

= 2.1.1 - May 02, 2016 =
* Updated - FontAwesome library v4.6.1

= 2.1.0 - February 26, 2016 =
* New - Google map shortcode now supports map type to choose between Roadmap, Satellite, Hybrid, and Terrain
* Tweak - Replaced dropdown fields in Shortcode generator with buttonsets
* Fix - Instagram widget to work with new API
* Fix - Dribbble widget feed URL causing widget to fail
* Fix - Fix an issue with Skype field showing incorrect value due to URL escaping
* Updated - FontAwesome library v4.5.0

= 2.0.1 - August 21, 2014 =
* Fix - PHP constructor method error, introduced in WordPress 4.3
* Fix - Invalid flickr ID error when adding widget, props @ragzor
* Fix - StagTools modal excessive padding in some cases
* Fix - Updated language files
* Updated - FontAwesome library v4.4.0

= 2.0 - July 15, 2014 =
* New - Restyled and simplified font icon selector
* New - Rewritten Twitter widget
* New - Rewritten Instagram widget
* Tweak - Divider shortcode is now merged with default "Horizontal Line" editor button
* Tweak - Intro and Alert shortcodes are now editor styles, as "Formats" in editor
* Tweak - Better widget cache handling
* Tweak - Enqueue styles/scripts depending on widget visibility
* Fixed - Small CSS clearing issue with stag_two_third_last shortcode, props @egifford
* Updated - FontAwesome library v4.3.0

= 1.2.6 - June 23, 2014 =
* Fix - Issue with buttons shortcode generator when no link provided

= 1.2.5 - June 18, 2014 =
* Fix - Twitter widget option storage, works flawlessly
* Fix - Instagram widget image size styles
* Fix - Properly sanitize Instagram username
* Improved - Instagram widget now grabs video thumbnails too

= 1.2.4 - May 22, 2014 =
* New - ``[stag_column]`` shortcode for wrapping the columns
* New - Added ``stag-section`` class to all block level shortcodes
* New - Custom post type "Project" added, better version of portfolios
* Fix - Minor issue with popup modal not resizing properly
* Tweak - Enqeueu FontAwesome stylesheet before StagTools' shortcode styles
* Update - FontAwesome icons updated to v4.1.0, includes 71 new icons
* Improved - FontAwesome icons now use default FontAwesome classes instead of custom
* Improved - Removed redundant code

= 1.2.3 - April 16, 2014 =
* New - Added Compatibility with WordPress 3.9
* New - White color option for button
* Fix - Invalid variables under instagram widget
* Fix - Icon shortcode, vertical alignment
* Tweak - Shortcode generator styles for WordPress 3.9
* Improved - Intro text shortcode
* Improved - Shortcode styles

= 1.2.2 - March 04, 2014 =
* Improved: Instagram Widget, rewritten from base

= 1.2.1 - January 25, 2014 =
* Tweak - Performance tweaks for Google Maps
* Tweak - Twitter widget, fixed an issue with page break when tweets are not retrieved
* Tweak - Added custom post type menu positions and icons
* Tweak - Disable scroll wheel zoom on Google Map
* Tweak - Add default options for portfolio and skills slugs
* Improved - Added inline docs for Portfolio post type
* Improved - Make skill terms filter portfolio items based on skills when clicked
* Fix - Added missing zoom parameter in Google Maps shortcode
* Fix - Custom post type's visibilities
* Fix - Add *google-map* class on Google maps shortcode
* Fix - Fix Team post type title

= 1.2 - January 09, 2014 =
* New - Settings Page UI
* New - Instagram Widget
* New - Social Icons Shortcode
* Fix - Flush rewrite rules on saving settings, when required
* Fix - Make StagTools shortcode window insert content in active editor instead of main editor
* Tweak - Use ``add_theme_support( 'post-type', array( 'portfolio' ) )`` instead of separate theme support check. Where ``portfolio`` is the custom post type
* Tweak - Google Maps Shortcode. Now accepts ``lat``, ``long``, ``width``, ``height``, ``zoom``, ``style`` as arguments
* Tweak - Added optional follow button in twitter widget
* Tweak - Inline documentation
* Tweak - Dribbble shot markup
* Tweak - Backwards compatbility for Portfolio settings
* Tweak - Replace help under settings tab with Contextual help
* And several bug fixes, documentation enhancement and improvements

= 1.1.1 - November 20, 2013 =
* Fix - FontAwesome icon missing class names after upgrading to latest version

= 1.1 - November 15, 2013 =
* New - Compatibility with FontAwesome 4
* New - Insert font icons in buttons
* New - Settings for changing slugs for custom post type ‘portfolio’ and taxonomy ‘skill’
* New - Contextual help screen on settings page
* Fix - Properly resize shortcode modal window width
* Fix - Image/Video Media frame title
* Fix - Check if there are no sidebar created via Stag Custom Sidebars
* Tweak - Compatibility with the plugin [Stag Custom Sidebars](https://wordpress.org/plugins/stag-custom-sidebars/)
* Tweak - Refractored code
* Tweak - Inline plugin documentation

= 1.0.8 - October 02, 2013 =
* Fix - Twitter widget incorrect links
* New - Revisions support for portfolio

= 1.0.7 - September 14, 2013 =
* Fix - Disable Portfolio Archives

= 1.0.6 - September 11, 2013 =
* New - Modify Portfolio post type label, slug and rewrites
* New - Attach ``stagtools`` body class to frontend
* Fix - Frontend shortcode stylesheet on the top of theme stylesheet
* Fix - Minor issues with intro and button shortcode styling

= 1.0.5 - September 08, 2013 =
* Fix - Portfolio taxonomy skills archives

= 1.0.4 - September 07, 2013 =
* New - Google Map Shortcode
* Fix - Flickr Widget disabled wrapper warnings

= 1.0.3 - September 01, 2013 =
* Fix - Admin font icon rendering issue

= 1.0.2 - September 01, 2013 =
* Fix - FontAwesome conflict with other classes using icon-

= 1.0.1 - Auguest 16, 2013 =
* Fix - Theme support check

= 1.0 - July 27, 2013 =
* Initial Release

== Upgrade Notice ==

= 2.3.1 =
* Fixes broken twitter library in last update

= 2.3 =
* Adds compatibility with WordPress 5.0+. Includes various fixes.

= 2.2.3 =
Updated to FontAwesome v5.0.2

= 2.2.1 =
Adds compatibility with FontAwesome v5.0.1

= 2.1.2 =
If you're using Google Maps shortcode anywhere on your site. Please make sure fill-in the API key for Google Maps under Settings > StagTools > API key.

= 1.2.6 =
Fixes an issue with buttons shortcodes not showing icons in some cases.

= 1.2.5 =
Includes fixes and improvements for Twitter and Instagram widget.

= 1.2.3 =
Adds compatbility with WordPress 3.9. 1 beta tester was killed during this update.

= 1.2.2 =
If you're using instagram widget, it's required to update widget settings.

= 1.2 =
This update requires update to all Google Map shortcodes.
