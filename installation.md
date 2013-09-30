Installing the interface is as easy as including the file <code>twitch_interface.php</code> (or whatever you have renamed it to) into the execution.  This can be done in 2 ways and both are valid.

```php  
include('root/twitch_interface.php');
require('root/twitch_interface.php');
```

Both methods are viable to include the main file into the script execution, although the require call will stop script execution should the file be read locked or missing.  An include will toss a user level error in these cases.  After the file is in script execution, you need only follow the steps listed in [configuration](https://github.com/IBurn36360/Twitch_Interface/blob/master/configuration.md).
