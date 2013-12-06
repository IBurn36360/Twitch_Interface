# Videos

***

These calls handle grabbing information about videos (Highlights and broadcasts).

| Call | Description |
| ---- | ----------- |
| [getVideo_ID()]() | Returns the video object for the specified ID. |
| [getVideo_channel()]() | Returns the video objects of the given channel. |
| [getVideo_followed()]() | Grabs all videos for all channels a user is following. |
| [getTopVideos()]() | Gets a list of the top viewed videos by the sorting parameters. |

***

## `getVideo_ID()`

Returns the video object for the specified ID.

### Parameters  

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th width=20%>Required?</th>
            <th width="50">Type</th>
            <th width=99%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>$id</code></td>
            <td>required</td>
            <td>string</td>
            <td>The chapter and ID of the video you wish to query for.</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$video = $interface->getVideo_ID('a328087483');
```

### Example Return

If successful:

```json
{
  "recorded_at": "2012-08-09T20:49:47Z",
  "title": "VanillaTV - Sweden vs Russia - ETF2L Nations Cup - Snakewater [Map3] - Part 3",
  "url": "http://www.twitch.tv/vanillatv/b/328087483",
  "_id": "a328087483",
  "_links": {
      "self": "https://api.twitch.tv/kraken/videos/a328087483",
      "owner": "https://api.twitch.tv/kraken/channels/vanillatv"
  },
  "views": 93,
  "description": "VanillaTV - Sweden vs Russia - ETF2L Nations Cup - Snakewater [Map3] - Part 3",
  "length": 204,
  "game": null,
  "preview": "http://static-cdn.jtvnw.net/jtv.thumbs/archive-328087483-320x240.jpg"
}
```

If video does not exist or service unavailable:

```json
{
    
}
```

***

## `getVideo_channel()`

Returns the video objects of the given channel.

### Parameters  

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th width=20%>Required?</th>
            <th width="50">Type</th>
            <th width=99%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>$chan</code></td>
            <td>required</td>
            <td>string</td>
            <td>The channel you wish to query videos for.</td>
        </tr>
        <tr>
            <td><code>$limit</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The high limit of videos to grab.</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The starting offset of the list.</td>
        </tr>
        <tr>
            <td><code>$boradcastsOnly</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>If true, limits query to only past broadcasts, else will return highlights only.</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$videos = $interface->getVideo_channel('vanillatv', 10, 0, false);
```

### Example Return

If successful:

```json
"a296529186": {
  "title": "ETF2L Week 1: Epsilon vs. Dignitas",
  "recorded_at": "2011-10-02T19:57:06Z",
  "_id": "a296529186",
  "_links": {
      "self": "https://api.twitch.tv/kraken/videos/a296529186",
      "owner": "https://api.twitch.tv/kraken/channels/vanillatv"
  },
  "url": "http://www.twitch.tv/vanillatv/b/296529186",
  "views": 1,
  "preview": "http://static-cdn.jtvnw.net/jtv.thumbs/archive-296529186-320x240.jpg",
  "length": 23,
  "game": "Team Fortress 2"
  "description": null
},
"a296526250": {
  "title": "ETF2L Week 1: Epsilon vs. Dignitas",
  "recorded_at": "2011-10-02T19:01:23Z",
  "_id": "a296526250",
  "_links": {
      "self": "https://api.twitch.tv/kraken/videos/a296526250",
      "owner": "https://api.twitch.tv/kraken/channels/vanillatv"
  },
  "url": "http://www.twitch.tv/vanillatv/b/296526250",
  "views": 1,
  "preview": "http://static-cdn.jtvnw.net/jtv.thumbs/archive-296526250-320x240.jpg",
  "length": 1296,
  "game": "Team Fortress 2",
  "description": null
},
...
```

If channel does not exist or service unavailable:

```json
{
    
}
```

***

## `getVideo_followed()`

Grabs all videos for all channels a user is following.

<code>Authenticated: </code> user_read

### Parameters  

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th width=20%>Required?</th>
            <th width="50">Type</th>
            <th width=99%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>$limit</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The high limit of videos to grab.</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The starting offset of the list.</td>
        </tr>
        <tr>
            <td><code>$authKey</code></td>
            <td>Required if a valid code is not supplied to <code>$code</code></td>
            <td>string</td>
            <td>This is the OAuth token to attempt to use for the call.  This token is checked prior to the call for validity and scope.</td>
        </tr>
        <tr>
            <td><code>$code</code></td>
            <td>Required if no token was supplied to <code>$authKey</code> or if <code>$authKey</code> was no longer valid.</td>
            <td>string</td>
            <td>This is the code used to generate a token from the Kraken API directly.  The token is checked for scope before the call is made</td>
        </tr>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$videos = $interface->getVideo_followed(-1, 0, 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

### Example Return

If successful:

```json
"a296529186": {
  "title": "ETF2L Week 1: Epsilon vs. Dignitas",
  "recorded_at": "2011-10-02T19:57:06Z",
  "_id": "a296529186",
  "_links": {
      "self": "https://api.twitch.tv/kraken/videos/a296529186",
      "owner": "https://api.twitch.tv/kraken/channels/vanillatv"
  },
  "url": "http://www.twitch.tv/vanillatv/b/296529186",
  "views": 1,
  "preview": "http://static-cdn.jtvnw.net/jtv.thumbs/archive-296529186-320x240.jpg",
  "length": 23,
  "game": "Team Fortress 2"
  "description": null
},
"a296526250": {
  "title": "ETF2L Week 1: Epsilon vs. Dignitas",
  "recorded_at": "2011-10-02T19:01:23Z",
  "_id": "a296526250",
  "_links": {
      "self": "https://api.twitch.tv/kraken/videos/a296526250",
      "owner": "https://api.twitch.tv/kraken/channels/vanillatv"
  },
  "url": "http://www.twitch.tv/vanillatv/b/296526250",
  "views": 1,
  "preview": "http://static-cdn.jtvnw.net/jtv.thumbs/archive-296526250-320x240.jpg",
  "length": 1296,
  "game": "Team Fortress 2",
  "description": null
},
...
```

If there are no videos or the service was unavailable:

```json
{
    
}
```

***

## `getTopVideos()`

Gets a list of the top viewed videos by the sorting parameters.

### Parameters  

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th width=20%>Required?</th>
            <th width="50">Type</th>
            <th width=99%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>$game</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>Set the query to limit to a specific game</td>
        </tr> 
        <tr>
            <td><code>$limit</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The high limit of videos to grab.</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The starting offset of the list.</td>
        </tr>
        <tr>
            <td><code>$period</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>Sets the query to sccept only videos within the specified peroid.  Accepts: <code>week</code> <code>month</code> <code>all</code></td>
        </tr> 
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$videos = $interface->getTopVideos('League of Legends', -1, 0, 'month');
```

### Example Return

If successful:

```json
"c2023831": {
  "recorded_at": "2013-03-13T09:51:31Z",
  "preview": "http://static-cdn.jtvnw.net/jtv.thumbs/archive-377199700-320x240.jpg",
  "description": "dat trist jump",
  "url": "http://www.twitch.tv/chaoxlol/c/2023831",
  "title": "Almost the great escape",
  "channel": {
    "name": "chaoxlol",
    "display_name": "chaoxlol"
  },
  "length": 71,
  "game": "League of Legends",
  "views": 66436,
  "_id": "c2023831",
  "_links": {
    "channel": "https://api.twitch.tv/kraken/channels/chaoxlol",
    "self": "https://api.twitch.tv/kraken/videos/c2023831"
  }
},
...
```

If there are no videos or the service was unavailable:

```json
{
    
}
```