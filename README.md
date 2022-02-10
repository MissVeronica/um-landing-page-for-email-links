# Ultimate Member Landing Page for Email Links

This is a quick fix for the bug report https://github.com/ultimatemember/ultimatemember/issues/845

and updated with this bug report https://github.com/ultimatemember/ultimatemember/issues/952

## Installation

Create a WP Page with the slug: um-landing-page

Page name can be different from "UM Landing Page" if you have other requirements.

On this page insert only the shortcode: [um-landing-page]

Add the Landing Page slug to your list of "Exclude the following URLs" at UM -> Settings -> Access -> Restriction Content 

Add the source.php file from this posting https://github.com/MissVeronica/um-landing-page-for-email-links/blob/main/source.php to your child-theme functions.php file

or use the "Code Snippets" plugin https://wordpress.org/plugins/code-snippets/

## Solution

This code snippet will replace the "Account Activation" and "Password Reset" links from the emails being sent to the users. A hook in WordPress wp_mail is used for the replacement. The "Account Activation" link User ID is replaced by the User Login name.

The email links will now point to the "um-landing-page" but still with the original hashes and for the "Password Reset" the User ID as a GET parameter.

The Landing Page is created by the shortcode as a simple page with instructions, link to your blog page, email and a button. The UM generated hash and User ID from the "Password Reset" email are added as hidden form fields. The "Account Activation" hash is used for finding the User ID which is used to verify against the User Login name. If failure there is no Activation button link presented but a hint that the link is invalid or outdated, which is the case if link being used second time.

Clicking the button user will be sending the hash and User ID values to UM for "Account Verification" (via a form POST) and "Password Reset" (via a form GET) to the respective UM pages, where the hashes and User ID's are verified by current UM setup.

You may localize the templates within the source code but keep the php code as is.

## Note about caching and firewalls
You may also have a Web Hosting or WP Plugin caching issue.

https://docs.ultimatemember.com/article/1595-caching-problems

Another possible issue is the Firewall mod_security settings, ask your Web Hosting Support or look at your cPanel.

