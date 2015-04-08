# WP Basix

The WP Basix plugin for WordPress allows users to enable/disable features by way of checkboxes via a dedicated admin menu within the WordPress UI. Currently there are 9 modules, each providing a dedicated function.

Release information:
* Current Version: 1.0.0
* Tested with WordPress: 4.1.1
* Requires: WordPress 3.0 or higher
* Compatible up to: 4.1.1

###Installation

* Place the WP Basix folder into {WordPress}/wp-content/plugins/.
* Activate the WP Basix plugin via 'Plugins' under the WordPress admin UI.

## Modules
###Disable Auto Format

This module simply removes the auto formatting (wpautop) that is applied to the_content(). It is not currently enabled for the_excerpt().

No additional &lt;p&gt; or  &lt;br&gt; tags will be inserted into post content.

###Disable File Editor

This module completely disables the in-built editors. Mostly for security against the casual users so they don't destroy the theme/plugin files. All menu items are removed and the user will not be granted access via the UI - even if they attempt to access the edit-urls directly.

###Disable Visual Editor

This module removes the 'Visual' tab when creating posts via the main admin UI, thus forcing all users to employ the HTML-only editor.

###Enable Clean Login Page

This module simple overrides/adds a little styling to the login page in order to remove the WordPress logo, various links (forgot password, back to blog etc) and also sets the background colour of the page to white.

###Enable Clean Search

This module converts the default search parameter: *?s=term* to the more aesthetically pleasing: */search/term/*

###Enable Featured Image

This module adds a new column to the 'Posts' listing in the admin UI and renders a small 100x100 preview of the Featured Image, associated with that post. If no Featured Image is assigned then a message is shown stating this fact.

###Enable IDs

This module adds a new column to the 'Posts' and 'Pages' listings in the admin UI and shows the internal ID number for the post/page respectively. Useful when developing and designing themes.

###Hide Admin Bar

This module removes the admin bar from the front-end (as seen by users who are logged in). The admin bar is usually found along the top edge of the page and allows some quick-controls to be accessed.

###Remove &lt;HEAD&gt; Clutter

This module strips out various information from the &lt;HEAD&gt; section of front-end pages. Some of the items removed, include:

* Feed Links
* Rel Link
* Version Queries: ?ver=
* WP Generator Info
* WP Shortlinks
* And more...

##Contact

Please send feedback, comments and suggestions to my email address which can be found upon installing the plugin.

Bugs or feature requests/contributions can be done via:

[https://github.com/jjcosgrove/wp-basix/issues](https://github.com/jjcosgrove/wp-basix/issues)

##Authors

* Just me for now.
