=== Alternative Site Settings ===
Tags: settings, custom records, reviews, contact forms, disable all comments
Requires at least: 5.9
Tested up to: 6.8.2
Stable tag: 1.1.5
Requires PHP: 7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin for managing site settings, including feedback forms, photo gallery, reviews and contacts.

== Description ==

The Alternative Site Settings plugin was originally intended as a starting set of functions for the further development of an individual project. As a result, it was optimized and can be used for small standard projects,
such as a landing page or a business card website.

The plugin contains the following functionality:

* Editing basic settings, such as the name and description of the site, the content of meta tags for the main page, og:image for the main page, copyright information, additional text fields for the header and footer.
* Fields for the contact information section, which is usually located at the bottom of the landing page or in the footer of the site. The contacts section also either includes a map via a shortcode of a third-party plugin, or a static image with an office location diagram is inserted.
* Five ready-made options for custom records - News, Promotions, Documents, Books, Videos. Each recording type is disabled by default.
* Contact forms with a minimum set of seven fields. They satisfy the basic needs when using pop-up feedback forms.
* The "Reviews" section allows you to organize moderated reviews from site visitors.
* It is possible to collapse the top admin panel on the frontend to the upper left corner.
* Version 1.1.0 adds the ability to completely disable comments on the site.

Attention! The plugin is focused on working with classic themes.

== Changelog ==

= 1.1.5 =
For the altss_cform_generator() function, a 7th optional parameter, $height, has been added. It allows you to set the initial height of the editor field. Minimum values: 50 for the newvisual mode and 100 for other modes.

= 1.1.4 =
Fixed a bug with displaying custom placeholder values for each field.

= 1.1.3 =
Minor inaccuracies in the code have been fixed.

= 1.1.2 =
Some other minor inaccuracies in the code have been fixed.

= 1.1.1 =
Minor inaccuracies in the code have been fixed.

= 1.1.0 =
* Added a PHP class, which allows you to disable all the comments on the site. The class is activated if the corresponding Chekbox is checked in the Admin panel.
* Minor changes have been made to the altss_add_editior_field() function, allowing for more flexible control over the connection of the classic editor.
* Fixed errors in HTML code on the Form Sets page in the admin panel.

= 1.0.1 =
* Initial release.

== Frequently Asked Questions ==

= How contact forms are displayed in a theme? =

During plugin activation, the cf-style.tss and cf-script.js files are copied to the “css” and “js” directories located in the “assets” directory of the active theme, respectively. The files do not
overwrite existing files - this is done so that you can set individual styles for forms, unique to each theme. When activating a new theme, the plugin will also have to be activated again.
The display of buttons and forms is carried out either using a shortcode, or by directly registering the buttons in the header file of the theme itself.

Shortcodes:

* [ass_cform_button cfid=1] - Button shortcode
* [ass_cform cfid=1] - Form shortcode

= How are Reviews displayed on the frontend? =

When the plugin is activated, a page type record is created in the posts table with the "reviews" slug and the shortcode [reviews_page] added to the post body.
Also, when activating the plugin, just like in the case of contact forms, the reviews-style.tss and reviews-form.js files are copied to the “css” and “js” directories located in the “assets” directory of the active theme, respectively. Existing files are also not
are overwritten, so you can also set your own review styles unique to each theme. When activating a new theme, the plugin will also have to be activated again.

= How can a developer use this plugin in his individual project? =

In order to start building their project, the developer simply needs to rename the plugin directory, the main plugin file and the plugin prefix (altss_). Attention! This must be done before activating the plugin.

Also, additional tips and recipes for embedding code into the theme, changing functionality, etc. will be published on the page:
https://github.com/tmutstudio/alternative-site-settings/blob/master/recipes_and_tips.md


== Screenshots ==
1. Admin Panel -> ASS Plugin site settings start page -> tab "Main settings".
2. Admin Panel -> ASS Plugin site settings start page -> tab "Main settings" - full page screenshot.
3. Admin Panel -> ASS Plugin site settings start page -> tab "Custom records".
4. Admin Panel -> ASS Plugin site settings start page -> tab "Text blocks".
5. Admin Panel -> ASS Plugin Contact Forms Settings Page -> tab "Messages from forms".
6. Admin Panel -> ASS Plugin Contact Forms Settings Page -> tab "Messages from forms" -> Modal window for viewing message details.
7. Admin Panel -> ASS Plugin Contact Forms Settings Page -> tab "Form sets" - All forms are collapsed.
8. Admin Panel -> ASS Plugin Contact Forms Settings Page -> tab "Form sets" - One of the forms is expanded.
9. Admin Panel -> ASS Plugin Contact Forms Settings Page -> tab "Form sets" -> Modal window with a set of form fields.
10. Admin Panel -> ASS Plugin Contact Forms Settings Page -> tab "Forms fields".
11. Admin Panel -> ASS Plugin REVIES Page.
12. Admin Panel -> ASS Plugin REVIES Page -> Reply to review.
13. Frontend -> REVIES Page (TAMA WP Theme).
