# Streams  

***  

These calls request the status of channels from Twitch, returning what ones are currently live (as far as the API can tell).

| Call | Description |
| ---- | ----------- |
| [getStreamObject()]() | Queries Twitch for the stream object of the specified channel. |
| [getStreamsObjects()]() | Queries Twitch for the stream objects of multiple channels or by a set of conditions or both. |
| [getFeaturedStreams()]() | Returns currently featured streamers. |

***

## `getStreamObject()`  

Queries Twitch for the stream object of the specified channel.

### Parameters  

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Required?</th>
            <th width="50">Type</th>
            <th width=100%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>$chan</code></td>
            <td>required</td>
            <td>string</td>
            <td>The specific channel you wish to query.</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$stream = $interface->getStreamObject('test_channel');
```

### Example Return

If successful:

```json
{
    "_links": {
      "self": "https://api.twitch.tv/kraken/streams/test_channel"
    },
    "preview": {
      "medium": "http://static-cdn.jtvnw.net/previews-ttv/live_user_test_user1-320x200.jpg",
      "small": "http://static-cdn.jtvnw.net/previews-ttv/live_user_test_user1-80x50.jpg",
      "large": "http://static-cdn.jtvnw.net/previews-ttv/live_user_test_user1-640x400.jpg",
      "template": "http://static-cdn.jtvnw.net/previews-ttv/live_user_test_user1-{width}x{height}.jpg"
    },
    "_id": 4869165040,
    "viewers": 11754,
    "channel": {
      "display_name": "test_channel",
      "_links": {
        "stream_key": "https://api.twitch.tv/kraken/channels/test_channel/stream_key",
        "editors": "https://api.twitch.tv/kraken/channels/test_channel/editors",
        "subscriptions": "https://api.twitch.tv/kraken/channels/test_channel/subscriptions",
        "commercial": "https://api.twitch.tv/kraken/channels/test_channel/commercial",
        "videos": "https://api.twitch.tv/kraken/channels/test_channel/videos",
        "follows": "https://api.twitch.tv/kraken/channels/test_channel/follows",
        "self": "https://api.twitch.tv/kraken/channels/test_channel",
        "chat": "https://api.twitch.tv/kraken/chat/test_channel",
        "features": "https://api.twitch.tv/kraken/channels/test_channel/features"
      },
      "teams": [ ],
      "status": "Testing 1 2 3",
      "created_at": "2011-12-23T18:03:44Z",
      "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_channel-profile_image-1806cdccb1108442-300x300.jpeg",
      "updated_at": "2013-02-15T15:22:24Z",
      "mature": null,
      "video_banner": null,
      "_id": 26991613,
      "background": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_channel-channel_background_image-21fffe7f0c309a23.jpeg",
      "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_channel-channel_header_image-4eb6147d464d9053-640x125.jpeg",
      "name": "test_channel",
      "delay": 0,
      "url": "http://www.twitch.tv/test_channel",
      "game": "Magic: The Gathering"
    },
    "game": "Magic: The Gathering"
}
```

If the channel was not found or the stream was not online:
```json
null
```

***  

## `getStreamsObjects()`  

Queries Twitch for the stream objects of multiple channels or by a set of conditions or both.

### Parameters  

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Required?</th>
            <th width="50">Type</th>
            <th width=100%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>$game</code></td>
            <td>optional</td>
            <td>string</td>
            <td>Sets the query to only accept streams according to the specified game.</td>
        </tr>
        <tr>
            <td><code>$channels</code></td>
            <td>optional</td>
            <td>array</td>
            <td>Array of all string channels you with to query for.</td>
        </tr>
        <tr>
            <td><code>$limit</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The high limit of stream objects to grab.</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The starting offset of the list.</td>
        </tr>
        <tr>
            <td><code>$embedable</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Sets the query to only accept streams that allow an embedded player</td>
        </tr>
        <tr>
            <td><code>$hls</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Sets the query to only accept streams currently abiding by HLS.</td>
        </tr>
        <tr>
            <td><code>$client_id</code></td>
            <td>optional</td>
            <td>string</td>
            <td>Sets the query to accept any and all channels that have authorized the spplied client_id</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$streams = $interface->getStreamsObjects('Diablo III', array('zisss', 'voyboy'), -1, 0);
```

### Example Return

If successful:

```json
"zisss": [
    {
      "_id": 5019229776,
      "preview": {
        "medium": "http://static-cdn.jtvnw.net/previews-ttv/live_user_zisss-320x200.jpg",
        "small": "http://static-cdn.jtvnw.net/previews-ttv/live_user_zisss-80x50.jpg",
        "large": "http://static-cdn.jtvnw.net/previews-ttv/live_user_zisss-640x400.jpg",
        "template": "http://static-cdn.jtvnw.net/previews-ttv/live_user_zisss-{width}x{height}.jpg"
      },
      "game": "Diablo III",
      "channel": {
        "mature": null,
        "background": "http://static-cdn.jtvnw.net/jtv_user_pictures/zisss-channel_background_image-06a9d8c1113e5b45.jpeg",
        "updated_at": "2013-03-04T05:27:27Z",
        "_id": 31795858,
        "status": "Barb sets giveaway and making 500m DH set... Join Zisspire, earn Zeny, collect prizes!",
        "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/zisss-profile_image-502d7c865c5e3a54-300x300.jpeg",
        "teams": [ ],
        "url": "http://www.twitch.tv/zisss",
        "display_name": "Zisss",
        "game": "Diablo III",
        "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/zisss-channel_header_image-997348d7f0658115-640x125.jpeg",
        "name": "zisss",
        "delay": 0,
        "video_banner": null,
        "_links": {
          "chat": "https://api.twitch.tv/kraken/chat/zisss",
          "subscriptions": "https://api.twitch.tv/kraken/channels/zisss/subscriptions",
          "features": "https://api.twitch.tv/kraken/channels/zisss/features",
          "commercial": "https://api.twitch.tv/kraken/channels/zisss/commercial",
          "stream_key": "https://api.twitch.tv/kraken/channels/zisss/stream_key",
          "editors": "https://api.twitch.tv/kraken/channels/zisss/editors",
          "videos": "https://api.twitch.tv/kraken/channels/zisss/videos",
          "self": "https://api.twitch.tv/kraken/channels/zisss",
          "follows": "https://api.twitch.tv/kraken/channels/zisss/follows"
        },
        "created_at": "2012-07-01T21:09:58Z"
      },
      "viewers": 775,
      "_links": {
        "self": "https://api.twitch.tv/kraken/streams/zisss"
      }
    }
],
...
```

If the channel was not found or the stream was not online:
```json
{
    
}
```

***  

## `getStreamsObjects()`  

Returns currently featured streamers.

### Parameters  

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Required?</th>
            <th width="50">Type</th>
            <th width=100%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>$limit</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The high limit of stream objects to grab.</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The starting offset of the list.</td>
        </tr>
        <tr>
            <td><code>$hls</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Sets the query to only accept streams currently abiding by HLS.</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$featured = $interface->getFeaturedStreams(-1, 0, true);
```

### Example Return

If successful:

```json
"zisss": [
    {
      "_id": 5019229776,
      "preview": {
        "medium": "http://static-cdn.jtvnw.net/previews-ttv/live_user_zisss-320x200.jpg",
        "small": "http://static-cdn.jtvnw.net/previews-ttv/live_user_zisss-80x50.jpg",
        "large": "http://static-cdn.jtvnw.net/previews-ttv/live_user_zisss-640x400.jpg",
        "template": "http://static-cdn.jtvnw.net/previews-ttv/live_user_zisss-{width}x{height}.jpg"
      },
      "game": "Diablo III",
      "channel": {
        "mature": null,
        "background": "http://static-cdn.jtvnw.net/jtv_user_pictures/zisss-channel_background_image-06a9d8c1113e5b45.jpeg",
        "updated_at": "2013-03-04T05:27:27Z",
        "_id": 31795858,
        "status": "Barb sets giveaway and making 500m DH set... Join Zisspire, earn Zeny, collect prizes!",
        "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/zisss-profile_image-502d7c865c5e3a54-300x300.jpeg",
        "teams": [ ],
        "url": "http://www.twitch.tv/zisss",
        "display_name": "Zisss",
        "game": "Diablo III",
        "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/zisss-channel_header_image-997348d7f0658115-640x125.jpeg",
        "name": "zisss",
        "delay": 0,
        "video_banner": null,
        "_links": {
          "chat": "https://api.twitch.tv/kraken/chat/zisss",
          "subscriptions": "https://api.twitch.tv/kraken/channels/zisss/subscriptions",
          "features": "https://api.twitch.tv/kraken/channels/zisss/features",
          "commercial": "https://api.twitch.tv/kraken/channels/zisss/commercial",
          "stream_key": "https://api.twitch.tv/kraken/channels/zisss/stream_key",
          "editors": "https://api.twitch.tv/kraken/channels/zisss/editors",
          "videos": "https://api.twitch.tv/kraken/channels/zisss/videos",
          "self": "https://api.twitch.tv/kraken/channels/zisss",
          "follows": "https://api.twitch.tv/kraken/channels/zisss/follows"
        },
        "created_at": "2012-07-01T21:09:58Z"
      },
      "viewers": 775,
      "_links": {
        "self": "https://api.twitch.tv/kraken/streams/zisss"
      }
    }
],    
```

If unsuccessful or service unavailable:
```json
{
    
}
```