# Teams

Function | API Alias | Description
-------- | --------- | -----------
[`Teams::getTeams`](#teamsgetteams) | [`/teams`](#teamsgetteams) | Gets all active teams based on the limit and offset you provide
[`Teams::getTeam`](#teamsgetteam) | [`/team`](#teamsgetteam) | Gets the specific team object by the requested team name

## Teams::getTeams
Gets all active teams based on the limit and offset you provide.

### Authentication Scopes
No authentication scopes needed

### API Aliases
`/search/channels`

### Parameters
Parameter|Type|Required|Description
---------|----|--------|-----------
`limit`|integer|No|The integer limit of teams to pull.  Accepts any number, but Twitch only accepts a maximum of `100`
`offset`|integer|No|The integer offset for the cursor.  Accepts any number within the limitations imposed by Twitch

### Usage
Static
```php
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Teams;

$streams = Teams::getTeams(new Configuration([
    'clientID' => 'Your Twitch ClientID'
]), [
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

$streams = $twitchClient->api('/teams', [
    'limit' => 50,
    'offset' => 25
]);
```

### Return Example
```json
{
   "teams": [{
      "_id": 10,
      "background": null,
      "banner": "https://static-cdn.jtvnw.net/jtv_user_pictures/team-staff-banner_image-606ff5977f7dc36e-640x125.png",
      "created_at": "2011-10-25T23:55:47Z",
      "display_name": "Twitch Staff",
      "info": "Twitch staff stream here. Drop in and say \"hi\" sometime :)",
      "logo": "https://static-cdn.jtvnw.net/jtv_user_pictures/team-staff-team_logo_image-76418c0c93a9d48b-300x300.png",
      "name": "staff",
      "updated_at": "2014-10-16T00:44:11Z"
   },
   ...
   ]
}
```

## Teams::getTeam
Gets the specific team object by the requested team name.

### Authentication Scopes
No authentication scopes needed

### API Aliases
`/search/channels`

### Parameters
Parameter|Type|Required|Description
---------|----|--------|-----------
`teamName`|string|Yes|The team name to pull a detail object for

### Usage
Static
```php
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Teams;

$streams = Teams::getTeam(new Configuration([
    'clientID' => 'Your Twitch ClientID'
]), [
    'teamName' => 'staff'
]);
```

Object
```php
use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;

$twitchClient = new Twitch(new Configuration([
    'clientID' => 'Your Twitch ClientID',
]));

$streams = $twitchClient->api('/team', [
    'teamName' => 'staff'
]);
```

### Return Example
```json
{
   "_id": 10,
   "background": null,
   "banner": "https://static-cdn.jtvnw.net/jtv_user_pictures/team-staff-banner_image-606ff5977f7dc36e-640x125.png",
   "created_at": "2011-10-25T23:55:47Z",
   "display_name": "Twitch Staff",
   "info": "Twitch staff stream here. Drop in and say \"hi\" some time :)",
   "logo": "https://static-cdn.jtvnw.net/jtv_user_pictures/team-staff-team_logo_image-76418c0c93a9d48b-300x300.png",
   "name": "staff",
   "updated_at": "2014-10-16T00:44:11Z",
   "users": [{
         "_id": 5582097,
         "broadcaster_language": "en",
         "created_at": "2009-04-13T21:22:28Z",
         "display_name": "Sarbandia",
         "followers": 1182,
         "game": "Hearthstone: Heroes of Warcraft",
         "language": "en",
         "logo": "https://static-cdn.jtvnw.net/jtv_user_pictures/sarbandia-profile_image-6693b5952f31c847-300x300.jpeg",
         "mature": false,
         "name": "sarbandia",
         "partner": false,
         "profile_banner": "https://static-cdn.jtvnw.net/jtv_user_pictures/sarbandia-profile_banner-247cdbe62dbcf4d9-480.jpeg",
         "profile_banner_background_color": null,
         "status": "Midrange shaman laddering",
         "updated_at": "2016-12-15T19:02:40Z",
         "url": "https://www.twitch.tv/sarbandia",
         "video_banner": null,
         "views": 8168
   },
   ...
   ]
}
```
