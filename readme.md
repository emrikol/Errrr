# Errrr 
**Contributors:** emrikol  
**Tags:** error logging, errors  
**Donate link:** http://wordpressfoundation.org/donate/  
**Requires at least:** 4.8  
**Tested up to:** 4.8  
**License:** GPL3  

Offers a remote endpoint to log real time PHP errors, for hosts that don't offer shell access and/or the ability to `tail` log files.


## Description 

While there are ways to capture logging for more restrictive hosts, such as using [`WP_DEBUG_LOG`](https://codex.wordpress.org/Debugging_in_WordPress#WP_DEBUG_LOG), it can be a hassle having to download and open the log file every time there's a new line.

Errrr allows the site to capture standard PHP error output (minus `error_log()`) and send it to a remote site where it can be used with `tail` to monitor real time PHP errors.

Since `error_log()` isn't captured, there is a helper function called `errrr_log()` that can be used instead to send arbitrary messages to the remote error log.

_**NOTE:** This is a very insecure setup, please do not use any of this for a public or production site!_

The setup is purposely very manual to make sure you know what you're doing.


## Installation 


# On the Errrr endpoint site 

1. Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.


# On the Errrr site to debug 

1. Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

2. Edit your `wp-config.php` file to `include()` the Errrr code and set the remote URL:

```php
/* Begin Errrr */
if ( file_exists( 'wp-content/plugins/Errrr/inc/err-wp-config.inc.php' ) ) {
	if ( ! defined( 'WP_DEBUG' ) ) {
		define( 'WP_DEBUG', true );
	}
	define( 'ERRRR_REMOTE', 'https://example.com/wp-json/webhooks/v1/errrr' )
	require_once( 'wp-content/plugins/Errrr/inc/err-wp-config.inc.php' );
}
/* End Errrr */
```


## Changelog 


### 1.0.0 

First Version
