# Ultimate Member Landing Page for Email Links

This is a quick fix for the bug report https://github.com/ultimatemember/ultimatemember/issues/845

# Installation

Create a WP Page with the slug: um-landing-page

On this page insert only the shortcode: [um-landing-page]

Add the Landing Page slug to your list of "Exclude the following URLs" at UM -> Settings -> Access -> Restriction Content 

Add the source.php file from this posting https://github.com/MissVeronica/um-landing-page-for-email-links/blob/main/source.php to your child-theme functions.php file

or use the Code Snippets plugin https://wordpress.org/plugins/code-snippets/

# Solution

This code snippet will replace the "Account Activation" and "Password Reset" links from the emails being sent to the users. A hook in WordPress wp_mail is used for the replacement.

The links will now point to the "um-landing-page" but still with the original hashes and user ids as GET parameters.

The Landing Page is created by the shortcode as a simple page with instructions, link to your blog page, email and a button. The UM generated hash and user id from the email are added as hidden form fields.

Clicking the button user will be sending the hash and user id values to UM for "Account Verification" (via a form POST) and "Password Reset" (via a form GET) to the respective UM pages where the hashes and user ids are verified by current UM setup.

You may localize the templates within the source code but keep the php code as is.

