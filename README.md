Controlbay
=========
Controlbay makes use of the [Codeigniter framework](http://codeigniter.com/)
Writing started on the 2nd of July, 2012, during the [iRail summer of code](http://hello.irail.be/irail-summer-of-code/)[(#iSoc12)](https://twitter.com/search/realtime/iSoc12).

* [Glenn Bostoen](http://twitter.com/glennbostoen)
* [Jens Segers](http://twitter.com/jenssegers) (project leader)
* [Nik Torfs](http://twitter.com/ntorfs)

Rewrite by

* [Michiel Vancoillie](http://twitter.com/ntynmichiel) (project leader)

This server provides a secure and authenticated way of translating http messages to XMPP. So this can be seen as a middle man for [InfoScreenController](https://github.com/FlatTurtle/InfoScreenController), [MyTurtle](https://github.com/FlatTurtle/MyTurtle) and [backendAdmin](https://github.com/FlatTurtle/backendAdmin).

Database settings should be set up in config/database.php.
More info about the database can be found here: [DBStructure](https://github.com/FlatTurtle/DBStructure)

Extra functionality for the screens can be added in controllers/plugin. Just look at one of the plugins because it's pretty straightforward.


Dependencies
============

PHP version 5.1.6 or newer.
Current supported databases are MySQL (4.1+), MySQLi, MS SQL, Postgres, Oracle, SQLite, and ODBC.

Copyright and license
=====================

© 2012 - Flatturtle
