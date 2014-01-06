API
===

All of the FlatTurtle turtles in your database can be added, changed and removed using ControlBay. 

Unauthenticated requests
------------------------
* /auth/`{}`

  TODO

* /turtles
  
  `GET` List the available turtles with their individual configuration options

* /option/?name=`{option_name}`

  `GET` Get information about a specific option 

Authenticated requests
----------------------

* /`{infoscreen_alias}`/panes

  `GET` Get all registered panes for a specific infoscreen
  
  `PUT` Add a pane to the given infoscreen
  
  
*  /`{infoscreen_alias}`/panes/order/`{pane_id}`

  `POST` Update the order for the specified pane on the specified screen
  
  Payload:
  * `order`: integer specifying the new order
  
* /`{infoscreen_alias}`/panes/`{pane_id}`

* /`{infoscreen_alias}`/turtles

* /`{infoscreen_alias}`/turtles/order/`{turtle_id}`

* /`{infoscreen_alias}`/turtles/`{turtle_id}`

* /`{infoscreen_alias}`/jobs

* /`{infoscreen_alias}`/plugins/

* /`{infoscreen_alias}`/plugins/`{}`/`{}`/

* /`{infoscreen_alias}`/plugins/`{}`/

* /`{infoscreen_alias}`.json

  Returns the DISCS json for that infoscreen

* /`{infoscreen_alias}`
