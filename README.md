# Ultimate Member Landing Page for Email Links
This is a quick fix for the bug report https://github.com/ultimatemember/ultimatemember/issues/845

and updated with this bug report https://github.com/ultimatemember/ultimatemember/issues/952

Version 3: 2022-08-16 Supporting both UM upto 2.4.2 and UM 2.5.0 and afterwards

## UM Preparation
1. Create a WP Page with the slug: um-landing-page
2. Page name can be different from "UM Landing Page" if you have other requirements.
3. On this page insert only the shortcode: [um-landing-page]
4. Add the Landing Page slug to your UM Settings -> Access -> Restriction Content -> Exclude the following URLs  and click "Add new URL"

## Solution
This plugin will replace the "Account Activation" and "Password Reset" links from the emails being sent to the users. A hook in WordPress wp_mail is used for the replacement. The "Account Activation" link User ID is replaced by the User Login name.

The email links will now point to the "um-landing-page" but still with the original hashes and for the "Password Reset" the User ID as a GET parameter.

The Landing Page is created by the shortcode as a simple page with instructions, link to your blog page, email and a button. The UM generated hash and User ID from the "Password Reset" email are added as hidden form fields. The "Account Activation" hash is used for finding the User ID which is used to verify against the User Login name. If failure there is no Activation button link presented but a hint that the link is invalid or outdated, which is the case if link being used second time.

Clicking the button user will be sending the hash and User ID values to UM for "Account Verification" (via a form POST) and "Password Reset" (via a form GET) to the respective UM pages, where the hashes and User ID's are verified by current UM setup.

## Note about caching and firewalls
You may also have a Web Hosting or WP Plugin caching issue.

https://docs.ultimatemember.com/article/1595-caching-problems

Another possible issue is the Firewall mod_security settings, ask your Web Hosting Support or look at your cPanel.

## Translations
1. Use the "Say What?" plugin with text domain ultimate-member
2. https://wordpress.org/plugins/say-what/

## Installation
1. Install by downloading the plugin ZIP file and install as a new Plugin, which you upload in WordPress -> Plugins -> Add New -> Upload Plugin.
2. Activate the Plugin: Ultimate Member - Landing Page for Email Links

