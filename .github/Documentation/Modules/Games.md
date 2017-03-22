# Games

Function | API Alias | Description
-------- | --------- | -----------
[`Games::getTopGames`](#gamesgettopgames) | [`/games/top`](#gamesgettopgames) | Gets games sorted by number of current viewers on Twitch, most popular first


## Games::getTopGames
Gets games sorted by number of current viewers on Twitch, most popular first.

### Authentication Scopes
No authentication scopes needed

### API Aliases
`/games/top`

### Parameters
No parameters are supported by this endpoint.

### Usage
Static
```php
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Games;

$ingestServers = Games::getTopGames(new Configuration([
    'clientID' => 'Your Twitch ClientID'
]));
```

Object
```php
use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;

$twitchClient = new Twitch(new Configuration([
    'clientID' => 'Your Twitch ClientID',
]));

$ingestServers = $twitchClient->api('/games/top');
```

### Return Example
```json
{
   "_total": 1157,
   "top": [
      {
         "channels": 953,
         "viewers": 171708,
         "game": {
            "_id": 32399,
            "box": {
               "large": "https://static-cdn.jtvnw.net/ttv-boxart/Counter-Strike:%20Global%20Offensive-272x380.jpg",
               "medium": "https://static-cdn.jtvnw.net/ttv-boxart/Counter-Strike:%20Global%20Offensive-136x190.jpg",
               "small": "https://static-cdn.jtvnw.net/ttv-boxart/Counter-Strike:%20Global%20Offensive-52x72.jpg",
               "template": "https://static-cdn.jtvnw.net/ttv-boxart/Counter-Strike:%20Global%20Offensive-{width}x{height}.jpg"
            },
            "giantbomb_id": 36113,
            "logo": {
               "large": "https://static-cdn.jtvnw.net/ttv-logoart/Counter-Strike:%20Global%20Offensive-240x144.jpg",
               "medium": "https://static-cdn.jtvnw.net/ttv-logoart/Counter-Strike:%20Global%20Offensive-120x72.jpg",
               "small": "https://static-cdn.jtvnw.net/ttv-logoart/Counter-Strike:%20Global%20Offensive-60x36.jpg",
               "template": "https://static-cdn.jtvnw.net/ttv-logoart/Counter-Strike:%20Global%20Offensive-{width}x{height}.jpg"
            },
            "name": "Counter-Strike: Global Offensive",
            "popularity": 170487
         }
      },
      ...
   ]
}
```
