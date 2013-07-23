IFTTT Channel Extensions
========================

Create your own custom IFTTT recipes/channels/actions/whatever with PHP.

This project started as fork from the [ifttt-webhook](https://github.com/mapkyca/ifttt-webhook) project. I wanted to extend IFTTT functions with code. ifttt-webhook uses a clever dummy Wordpress installation to fool IFTTT to think that it is actually posting new blog posts, when it is actually sending out webhook requests. However I didn't like the boilerplate involved, and would have preferred more cleaner code-based solution. So I refactored the existing code to use local plugins and actions instead of separate webhook requests.

This README, as you can probably see, is quite much in progress. I plan to write a more detailed help when the code reaches a more stable state. However, it is fully functional at the moment, so you are already free to fork and use it. I'm using it at the moment as well. However, consider it as alpha-level software at the moment.

How To Use
----------

To be updated (hopefully) soon.

<!--
1. Change your ifttt.com wordpress server to <http://ifttt.captnemo.in>.
2. You can use any username/password combination you want. ifttt will accept the authentication irrespective of what details you enter here. These details will be passed along by the webhook as well, so that you may use these as your authentication medium, perhaps.
3. Create a recipe in ifttt which would post to your "wordpress channel". In the "Tags" field, use the webhook url that you want to use.

![Connecting to ifttt-webhook](http://i.imgur.com/RA0Jb.png "You can type in any username/password you want")

Any username/password combination will be accepted, and passed through to the webhook url. A blank password is considered valid, but ifttt invalidates a blank username.

![Screenshot of a channel](http://i.imgur.com/5FaU1.png "Sample Channel for use as a webhook")

Make sure that the url you specify accepts POST requests. The url is only picked up from the tags field, and all other fields are passed through to the webhook url.
-->

Plugin support
--------------

To be updated (hopefully) soon.

<!--
This fork supports plugins that allow protocol specific modification of the sent webhook payload in order to match whatever format the endpoint wants.

To do this specify a **plugin:xxxx** category, where **xxxx** is the name of the class (extending "Plugin") and also the name of the .php file in the plugins directory. See the plugins/testplugin.php file for example.
-->

How It Works
------------

To be updated (hopefully) soon.

<!--
ifttt uses wordpress-xmlrpc to communicate with the wordpress blog. We present a fake-xmlrpc interface on the webadress, which causes ifttt to be fooled into thinking of this as a genuine wordpress blog. The only action that ifttt allows for wordpress are posting, which are instead used for powering webhooks. All the other fields (title, description, categories) along with the username/password credentials are passed along by the webhook. Do not use the "Create a photo post" action for wordpress, as ifttt manually adds a `<img>` tag in the description pointing to what url you pass. Its better to pass the url in clear instead (using body/category/title fields).
-->

Why
---

To be updated (hopefully) soon.

<!--
There has been a lot of [call](http://blog.jazzychad.net/2012/08/05/ifttt-needs-webhooks-stat.html) for a ifttt-webhook. I had asked about it pretty early on, but ifttt has yet to create such a channel. It was fun to build and will allow me to hookup ifttt with things like [partychat][pc], [github](gh) and many other awesome services for which ifttt is yet to build a channel. You can build a postmarkapp.com like email-to-webhook service using ifttt alone. Wordpress seems to be the only channel on ifttt that supports custom domains, and hence can be used as a middleware.
-->

Licence
-------

Licenced under GPL. Some portions of the code are from wordpress itself.
