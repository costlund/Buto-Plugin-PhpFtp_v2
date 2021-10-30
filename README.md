# Buto-Plugin-PhpFtp_v2
Ftp plugin using curl.
At the moment this plugin can only list files and folder from an ftp server. 
Curl does not support listing files in multiple folders recursive but this is handled in method list().
Method list() can take a while to run depending on connection and number of folders.

## Widget test
Check out this widget how to use this plugin.
```
type: widget
data:
  plugin: 'php/ftp_v2'
  method: test
  data:
    server: 'ftp.world.com'
    user: '_user_'
    password: '_password_'
    dir: '/_any_/_folder_'
```
## Next move
We should build in file upload, download, delete, rename. Also folder create, delete.