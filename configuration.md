# Configuration  

***  

This is a list of all configuration options found in the interface between lines 36 to 56.  

#$twitch_DebugLevels

| Level | Description |
| ---- | ------------ |
| FINE | This level of output only passes function initialization to the output functions defined |
| FINER | This level of output passes function init and and variable transformations or checks |
| FINEST | This level of output passes everything __EXCEPT__ the raw returns from cURL returns or iteration |
| ALL | This level of output passes ALL output to the output functions, including all raw returns.  This is __NOT__ recommended due to how large some returns are |