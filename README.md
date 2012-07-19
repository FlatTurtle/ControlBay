Controlbay
=========
Controlbay is a rewrite of [ControlModel](https://github.com/FlatTurtle/ControlModel) and makes use of the [Codeigniter framework](http://codeigniter.com/)
Writing started on the 2nd of July, 2012, during the [iRail summer of code](http://hello.irail.be/irail-summer-of-code/)[(#iSoc12)](https://twitter.com/search/realtime/iSoc12).

* [Glenn Bostoen](http://twitter.com/glennbostoen)
* [Jens Segers](http://twitter.com/jenssegers)(project leader)
* [Nik Torfs](http://twitter.com/ntorfs)


This server provides a secure and authenticated way of translating http messages to XMPP. So this can be seen as a middle man for [InfoScreenController](https://github.com/FlatTurtle/InfoScreenController) and [InfoScreen](https://github.com/FlatTurtle/InfoScreen).

Database settings should be set up in config/database.php

Extra functionality for the screens can be added in controllers/plugin. Just look at one of the plugins because it's pretty straightforward.


Dependencies
============

PHP version 5.1.6 or newer.
Current supported databases are MySQL (4.1+), MySQLi, MS SQL, Postgres, Oracle, SQLite, and ODBC.

Copyright and license
=====================

© 2012 - Flatturtle
