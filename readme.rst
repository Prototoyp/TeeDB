###################
What is TeeDB
###################

TeeDB alias Teeworlds Database is a webapp for the free online muliplayer retro game teeworlds.
The Site allow users to upload selfmade game resourses like skins and maps and share them with the community.

*******************
Server Requirements
*******************

-  PHP version 5.1.6 or newer.

************
Installation
************

It's recommended to use the ant build script to minify and compress the site before uploading.
Open command line interface (win) or terminal (mac) and use the change directory command followed by the directory path.

	cd sites/TeeDB/build/
	
Followed by the commands:

	ant minify
	
The compressed site is now avaible under TeeDB/publish/.
There go in the config folder under application and edit the config.php
( You also can create a config/production folder and save the changes there. )
- Set the base_url to your site domain
- Set a private entcrypt key
- Toogle maintenance mode on/off like you want.

Edit database.php and set your database connection correctly.

Same hosters (most cloud-hosting) require 'Rewrite Base' for URL rewritings, so go to TeeDB/.htaccess and set RewriteBase to root.

After this changes you can upload the site.
You also can do this by ant. Set your ftp-connection under TeeDB/build/config/project.properties and use

	ant ftpupload