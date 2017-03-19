# WebClientAuthentication

A simple PoC for authenticating clients using BYONDs webclient

- Modify the config.php, change the key to something only you know and the IP address to your game server IP
- Modify the DM code so that it points to your webserver
- Modify the byondLinker.php so that it does something useful with the ckey, such as linking an account to the forums.
- Upload the contents of the WebServer folder to a web server which supports PHP
- Setup the server, and link to https://secure.byond.com/login.cgi?login=1;noscript=1;url=http://www.byond.com/play/YOURIP:PORT