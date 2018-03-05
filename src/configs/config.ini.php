;<?php die("Direct access denied."); ?>

;[Config File]

[version]
current = 1.0.0

[general]
url         = ;Domain name
title       = "Loop Sandbox Framework!";Default title display in header


[database]
username 	= ""
passwd 	    = ""
host 		= ""
dbname 		= ""
charset     = "utf8"
timezone    = "America/Manaus"

[preferences]
token = "passcode" ;Secret key used by JWToken

[layout]
logo             = "default.jpg" ;site's default logo, will search in img path in [directories]
template_name    = "default"     ;template_name, will search in template path in [directories]
theme_name       = "default.css" ;theme name, will search in themes path in [directories]
pag_404          = "/error"      ;404 page,in /controller/method format: /error/error_404

[directories]
css        = "/public/css"            ;css to views
js         = "/public/js"             ;js to views
img        = "/public/img"            ;images folder
templates  = "/resources/templates"   ;templates folder
themes     = "/resources/themes"      ;themes folder
content    = "/public/view"           ;views folder