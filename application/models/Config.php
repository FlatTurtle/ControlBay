<?php
class Config extends CI_Model{
    static $DB = "";
    static $DB_USER = "a";
    static $DB_PASSWORD = "a";

    static $HOSTNAME = "http://localhost/";
    static $SUBDIR = "ControlModel/";

    static $TITLE = "My Webpage";

    //Caching systems: NoCache or MemCached
    static $CACHE_SYSTEM = "MemCached";
    
}

?>
