=== BuddyForms Remote ===
Contributors: svenl77, konradS, BuddyForms, themekraft
Tags: buddypress, user, members, profiles, custom post types, taxonomy, frontend posting, frontend editing, remote, iframe, embed, embedded, toggle
Requires at least: 3.9
Tested up to: 6.1.1
Stable tag: 1.0.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

BuddyForms Remote provides your forms where ever they are needed! Use BuddyForms forms on any website (WP and NON WP sites) in iFrames or as Toggle.


== Description ==

A Toggle is the most advanced and user friendly why of writing.
It is used by many help services to give users a quick access to support and get in contact.
It's used by many famous mail providers like Google Inbox to write mails.
And it's a super comfortable way to encounter your user to write.

On the main site or on any site - the Toggle embed works everywhere with just one line of code. It's super easy to use ;)

<h4>Toggle:</h4>
You can use the Toggle out of the box. Just enable "Remote Forms" in the "Form Builder" and generate your embed code. Use it everywhere.

<h4>iFrame:</h4>
Use the endpoints generated for the Toggle for any other integration like Facebook or any site where you are able to use iFrames.
If remote is enabled you will have two new endpoint views for the form and your post listings.

<h4>The Endpoints</h4>
1. View the logged in users posts
2. View the form to create or edit posts

<h4>How it Works</h4>
If you generate the embed code you actually generate one line of JS
This line of JS does all the magic. It loads all needed code and generates the Toggle without any further step needed from your site.
Just embed the embed code where ever you need it and you are done.

If you use the endpoints in iframes, a special template is called without header and footer. Just your form is delivered. This makes it possible to use your form or post lists without loading your complete Theme.

<h4>Short Video Showcase the Plugin!</h4>
[youtube https://youtu.be/2qbkzhHfu_M]

<h4>Dependencies</h4>
This is the BuddyForms Remote extension. You need the BuddyForms plugin installed for the plugin to work. <a href="http://buddyforms.com" target="_blank">Get BuddyForms now!</a>


== Documentation & Support ==

<h4>Extensive Documentation and Support</h4>

All code is neat, clean and well documented (inline as well as in the documentation).

The BuddyForms documentation with many how-to’s is following now!

If you still get stuck somewhere, our support gets you back on the right track.
You can find all help buttons in your BuddyForms Settings Panel in your WP Dashboard!

== Installation ==

You can download and install BuddyForms Remote by using the built in WordPress plugin installer. If you download BuddyForms Remote manually,
make sure it is uploaded to "/wp-content/plugins/buddyforms-remote/".

Activate BuddyPress Remote in the 'Plugins' admin panel using the 'Activate' link. If you're using WordPress Multisite, you can optionally activate BuddyForms Remote network wide.

== Frequently Asked Questions ==

You need the BuddyForms plugin installed for the plugin to work.
<a href="http://buddyforms.com" target="_blank">Get BuddyForms now!</a>

== Screenshots ==

1. **Form Builder Settings** - The Form Builder Metabox enable remote and generate the embed code
2. **New Form Endpoints** - Display the form or pots listings in iframe without loading your theme

== Changelog ==
= 1.0.8 - 16 Jan 2023 =
* Enabled trial version.
* Updated first path after activation.
* Tested up to Wordpress 6.1.1

= 1.0.7 - 04 Oct 2022 =
* Fixed issue with plugin download url

= 1.0.6 - 22 Sep 2022 =
* Switching to paid version
* Tested up to WordPress 6.0.2

= 1.0.5 - Mar. 03 2019 =
* Freemius SDK Update

= 1.0.4 =
Added Freemius Integration

= 1.0.3 =
Fixed and issue with the dependencies check. The function tgmpa does not accepted an empty array.

= 1.0.2 =
Add dependencies management with tgm

= 1.0.1 =
Spelling correction
Create new functions to show hide metaboxes
Work on the conditionals admin ui
Add postbox_classes to make the postbox visible.
Use buddyforms_display_field_group_table to display options
Spelling correction

= 1.0 =
final 1.0 version
