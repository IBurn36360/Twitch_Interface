# Ingests

Function | API Alias | Description
-------- | --------- | -----------
[`Ingests::getIngestServers`](#ingestsgetingestservers) | [`/ingests`](#ingestsgetingestservers) | Gets the current status of all publicly available ingest servers


## Ingests::getIngestServers
Gets the current status of all publicly available ingest servers.

### APIAliases
`/ingests`

### Parameters
No parameters are supported by this endpoint.

### Usage
Static
```php
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Ingests;

$ingestServers = Ingests::getIngestServers([], new Configuration([
    'clientID' => 'Your Twitch ClientID'
]));
```

Object
```php
use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Ingests;

$twitchClient = new Twitch(new Configuration([
    'clientID' => 'Your Twitch ClientID',
]));

$ingestServers = $twitchClient->api('/ingests');
```

### Return Example
```json
{
   "ingests": [{
      "_id": 24,
      "availability": 1.0,
      "default": false,
      "name": "EU: Amsterdam, NL",
      "url_template": "rtmp://live-ams.twitch.tv/app/{stream_key}"
   },
      ...
   ]
}
```
