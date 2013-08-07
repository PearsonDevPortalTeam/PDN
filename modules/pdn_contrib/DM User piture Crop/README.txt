
DM User Picture Crop is a Drupal utility module based on 
jQuery that lets you crop your profile images when you upload them.

Installation
------------
1. Install and enable the required Libraries API module (version 2.0 or above)
from http://drupal.org/project/libraries.

2. Download the 3rd party "the jQuery Image Cropping Plugin" library from 
http://deepliquid.com/content/Jcrop_Download.html and extract it to 
a temporary location.

3. Copy the core jCrop library files to your site's library directory.
Typically this means you will create a new directory called
/sites/all/libraries/jquery.jcrop and then copy the CONTENTS of the "js" and 
"css" directories (that you extracted in the previous step) to this directory.
You will end up with /sites/all/libraries/jquery.jcrop/js/jquery.Jcrop.min.js 
and /sites/all/libraries/jquery.jcrop/css/jquery.Jcrop.min.css ... etc.

4. Install and enable this module.

5. Go to Edit account page and 
upload your profile picture using crop functionality. Make sure user 
picture settings have been done already in User settings, 
like picture support is enabled.

Menus
-----
The only menu item is for the settings page.

Settings
--------
The settings page is at Administer >> Configuration >> DM User Picture Crop.

Permissions
-----------
There are no new permissions. The settings page is controlled by the
"administer settings" permission.
