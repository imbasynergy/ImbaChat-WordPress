=== ImbaChat ===
Contributors: imbasynergy
Donate link: paypal.me/TrapenokVictor
Tags: chat, chat plugin, chat widget, wordpress chat plugin
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 4.3
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: http://www.apache.org/licenses/

== Description ==

This is free plugin for integration Wordpress CMS with chat service imbachat.com 
It allows to add chat widget between users on your website for free. 

== Installation ==

1. Install this plugin on your website.
2. Register on the site [imbachat.com] (https://imbachat.com).
3. Go to the [widget page] (https://imbachat.com/admin/widgets) and create yourself a widget.
3. In the process of creating a widget, you will need to select "Integration with WordPress CMS" and follow the instructions.

Plugin hook:
- ```<?php do_action('imbachat'); ?>``` - inserts JavaScript code that initiates chat в конец html кода где присутствует функция wp_footer.

== Frequently Asked Questions ==

=Can I use this plugin on a Shared hosting?=
Yes, our plugin is available even on shared hosting.

=If my website does not have login mechanism, then will i be able to use imbachat?=
At the moment there is no such function. Also this is pointless, because only authorized users can chat with each other.

== Screenshots ==

1. [![Chat demo](http://imbachat.com/storage/app/uploads/public/docs/demo.gif "Chat demo")](https://imbachat.com "Chat demo")

== Changelog ==
This version of the plugin is the first.

== Upgrade Notice ==
The update information is not ready yet.

 Features:

* Full integration with the user base of your website
* Single authorisation mechanism in a chat and on a website (users need not sign up in a chat)
* Chatting between users mano a mano
* Sending pictures
* Sending geolocation
* Sending smiles
* Real time message delivery
* It does not load your server (The chat widget uses project servers imbachat.com)
* You can use it on shared hosting
* It continues correct working even without the Internet (Your messages will be sent as soon the Internet appears)


== Links: ==
[Demo site](http://wordpress.imbachat.com/)

[Repository with plugin for WordPress CMS](https://github.com/imbasynergy/ImbaChat-WordPressCMS)

[Open source code for demo site](https://github.com/imbasynergy/ImbaChat-WordPressCMS-demo)

[Technical support](http://imbachat.com/help)
