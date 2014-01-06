Installation
===========

1. Pull this repository to your documentroot or virtualhost
2. Edit the config files
    - first set the environment in `index.php` to `development|testing|production`
    - make a folder in `application/config/` and give it the samen name as the environment
    - copy `application/config/config.php` to that folder and configure it
    - copy `application/config/database.php` to that folder and configure it

4. [linux & mac] Check if the `jaxl.log` file exists in the top-level directory
    - if it doesn't: create the file and give allow it to be written to
