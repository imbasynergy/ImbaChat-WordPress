=== ImbaChat ===
Contributors: imbasynergy
Donate link: paypal.me/TrapenokVictor
Tags: chat, chat plugin, chat widget, wordpress chat plugin, buddypress chat plugin, sweetdate chat plugin, WCFM chat plugin, direct messaging, live chat, group chat, member chat, private messaging system, floating chat widget
Requires at least: 4.6
Tested up to: 5.5
Stable tag: 5.4.2
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.apache.org/licenses/

== Description ==

This is free messenger plugin for Wordpress CMS. It suits for social networking websites, dating websites and any other communities where important to give users a convenient mode of communication.

It allows to add chat widget between users on your website for free. Сombination of a messenger and live chat on your WP website. Learn more about the plugin [here](https://imbachat.com).

https://www.youtube.com/watch?v=oNtOn5YuW5o&t=16s

**Features:**

* Full integration with the user base of your website
* Live chat for online support service
* Single authorisation mechanism in the chat and on the website (users don't need to sign up twice)
* Chat widget style settings
* Private chat between users
* Sending pictures, geolocations and files
* Chat rooms with unlimited number of participants
* Video chat and voice chat
* Emoji
* Real time message delivery
* It does not load your server (The chat widget uses project servers imbachat.com)
* You can use it on shared hosting
* It continues correct working even without the Internet (Your messages will be sent as soon the Internet appears)


== Installation ==

1. Go to the admin panel of your site. Open the menu item Plugins → Download plugin. In the search line, enter the name of the plugin - ImbaChat. Install the plugin.
2. Register on the site [imbachat.com](https://imbachat.com) and create a widget.
3. On the next page in the "Host" area write your site URL without http:// (for example: your-site-domain-url.com)
4. Finally, go to Word-Press admin panel -> "Settings" -> "ImbaChat Settings" and fill all fields with information from section "Data by security" at your widget′s settings panel at ImbaChat.com. Your "Widget ID" is here, after "Widget setting #".
5. Also you can integrate our plugin with Buddypress and WCFM.
For that you need to fill correct checkbox at your admin panel -> "Settings" -> "ImbaChat Settings" "BuddyPress integration" or "Market integration".

Plugin hook:
- ```<?php do_action('imbachat'); ?>``` - inserts JavaScript code at the end of html code with function wp_footer.
You don't need to use hook if you 

== Frequently Asked Questions ==

=Can I use this plugin on a Shared hosting?=
Yes, our plugin is available even on shared hosting.

=If my website does not have login mechanism, then will i be able to use imbachat?=
At the moment there is no such function. Also this is pointless, because only authorized users can chat with each other.

=Will the chat load my server?=
The chat on Saas version is connected as a widget and therefore does not load the server. All the load and data processing takes place on our servers, they can withstand a fairly heavy load, so you don't have to worry about the load.

=What are the server requirements?=
There is no special requirements for the Saas version. But If you want to install the Pro version, your server must have at least 2 GB of RAM.


== Screenshots ==

1. Chat on the GisAuto website
2. Style settings
3. Chat on Buddypress
4. Chat on Wordpress

== Changelog ==

= 2.1 =
* Сompatibility with the latest WP version
* Widget appearance settings
* Integration with BuddyPress, Sweet Date and WCFM Marketplace
* Simplified installation process
 
== Upgrade Notice ==
 
= 2.1 =


== Links: ==
[Demo chat on the Wordpress website](http://wordpress.imbachat.com/)

[Demo chat on the Buddypress website](http://buddypress.imbachat.com/)

[Demo chat on the Sweet Date website](http://sweet.imbachat.com/)

[Demo chat on the WCFM Marketplace website](http://market.imbachat.com/)

[Repository with plugin for WordPress CMS](https://github.com/imbasynergy/ImbaChat-WordPressCMS)

[Open source code for demo site](https://github.com/imbasynergy/ImbaChat-WordPressCMS-demo)

[Technical support](http://imbachat.com/help)
