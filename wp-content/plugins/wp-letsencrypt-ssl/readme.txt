=== WP Encryption - One Click single / wildcard Free SSL certificate & force HTTPS ===
Contributors: gowebsmarty, freemius
Donate Link: https://paypal.me/gowebsmarty
Tags: ssl,lets encrypt,ssl certificate,free ssl,https,force ssl,insecure content
Requires at least: 4.2
License: GPL3
Tested up to: 5.3.2
Requires PHP: 5.4
Stable tag: 4.0.0

Generate free SSL certificate for WordPress site in One Click and allows you to force HTTPS / SSL with insecure content, mixed content fixer.

== Description ==

Generate free single domain / Wildcard SSL with One Click for your WordPress site and allows you to force HTTPS / SSL with insecure content, mixed content fixer.

Secure your WordPress site with free SSL certificate provided by [Let's Encrypt](https://letsencrypt.com). [WP Encryption](https://gowebsmarty.com/product/wp-encryption-pro/?utm_source=wordpress&utm_medium=description&utm_campaign=wpencryption) plugin registers your site, verifies your domain, generates SSL certificate for your site in simple mouse clicks without the need of any technical knowledge.

`NOTE: This plugin doesn't support Windows server`

== v4.0.0 ==

Renamed plugin name from **WP LetsEncrypt** to **WP Encryption** to avoid Users from being confused as this plugin is offered by Let's Encrypt.

== 15000+ SSL certificates generated with one click & 2500+ PRO users ==

https://youtu.be/KQ2HYtplPEk

= REQUIREMENTS =
PHP 5.4 & above, Linux hosting, OpenSSL, cPanel or SSH, allow_url_fopen should be enabled.

== FREE Features ==
1. Automatic HTTP based domain verification

2. One click SSL certificate generation

3. Download certificates

4. Follow very simple tutorial to install SSL certificate on your cPanel

5. (Optional) Running WordPress on a specialized VPS/Dedicated server without cPanel? You can download the generated cert files easily via our plugin page and install it on your server specifying the certificate paths in your [apache](https://www.thesslstore.in/serverssl/apache-ssl-installation-for-apache.aspx) or [nginx](https://www.thesslstore.com/knowledgebase/ssl-install/nginx-ssl-installation/) server config file. Sounds too much technical? No worries, Our Professional team can handle the one time setup easily if you upgrade to *PRO* version.

== PRO Features ==

https://youtu.be/I_5lIm8R3-A

1. Wildcard SSL support

2. Automatic DNS based domain verification for Wildcard SSL installation (DNS should be managed by cPanel or Godaddy).

3. Auto renewal of SSL certificate every 90 days before the expiry date.

4. Automated DNS verification in case of HTTP verification fail (DNS should be managed by cPanel or Godaddy).

5. Top notch one to one priority support (We will setup SSL for your site one or the other way)

6. One time free manual setup for sites with NO cPanel (requires Linux based Apache/Nginx server with root shell access).

**NOTE:** Requires either cPanel or Shell(SSH) access for all PRO features to work perfectly.

[Buy Premium](https://gowebsmarty.com/product/wp-encryption-pro/?utm_source=wordpress&utm_medium=premiumfeatures&utm_campaign=wpencryption)

= Switch to HTTPS in seconds =
* Free domain validated (DV) certificates are provided by Let's Encrypt (A non profit Global certificate Authority).

* With a simple email address input and an one click button, WP Encryption plugin takes care of all the aspects of domain registration, automatic domain verification and SSL certificate generation within seconds while you sit and relax.

= Why does My WordPress site need SSL? =
1. Major search engines like Google ranks SSL enabled sites higher compared to non SSL sites. Thus bringing more organic traffic for your site.

2. Data transmission between server and visitor are securely encrypted on a SSL site thus avoiding any data hijacks in-between the transmission(Ex: personal information, credit card information).

3. Google chrome shows non-SSL sites as 'insecure', bringing a feel of insecurity in website visitors.

4. HTTPS green padlock represents symbol of trust, authenticity and security.

== Translations ==

Many thanks to the generous efforts of our translators:

* Spanish (es_ES) - [the Spanish translation team](https://translate.wordpress.org/locale/es/default/wp-plugins/wp-letsencrypt-ssl/)
* Spanish (es_VE) - [the Venezuelan translation team](https://translate.wordpress.org/locale/es-ve/default/wp-plugins/wp-letsencrypt-ssl/)
* Swedish (sv_SE) - [the Swedish translation team](https://translate.wordpress.org/locale/sv/default/wp-plugins/wp-letsencrypt-ssl/)
* Spanish (es_MX) - [the Mexican translation team](https://translate.wordpress.org/locale/es-mx/default/wp-plugins/wp-letsencrypt-ssl/)
* Croatian (hr) - [the Croatian translation team](https://translate.wordpress.org/locale/hr/default/wp-plugins/wp-letsencrypt-ssl/)
* German (de_DE) - [the German translation team](https://translate.wordpress.org/locale/de/default/wp-plugins/wp-letsencrypt-ssl/)

If you would like to translate to your language, [Feel free to sign up and start translating!](https://translate.wordpress.org/projects/wp-plugins/wp-letsencrypt-ssl/)

= Get Involved =

* Rate Plugin – If you find this plugin useful, please leave a [positive review](https://wordpress.org/support/plugin/wp-letsencrypt-ssl/reviews/).
* Submit a Bug – If you find any issue, please submit a bug via support forum.

== Installation ==	
1. Make a backup of your website and database
2. Download the plugin
3. Upload the plugin to the wp-content/plugins directory,
4. Go to “plugins” in your WordPress admin, then click activate.
5. You will now see WP Encryption option on your left navigation bar. Click on it and follow the step by step guide.

== Frequently Asked Questions ==

= Does installing the plugin will instantly turn my site https? =
Installing SSL certificate is a server side process and not as simple as installing a ready widget and using it instantly. You will have to follow some simple steps to install SSL for your WordPress site. Our plugin acts like a tool to generate and install SSL for your WordPress site. On FREE version of plugin - You should manually go through the SSL certificate installation process following the simple video tutorial. Whereas, the SSL certificates are easily generated by our plugin by running a simple SSL generation form.

= How long are the SSL certificates valid =
Free SSL certificates provided by Let's Encrypt are valid for 90 days.

= How do I renew SSL certificate =
You can follow the same initial process of SSL certificate generation to renew the certificates.

= Do I need any technical knowledge to use this plugin =
Downloading and installing the generated SSL certificates on cPanel is very easy and can be done without any technical knowledge.

= How to install SSL for both www & non-www version of my domain? =
First of all, Please make sure you can access your site with and without www. Otherwise you will be not able to complete domain verification for both www & non-www together. Open **WP Encryption** page with **&includewww=1** appended to end of the URL (Ex: **/wp-admin/admin.php?page=wp_encryption&includewww=1**) and run the SSL form with **"Generate SSL for both www & non-www"** option checked.

= Do you support Wildcard SSL? =
Wildcard support is included with Pro version

= Receiving "Too many requests" error =
Let's Encrypt API has rate limits so please try after few hours if you receive this error.

= Is your plugin safe to use =
Our plugin is open source. Feel free to download and inspect it before installing.

= What if HTTP domain verification failed =
You can follow simple video tutorial provided in plugin FAQ interface to manually add DNS records for your domain and complete the domain verification.

= How to revert back to HTTP in case of force HTTPS failure? =
Please follow the revert back instructions given in [support forum](https://wordpress.org/support/topic/locked-out-unable-to-access-site-after-forcing-https-2/).

= I am getting some errors during SSL installation =
Feel free to open a ticket in this plugin support form and we will try our best to resolve your issue.

== Disclaimer ==

Security is an important subject regarding SSL/TLS certificates, of course. It is obvious that your private key, stored on your web server, should never be accessible from the web. When the plugin created the keys directory for the first time, it will store a .htaccess file in this directory, denying all visitors. Always make sure yourself your keys aren't accessible from the web! We are in no way responsible if your private keys go public. If this does happen, the easiest solution is to check folder permissions on your server and make sure public access is forbidden for root folders. Next, create a new certificate.

== Screenshots ==
1. Generate and Install SSL certificate while Agreeing to TOS
2. SSL installation successfull message
3. Change your WordPress & Site url to HTTPS://
4. Force SSL / HTTPS throughout entire site

== Changelog ==

= 4.0.0 =
* Renamed plugin name from **WP LetsEncrypt** to **WP Encryption** to avoid Users from being confused as this plugin is offered by Let's Encrypt.

= 3.4.0 =
* PRO - WildCard DNS automation for DNS managed by Godaddy
* Improved - http challenge code rectification

= 3.3.8 =
* Fixed - error fix for 3.3.7

= 3.3.7 =
* Improved - Http challenge code rectification
* Added - FAQ question for www & non-www SSL

= 3.3.6 =
* Modified - As a backup option, no more SSL forcing for admin
* Modified - Auto renew 20 days before expiry
* Fixed - function checks
* Fixed - minor css

= 3.3.3 =
* Fixed - Plugin fully translatable
* Fixed - Translation POT file
* Improved - Several code optimizations
* Added - Activator & deactivator

= 3.3.1 =
* Fixed - Important bug fix for 3.3.0
* Please UPDATE

= 3.3.0 =
* Fixed - some of the warnings, notices.
* Added - ability to revert back to http in case of force HTTPS failure.
* Added - clean http challenge files after success
* Added - Generate SSL for both www + non-www version of domain
* Improved - several wording improvements, email notifications
* Fixed - important functions & classes

= 3.2.0 =
* Important - Fixed a function for Premium users. Please Update.
* Improved - Domain verification
* Added - Faq question

= 3.0.0 =
* Fixed - check SSL before forcing https
* Updated - Freemius SDK
* Added - Email notification upon successful certificate generation
* Fixed - Workarounds for validations
* Updated - Video tutorials
* Removed - Unnecessary htaccess override

= 2.5.5 =
* Fixed - error notice
* Fixed - Force SSL feature blocking site access

= 2.5.3 =
* Removed - forcing of URL to https
* Added - noscript detection
* Fixed - text domain fix

= 2.5.1 =
* Improved - log messages
* Modified - Added support for www based WordPress sites
* PRO - Special log messages for PRO users

= 2.5.0 =
* Brand New plugin page design
* Improved automation
* Cleaner layout & non-confusing SSL generator

= 2.4.0 =
* FIXED - Conflict with other plugin & minor warnings
* FREE - One click enable HTTPS soon after SSL installation success
* FREE - Fully automated HTTP validation + ability to manually verify through DNS validation in case of HTTP validation fail.
* PRO - Fully automated DNS fallback verification for cPanel sites in case of HTTP verification Fail.
* PRO - Fully automated DNS verification based registration and DNS verification based renewal for Wildcard SSL [Your domain DNS must be managed by cPanel]
* PRO - For non cPanel sites - We are offering one time installation support for configuring Apache/Nginx server to use SSL certificates generated by WP Encryption [without additional cost]

= 1.0.0 =
* Initial commit