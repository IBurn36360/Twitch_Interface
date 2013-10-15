# Chsnnels  

***  

These calls handle everything about getting channel data and updating channel data  

| Call | Description |
| ---- | ----------- |
| [twitch::getChannelObject()]() | Gets an unauthenticated channel object for the target channel. |
| [twitch::getChannelObject_Authd()]() | Gets an authenticated channel object using an OAuth token as the identifying parameter. |
| [twitch::getEditors()]() | Grabs a list of all editors to targe channel. |
| [twitch::updateChannelObject()]() | Updates the target channel with new information. |
| [twitch::resetStreamKey()]() | Attempts to reset target channels stream key and have a new one generated. |
| [twitch::startCommercial()]() | Attempts to start a commercial on target channel. |

***  

## `twitch::getChannelObject()`  

Grabs a channel object containing all publicallly available data for that channel.  

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
            <td>This is the channel name to grab the channel object for. (Target of the call)</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
$testObject = twitch::getChannelObject('testChannel1');
```

### Example Return

If successful:

[Channel object returned from Twitch](https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#example-response)

```json
{
    "name": "testChannel1",
    "game": "Test Game 1",
    "created_at": "2011-02-24T01:38:43Z",
    "delay": 0,
    "teams": [{
        "name": "testTeam",
        "created_at": "2011-10-25T23:55:47Z",
        "updated_at": "2011-11-14T19:48:21Z",
        "background": null,
        "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-testTeam-banner_image-1e028d6b6aec8e6a-640x125.jpeg",
        "logo": null,
        "_links": {
            "self": "https://api.twitch.tv/kraken/teams/testTeam"
        },
        "_id": 10,
        "info": "",
        "display_name": "Test Team"
    }],
    "title": "testChannel1",
    "updated_at": "2012-06-18T05:22:53Z",
    "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/testChannel1-channel_header_image-7d10ec1bfbef2988-640x125.png",
    "video_banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/testChannel1-channel_offline_image-bdcb1260130fa0cb.png",
    "background": "http://static-cdn.jtvnw.net/jtv_user_pictures/testChannel1-channel_background_image-eebc4eabf0686bb9.png",
    "_links": {
        "self": "https://api.twitch.tv/kraken/channels/testChannel1",
        "chat": "https://api.twitch.tv/kraken/chat/testChannel1",
        "videos": "https://api.twitch.tv/kraken/channels/testChannel1/videos",
        "video_status": "https://api.twitch.tv/kraken/channels/testChannel1/video_status",
        "commercial": "https://api.twitch.tv/kraken/channels/testChannel1/commercial"
    },
    "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/testChannel1-profile_image-7243b004a2ec3720-300x300.png",
    "_id": 20694610,
    "mature": false,
    "url": "http://www.twitch.tv/testChannel1",
    "display_name": "testChannel1"
}
```

If query failed due to no channel or failed return:

```json
{

}
```

***  

## `twitch::getChannelObject_Authd()`  

Grabs an authenticated channel object.  Contains some sensitive information specific to the account.

<code>Authenticated: </code> channel_read

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
    </tbody>
</table>

### Example Call 

```php
$testObject = twitch::getChannelObject_Authd('jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

### Example Return

If successful:

[Authenticated channel object returned from Twitch](https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md#example-response-1)

```json
{
  "game": "Test Game 1",
  "name": "testChannel1",
  "stream_key": "live_21229404_abcdefg",
  "created_at": "2011-03-19T15:42:22Z",
  "delay": 0,
  "title": "Cev",
  "updated_at": "2012-03-14T03:30:41Z",
  "teams": [{
    "name": "testTeam",
    "created_at": "2011-10-25T23:55:47Z",
    "updated_at": "2011-11-14T19:48:21Z",
    "background": null,
    "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/testTeam-banner_image-1e028d6b6aec8e6a-640x125.jpeg",
    "logo": null,
    "_links": {
      "self": "https://api.twitch.tv/kraken/teams/testTeam"
    },
    "_id": 10,
    "info": "",
    "display_name": "Test Team"
  }],
  "_links": {
    "self": "https:/api.twitch.tv/kraken/channels/testChannel1",
    "chat":"https:/api.twitch.tv/kraken/chat/testChannel1",
    "videos": "https://api.twitch.tv/kraken/channels/testChannel1/videos",
    "video_status": "https://api.twitch.tv/kraken/channels/testChannel1/video_status",
    "commercial":"https:/api.twitch.tv/kraken/channels/testChannel1/commercial"
  },
  "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/testChannel1-channel_header_image-7d10ec1bfbef2988-640x125.png",
  "video_banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/testChannel1-channel_offline_image-bdcb1260130fa0cb.png",
  "background": "http://static-cdn.jtvnw.net/jtv_user_pictures/testChannel1-channel_background_image-eebc4eabf0686bb9.png",
  "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/testChannel1-profile_image-7243b004a2ec3720-300x300.png",
  "id": 21229404,
  "mature": false,
  "login": "testChannel1",
  "url": "http://www.twitch.tv/testChannel1",
  "email": "testChannel1@test.com"
}
```

If Invalid channel name or service not responding:

```json
{

}
```

If authentication failure:

```json
{

}
```

***  

## `twitch::getEditors()` 

Grabs a list of all editors to the specified channel.  This call uses the [KEY_NAME](https://github.com/IBurn36360/Twitch_Interface/blob/master/configuration.md#twitch_configuration) config option to determine what name to use as the row return.

<code>Authenticated: </code> channel_read

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
            <td>Required</td>
            <td>string</td>
            <td>This is the channel name to grab the editors list from.</td>
        </tr>    
        <tr>
            <td><code>$limit</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The high limit of editors to grab.<br /> (This does NOT work, this is in preparation for a future requirement)</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The starting offset of the list.<br />  (This does NOT work, this is in preparation for a future requirement)</td>
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
    </tbody>
</table>

### Example Call 

```php
$testObject = twitch::getChannelObject_Authd('testChannel1', -1, 0, 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

### Example Return

If successful:

```json
{
  "testEditor1",
  "testEditor2",
  ...
}
```

If no editors were returned:

```json
{

}
```

If authentication failure (Error passed to output functions before returns):

```json
{

}
```

*** 

