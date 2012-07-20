Installation
===========

1. Put this forlder in your www root
2. Edit the config files
    - first set the environment in index.php to development|testing|production
    - make a folder in application/config/ and name it the same as the environment
    - copy application/config/config.php to that folder and configure it
    - copy application/config/database.php to that folder and configure it
3. Turn on https on your webserver (if you want things to be secure)

[linux && (possibly) mac)]
4. Check if the jaxl.log file exists in the top-level directory
    - if it doesn't exist: create the file and give it the right permissions
