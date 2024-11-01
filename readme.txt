=== WP Talroo ===
Contributors: boybawang
Tags: jobs2careers, talroo, api, monetize, job, board, publisher, partner
Requires at least: 3.0.1
Tested up to: 5.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily integrate WP Talroo jobs into your site and start making money. Great for niche sites too.

== Description ==

WP Talroo is a lightweight plugin that displays jobs from Talroo's publisher solutions on your site (via their API).

Features:

* Lightweight plugin with minimal configuration needed
* Great for niche sites
* Responsive

Requirements:

* Talroo API Key is required. This can be obtained [here](https://www.talroo.com/partners/job-publishers/)
* Talroo may serve a first-party tracking cookie to each user viewing the job site.
* The WP Talroo plugin will connect to http://www.geoplugin.net for geolocation.

== Installation ==

1. Upload ‘WP Talroo' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In the settings section, include your publisher ID and password, agree to include Talroo's attribution as required by their Terms Of Service, and select the page for which to display jobs.

== Frequently Asked Questions ==

See the FAQ section on [SkipTheDrive](https://www.skipthedrive.com/wp-talroo-plugin/).

== Screenshots ==

1. Job results
2. Advanced search
3. Publisher and page settings
4. Job search and display settings

== Changelog ==

= 2.4 =

* Renaming plugin to WP Talroo

= 2.3 =

* Support for updated HTTPS API call

= 2.2.2 =

* Minor tweaks with styling on advanced form

= 2.2.1 =

* Fixed styling with text label for advanced form and alignment of basic form when collapsed

= 2.2 =

* Removed dependency on Jobs2Careers’ JavaScript function. Links to jobs will no longer be invoked via JavaScript.

= 2.1.1 =

* Fixed styling on advanced search form.

= 2.1 =

* Changed GeoPlugin calls to display Austin, TX as default if unable to receive location info.

= 2.0 =

* Added ability to select the number of jobs results to return for each page.

= 1.5 =

* Removed global variable for retrieving pages (since it was conflicting with multi-site installations) and replaced with WordPress’ get_pages() function.

= 1.4.3 =

* Added a solid border to submit button so that buttons with a transparent color showed better

= 1.4.2 =

* Fixed output location of error message
* Fixed problem with display in Firefox browser for text input
* Added border on submit form button to fix display issue
* Better spacing between job listings

= 1.4.1 =

* Fixed alignment issues (CSS) for basic and advanced search forms

= 1.4 =

* Added styling version for JS and CSS files

= 1.3 =

* Documentation in admin section regarding possible space in password for newly created API feed
* Fixed styling problems with Jobs2Careers attribution

= 1.2 =

* Changed placeholder text color
* Updated placeholder description in admin section

= 1.1 =

* Support for SSL
* Fixed CSS styling on advanced form

= 1.0 =

* Initial release