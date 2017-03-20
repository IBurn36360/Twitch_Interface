# Search

Function | API Alias | Description
-------- | --------- | -----------
[`Search::channels`](#searchchannels) | [`/search/channels`](#searchchannels) | Searches for all live streams that match your query comparing on the channel name
[`Search::games`](#searchgames) | [`/search/games`](#searchgames) | Searches for all live streams that match your query comparing on the game being streamed
[`Search::streams`](#searchstreams) | [`/search/streams`](#searchstreams) | Searches for all live streams that match your query comparing on the stream title


## Search::channels
Searches for all live streams that match your query comparing on the channel name.

### API Aliases
`/search/channels`

### Parameters
Parameter|Type|Required|Description
---------|----|--------|-----------
`query`|string|Yes|The string query to search channels against
`limit`|integer|No|The integer limit of streams to pull.  Accepts any number, but Twitch only accepts a maximum of `100`
`offset`|integer|Yes|The integer offset for the query cursor.  Accepts any number within the limitations imposed by Twitch


### Usage
Static
```php
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Search;

$streams = Search::channels(new Configuration([
    'clientID' => 'Your Twitch ClientID'
]), [
    'query' => 'starcraft',
    'limit' => 50,
    'offset' => 25
]);
```

Object
```php
use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;

$twitchClient = new Twitch(new Configuration([
    'clientID' => 'Your Twitch ClientID',
]));

$streams = $twitchClient->api('/search/channels', [
    'query' => 'starcraft',
    'limit' => 50,
    'offset' => 25
]);
```

### Return Example
```json
{
   "_total": 2147,
   "channels": [{
      "_id": 42508152,
      "broadcaster_language": "en",
      "created_at": "2013-04-15T20:39:45.364539Z",
      "display_name": "StarCraft",
      "followers": 149012,
      "game": "StarCraft II",
      "language": "en",
      "logo": "https://static-cdn.jtvnw.net/jtv_user_pictures/starcraft-profile_image-91cdefae9d5ee8b4-300x300.png",
      "mature": false,
      "name": "starcraft",
      "partner": false,
      "profile_banner": "https://static-cdn.jtvnw.net/jtv_user_pictures/starcraft-profile_banner-8a0bd21175f60469-480.png",
      "profile_banner_background_color": "",
      "status": "2016 WCS Global Finals @BlizzCon",
      "updated_at": "2016-12-15T21:35:27.851329Z",
      "url": "https://www.twitch.tv/starcraft",
      "video_banner": "https://static-cdn.jtvnw.net/jtv_user_pictures/starcraft-channel_offline_image-9f80ccdb7362a1d9-1920x1080.jpeg",
      "views": 19881024
   },
   ...
   ]
}
```

## Search::games
Searches for all live streams that match your query comparing on the game being streamed.

### API Aliases
`/search/games`

### Parameters
Parameter|Type|Required|Description
---------|----|--------|-----------
`query`|string|Yes|The string query to search games against
`limit`|integer|No|The integer limit of streams to pull.  Accepts any number, but Twitch only accepts a maximum of `100`
`offset`|integer|No|The integer offset for the query cursor.  Accepts any number within the limitations imposed by Twitch


### Usage
Static
```php
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Search;

$streams = Search::games(new Configuration([
    'clientID' => 'Your Twitch ClientID'
]), [
    'query' => 'starcraft',
    'limit' => 50,
    'offset' => 25
]);
```

Object
```php
use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;

$twitchClient = new Twitch(new Configuration([
    'clientID' => 'Your Twitch ClientID',
]));

$streams = $twitchClient->api('/search/games', [
    'query' => 'starcraft',
    'limit' => 50,
    'offset' => 25
]);
```

### Return Example
```json
{
   "_total": 2147,
   "channels": [{
      "_id": 42508152,
      "broadcaster_language": "en",
      "created_at": "2013-04-15T20:39:45.364539Z",
      "display_name": "StarCraft",
      "followers": 149012,
      "game": "StarCraft II",
      "language": "en",
      "logo": "https://static-cdn.jtvnw.net/jtv_user_pictures/starcraft-profile_image-91cdefae9d5ee8b4-300x300.png",
      "mature": false,
      "name": "starcraft",
      "partner": false,
      "profile_banner": "https://static-cdn.jtvnw.net/jtv_user_pictures/starcraft-profile_banner-8a0bd21175f60469-480.png",
      "profile_banner_background_color": "",
      "status": "2016 WCS Global Finals @BlizzCon",
      "updated_at": "2016-12-15T21:35:27.851329Z",
      "url": "https://www.twitch.tv/starcraft",
      "video_banner": "https://static-cdn.jtvnw.net/jtv_user_pictures/starcraft-channel_offline_image-9f80ccdb7362a1d9-1920x1080.jpeg",
      "views": 19881024
   },
   ...
   ]
}
```

## Search::streams
Searches for all live streams that match your query comparing on the stream title.

### API Aliases
`/search/streams`

### Parameters
Parameter|Type|Required|Description
---------|----|--------|-----------
`query`|string|Yes|The string query to search stream titles against
`limit`|integer|No|The integer limit of streams to pull.  Accepts any number, but Twitch only accepts a maximum of `100`
`offset`|integer|No|The integer offset for the query cursor.  Accepts any number within the limitations imposed by Twitch


### Usage
Static
```php
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Search;

$streams = Search::streams(new Configuration([
    'clientID' => 'Your Twitch ClientID'
]), [
    'query' => '2016 WCS',
    'limit' => 50,
    'offset' => 25
]);
```

Object
```php
use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;

$twitchClient = new Twitch(new Configuration([
    'clientID' => 'Your Twitch ClientID',
]));

$streams = $twitchClient->api('/search/streams', [
    'query' => '2016 WCS',
    'limit' => 50,
    'offset' => 25
]);
```

### Return Example
```json
{
   "_total": 2147,
   "channels": [{
      "_id": 42508152,
      "broadcaster_language": "en",
      "created_at": "2013-04-15T20:39:45.364539Z",
      "display_name": "StarCraft",
      "followers": 149012,
      "game": "StarCraft II",
      "language": "en",
      "logo": "https://static-cdn.jtvnw.net/jtv_user_pictures/starcraft-profile_image-91cdefae9d5ee8b4-300x300.png",
      "mature": false,
      "name": "starcraft",
      "partner": false,
      "profile_banner": "https://static-cdn.jtvnw.net/jtv_user_pictures/starcraft-profile_banner-8a0bd21175f60469-480.png",
      "profile_banner_background_color": "",
      "status": "2016 WCS Global Finals @BlizzCon",
      "updated_at": "2016-12-15T21:35:27.851329Z",
      "url": "https://www.twitch.tv/starcraft",
      "video_banner": "https://static-cdn.jtvnw.net/jtv_user_pictures/starcraft-channel_offline_image-9f80ccdb7362a1d9-1920x1080.jpeg",
      "views": 19881024
   },
   ...
   ]
}
```
