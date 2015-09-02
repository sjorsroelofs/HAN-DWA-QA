## A WordPress plugin created for the course DWA (Develop Web Applications) of the HAN, to create and manage Q&A's.

#### Installation
 - Copy the plugin files to the WordPress plugins folder (usually
   /wp-content/plugins)
 - Navigate to the WordPress backend (wp-admin) and go to "Plugins"
 - Activate the plugin
 - Now go to "Settings » Permalinks"
 - Be sure to set a permalink structure other then the default (for instance /%postname%/)
 - After you've changed the permalink structure, or if it was already correct, hit "Save Changes"
 - The "Q&A's" and "Asked questions" menu items have been added to the admin panel

#### Permalink structure
- Q&A archive: http://site.com/Q&A
- Single Q&A: http://site.com/Q&A/{post-slug}
- Q&A class archive: http://site.com/klas/{category-slug}
