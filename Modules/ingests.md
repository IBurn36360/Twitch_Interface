# Authentication  

***  

This call allows you to pull information about the ingest servers for Twitch.

| Call | Description |
| ---- | ----------- |
| [getIngests()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/ingests.md#getingests) | Grabs All currently registered Ingest servers and some base stats |

***

## `getIngests()`  

Searches Twitch's list of all games for the matching string.

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$ingests = $interface->getingests();
```

### Example Return

If successful:

```json
{
    "EU: Amsterdam, NL": {
      "name": "EU: Amsterdam, NL" ,
      "default": false ,
      "_id": 24 ,
      "url_template": "rtmp://live-ams.twitch.tv/app/{stream_key}",
      "availability":1.0
    },
    ...
}
```

If service was unavailable:

```json
{

}
```
