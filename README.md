# UM Reduced Member Directory Search
Extension to Ultimate Member for Reducing Member Directory Search excluding all fields with meta_key names containing "email". This will exclude both <code>user_email</code> and <code>secondary_email</code>.
## Settings ##
UM Settings -> General -> Users -> "Additional Fields for reduced Member Directory Search"

Enter additional meta_key names comma separated to exclude from Member Directory Searches.

For example exclude UNIX Timestamps (integer values) from being searched like <code>_um_last_login</code> to reduce DB load.
## Installation ##
1. Download zip file.
2. Upload the zip file as a new plugin to Wordpress
3. Activate the plugin
