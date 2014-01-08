=== StagTools ===

Contributors: mauryaratan
Donate link: http://codest.ag/st-donate
Tags: widget, icons, retina, shortcodes, themeforest, font-icons, fontawesome, sidebar, social, social media, maps, flickr, instagram, custom post type, codestag, mauryaratan, twitter
Requires at least: 3.5
Tested up to: 3.8
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

StagTools is a powerful plugin to extend functionality to your WordPress themes offering shortcodes, FontAwesome icons and useful widgets.

== Description ==

StagTools powers your WordPress website with some regularly needed shortcodes including buttons, columns, alerts, font icons etc. It also includes several widgets and custom post types (only for Codestag Themes).

**Shortcodes:**

* Alerts
* Buttons ( optionally, with font icons )
* Columns
* Divider / Horizontal Ruler
* Dropcaps
* Intro Text
* Tabs
* Toggle
* Font Icons by [Font Awesome](http://fortawesome.github.io/Font-Awesome/)
* Google Maps with 5 predefined styles
* Custom Sidebars Area ( requires [Stag Custom Sidebars](http://wordpress.org/plugins/stag-custom-sidebars/) plugin )
* Image with CSS3 filters
* Videos ( supports [oEmbeds](http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F) )

**Widgets:** Twitter, Dribbble, Flickr, Instagram

**Custom Post Types:** Portfolio, Slides, Team, Testimonials

= Get Involved =
If you are a developer, you can contribute to the source code on [StagTools Github Repository](https://github.com/mauryaratan/stagtools)

*Checkout our finely tuned WordPress themes over at [Codestag](http://codestag.com).*

== Frequently Asked Questions ==

= What is this plugin and why do I need it? =

The StagTools provides extra functionality to any WordPress theme. It includes shortcode builder, font icons and several widgets along with custom post types (only for Codestag Themes). This plugin is not requirement to use Codestag themes however it extends the theme functionality.

= Can I insert shortcodes manually instead of using shortcode generator? =

Yes; although we have a shortcode builder you can also see a list of [all available shortcodes](https://gist.github.com/mauryaratan/6071262) and use it manually in any supported area.

= Can I use this plugin with other themes? =

The StagTools was developed to work with any WordPress theme as it includes default styling. However, we provide our extra bit of styling to all of our [themes](http://codestag.com) at Codestag.

= Why shortcodes are prefixed with stag_ ? =
Simply to avoid any conflict with other shortcodes on your site enabled via any third-party plugin or theme.

= I love this plugin! Can I contribute? =
Yes you can! Join me on [Github Repository](https://github.com/mauryaratan/stagtools/) :)

== Screenshots ==

1. StagTools widgets will appear in you list of available widgets.
2. Shortcode builder is located on your WordPress editor at very last.
2. All widgets added by StagTools are highlighted.
3. Settings panel for adding twitter oAuth keys.

==Installation==

= Minimum Requirements =

* WordPress 3.5 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater

= Automatic Installation =

1. Log in and navigate to Plugins &rarr; Add New.
2. Type "StagTools" into the Search input and click the "Search Widgets" button.
3. Locate the StagTools in the list of search results and click "Install Now".
4. Click the "Activate Plugin" link at the bottom of the install screen.
5. Navigate to Settings &rarr; StagTools to modify the plugin's settings. The widgets will be available in Appearance &rarr; Widgets.

= Manual Installation =

1. Download the "StagTools" plugin from WordPress.org.
2. Unzip the package and move to your plugins directory.
3. Log into WordPress and navigate to the "Plugins" screen.
4. Locate "StagTools" in the list and click the "Activate" link.
5. Navigate to Settings &rarr; StagTools to learn about the plugin's features. The widgets will be available in Appearance &rarr; Widgets.

==Changelog==

= 1.2 - 01/XX/2014 =
* New - Settins Page UI
* New - Instagram Widget
* New - Social Icons Shortcode
* Fix - Flush rewrite rules on saving settings
* Fix - Make StagTools shortcode window insert content in active editor instead of post editor
* Tweak - Use ``add_theme_support( 'post-type', array( 'portfolio' ) )`` instead of separate theme support check. Where ``portfolio`` is the custom post type
* Tweak - Google Maps Shortcode. Now accepts ``lat``, ``long``, ``width``, ``height``, ``zoom``, ``style`` as arguments.
* Tweak - Added optional follow button in twitter widget
* Tweak - Inline documentation
* Tweak - Dribbble shot markup
* Tweak - Backwards compatbility for Portfolio settings
* Tweak - Replace help under settings tab with Contextual help
* And several bug fixes and improvements

= 1.1.1 - 11/20/2013 =
* Fix - FontAwesome icon missing class names after upgrading to latest version

= 1.1 - 11/15/2013 =
* New - Compatibility with FontAwesome 4
* New - Insert font icons in buttons
* New - Insert font icons in buttons
* New - Settings for changing slugs for custom post type ‘portfolio’ and taxonomy ‘skill’
* New - Contextual help screen on settings page
* Fix - Properly resize shortcode modal window width
* Fix - Image/Video Media frame title
* Fix - Check if there are no sidebar created via Stag Custom Sidebars
* Tweak - Compatibility with the plugin [Stag Custom Sidebars](http://wordpress.org/plugins/stag-custom-sidebars/)
* Tweak - Refractored code
* Tweak - Inline plugin documentation

= 1.0.8 - 10/02/2013 =
* Fix - Twitter widget incorrect links
* New - Revisions support for portfolio

= 1.0.7 - 09/14/2013 =
* Fix - Disable Portfolio Archives

= 1.0.6 - 09/11/2013 =
* New - Modify Portfolio post type label, slug and rewrites
* New - Attach ``stagtools`` body class to frontend
* Fix - Frontend shortcode stylesheet on the top of theme stylesheet
* Fix - Minor issues with intro and button shortcode styling

= 1.0.5 - 09/08/2013 =
* Fix - Portfolio taxonomy skills archives

= 1.0.4 - 09/07/2013 =
* New - Google Map Shortcode
* Fix - Flickr Widget disabled wrapper warnings

= 1.0.3 - 09/01/2013 =
* Fix - Admin font icon rendering issue

= 1.0.2 - 09/01/2013 =
* Fix - FontAwesome conflict with other classes using icon-

= 1.0.1 - 08/16/2013 =
* Fix - Theme support check

= 1.0 - 07/27/2013 =
* Initial Release

== Upgrade Notice ==
