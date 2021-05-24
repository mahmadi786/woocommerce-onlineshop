# woocommerceWordPress

**IMPORTANT:** Read the information about *Permissions* and *Config* in the *WordPress* section below.

**IMPORTANT:** To understand where your content and code is stored read the section about *Git, MySQL & Docker*.

## Docker

To start the containers:

    docker-compose -f docker-compose-dev.yaml up -d

To stop the containers:

    docker-compose -f docker-compose-dev.yaml stop

## Database dumps

To load a dump (e.g. from the path `./dumps/dump.sql`):

    docker exec -i woocommerce-mysql-service bash -c '/usr/bin/mysql -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE' < ./dumps/dump.sql

To create a dump:

    docker exec -i woocommerce-mysql-service bash -c '/usr/bin/mysqldump -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DATABASE' > ./dumps/`/bin/date +'%Y%m%d%H%M%S'`_dump.sql
``
NOTE: To make auto-deployment work don't forget to update the symlink with 
`ln -s ./dumps/TIMESTAMP_dump.sql ./dumps/dump.sql` (replace `TIMESTAMP_dump.sql` with the actual filename).

## WordPress

### Permissions

To allow file uploads WordPress requires write permissions on `wp-content` - the easiest way to give those permissions 
is to change the ownership of the directory (and the .htaccess file which is as well modified by WordPress):

    docker exec -i woocommerce-wordpress-service bash -c "chown www-data:www-data wp-content .htaccess"

### Config

TODO: DESCRIBE RESTART AND VOLUME BEHAVIOR

TODO: DESCRIBE COPYING WP-CONTENT TO REPOSITORY

### WP CLI

To run WP CLI:

    docker-compose -f docker-compose-dev.yaml run --rm woocommerce-wpcli-service bash

To install WordPress (if this was not done already when the repository was handed over to you):

    wp core install --admin_email=carsten.decker@digitalspital.de --admin_password=ThzIBmibObh55hwp4rksch5b --admin_user=carsten.decker@digitalspital.de --title="Meine Leber und Ich" --url="http://localhost:21750"

**IMPORTANT:** Don't forget to change the password!

To install plugins:

    wp plugin install SLUG --activate

NOTE: Don't forget to change `SLUG` to the corresponding for the plugin. To search plugins and find their slug use e.g. 
`wp plugin search acf`.

If a plugin is not publicly available it is possible to specify a download URL instead of the slug - e.g.

    wp plugin install "https://connect.advancedcustomfields.com/index.php?p=pro&a=download&k=LICENSE_KEY" --activate

NOTE: Don't forget to provide a `LICENSE_KEY` for ACF Pro if installing as shown in the example.

If a plugin is not available via URL as well it can still be added manually by copying the corresponding directory to 
the `woocommerce-wordpress-service/app/wp-content/plugins` directory. 

To activate plugins use:

    wp plugin activate SLUG

To deactivate plugins use:

    wp plugin deactivate SLUG

To uninstall plugins use:

    wp plugin uninstall SLUG

The following plugins have been installed using the CLI (please update README.md when installing further plugins):

    wp plugin install "https://connect.advancedcustomfields.com/index.php?p=pro&a=download&k=LICENSE_KEY" --activate
    wp plugin install classic-editor --activate
    wp plugin install svg-support --activate

Additionally the following plugins have been installed manually:

N/A

To create a plugin - e.g.:

    wp scaffold plugin woocommerce --plugin_name="woocommerce" --activate

To uninstall default themes - e.g.:

    wp theme disable twentysixteen
    wp theme disable twentyseventeen
    wp theme delete twentysixteen
    wp theme delete twentyseventeen

### Updating WordPress

If the containers of the old version were still running, stop them now (see: *To stop the containers*). Afterwards 
delete the containers and the shared volume:

    docker container rm woocommerce-wordpress-service
    docker container rm woocommerce-wpcli-service
    docker volume rm woocommercewordpress_woocommerce-wordpress-volume

To then update WordPress via Docker image, first pull the latest base image - e.g.:

    docker image pull wordpress:5.4.2-php7.4

Afterwards update the `docker-compose-dev.yaml` in regards to the image accordingly (e.g. 
`image: wordpress:5.4.2-php7.4`).

TODO: DESCRIBE RESTART AND VOLUME BEHAVIOR

NOTE: If you have deleted the default themes you will notice that they have been restored with the new WordPress 
version - uninstall them as explained (see: *To uninstall default themes*) or just delete the corresponding directories 
from `wp-content/themes`.

## Git, MySQL & Docker

This WordPress setup stores data in four different locations:

- Git repository
- MySQL database
- Docker volumes
- Docker images

The WordPress application itself resides in a Docker image. This image does only contain the files which are included in
an unmodified default installation of WordPress. The Git repository contains all files which are required for the 
customization and modification of the default installation - i.e. plugins, themes and as well the content. For this 
reason the whole `woocommerce-wordpress-service/app/wp-content` directory is shared as Docker volume to 
the container.

Similar to the default installation of WordPress the MySQL database initially does not contain more than an empty 
database or - after the first time setup - the default Hello World WordPress blog. For this reason the next thing to do 
when running the containers the first time is to load the database dump (see: *To load a dump*). To ensure that no data 
is lost when stopping and restarting containers, Docker stores the MySQL persistence files in a Docker volume.

**IMPORTANT:** As the files in the `wp-content` directory and database belong together they need to be consistent. 
Therefore it is required to make a dump (see: *To create a dump*) of the database and include it in any commit of 
changes to the `wp-content` folder (e.g. when uploading new media, changing the WordPress configuration, managing 
plugins etc.).

Having this kind of separation simplifies migration between different environments significantly. Source code and 
content changes can easily be pulled and pushed via Git between the environments. WordPress updates can be maintained 
via Docker images.

**IMPORTANT:** In cases where it is not possible to agree on a content freeze during development, i.e. when content is 
changed in production while code is modified locally, it is important to understand that if the database changes in one 
environment, these changes need to be merged to the database in the other environment manually. **Due to how the content 
is stored in a WordPress MySQL database this may require a lot of effort!**
