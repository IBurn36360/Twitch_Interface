# Chat  

***  

These calls handle everything about getting chat related information  

| Call | Description |
| ---- | ----------- |
| [chat_getEmoticonsGlobal()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/chat.md#chat_getemoticonsglobal) | Gets a list of all currently registered and cached amoticons. |
| [chat_getEmoticons()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/chat.md#chat_getemoticons) | Grabs a list of all emoticons publically available on Twitch including any sub emotes for their channel. |
| [chat_getBadges()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/chat.md#chat_getbadges) | Gets all badge related data for the specified channel. |
| [chat_generateToken()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/chat.md#chat_generatetoken) | Generates an IRC login token. |  

***  

## `chat_getEmoticonsGlobal()` 

Grabs a list of all currentlt cached emoticons available on twitch.   

### Params

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
            <td>The high limit of editors to grab.<br /> (This does NOT work, this is in preparation for a possible future requirement)</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The starting offset of the list.<br />  (This does NOT work, this is in preparation for a possible future requirement)</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$allEmotes = $interface->chat_getEmoticonsGlobal();
```

If successful:

```json
"\:-?\(": [
    {
      "regex": "\:-?\(",
      "images": [
        {
          "emoticon_set": null,
          "height": 18,
          "width": 24,
          "url": "http://static-cdn.jtvnw.net/jtv_user_pictures/chansub-global-emoticon-d570c4b3b8d8fc4d-24x18.png"
        },
        {
          "emoticon_set": 33,
          "height": 18,
          "width": 21,
          "url": "http://static-cdn.jtvnw.net/jtv_user_pictures/chansub-global-emoticon-c41c5c6c88f481cd-21x18.png"
        }
      ]
    },
    ...
```

If service unavailable or if Twitch closed remote socket:

```json
{

}
```

***  

## `chat_getEmoticons()`  

Grabs a list of all emoticons publically available on Twitch including any sub emotes for their channel.

### Params

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
            <td>This is the channel name to grab the emotes for. (Target of the call)</td>
        </tr>
        <tr>
            <td><code>$limit</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The high limit of editors to grab.<br /> (This does NOT work, this is in preparation for a possible future requirement)</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The starting offset of the list.<br />  (This does NOT work, this is in preparation for a possible future requirement)</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$allEmotes = $interface->chat_getEmoticons('testuser1', -1, 0);
```

If successful:

```json
"\:-?\(": [
    {
      "regex": "\:-?\(",
      "images": [
        {
          "emoticon_set": null,
          "height": 18,
          "width": 24,
          "url": "http://static-cdn.jtvnw.net/jtv_user_pictures/chansub-global-emoticon-d570c4b3b8d8fc4d-24x18.png"
        },
        {
          "emoticon_set": 33,
          "height": 18,
          "width": 21,
          "url": "http://static-cdn.jtvnw.net/jtv_user_pictures/chansub-global-emoticon-c41c5c6c88f481cd-21x18.png"
        }
      ]
    },
    ...
```

If service unavailable or if Twitch closed remote socket:

```json
{

}
```

***  

## `chat_getBadges()`  

Grabs a list of all links to all available badges for that channel.

### Params

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
            <td>This is the channel name to grab the emotes for. (Target of the call)</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$badges = $interface->chat_getBadges('testuser1');
```

If successful:

```json
{
    "admin": [ 
        "alpha": "http://static-cdn.jtvnw.net/jtv_user_pictures/admin-global-badge-a19d6125f93450d3-18x18.png", 
        "image": "http://static-cdn.jtvnw.net/jtv_user_pictures/admin.png" 
    ], 
    "broadcaster": [ 
        "alpha": "http://static-cdn.jtvnw.net/jtv_user_pictures/broadcaster-global-badge-a33b04f2f5449625-18x18.png", 
        "image": "http://static-cdn.jtvnw.net/jtv_user_pictures/broadcaster.png" 
    ], 
    "mod": [ 
        "alpha": "http://static-cdn.jtvnw.net/jtv_user_pictures/mod-global-badge-fd9d467f7424030f-18x18.png",
        "image": "http://static-cdn.jtvnw.net/jtv_user_pictures/mod.png"
    ], 
    "staff": [ 
        "alpha": "http://static-cdn.jtvnw.net/jtv_user_pictures/staff-global-badge-3697eea55118890e-18x18.png", 
        "image": "http://static-cdn.jtvnw.net/jtv_user_pictures/staff.png"
    ], 
    "turbo": [ 
        "alpha": "http://static-cdn.jtvnw.net/jtv_user_pictures/turbo-global-badge-18x18.png", 
        "image": "http://static-cdn.jtvnw.net/jtv_user_pictures/turbo.png"
    ], 
    "subscriber": [        
        "image": "http://static-cdn.jtvnw.net/jtv_user_pictures/chansub-testuser1-badge-dfe3cfa67f77e09c-18x18.png"
    ],
    "_links": [ 
        "self": "https://api.twitch.tv/kraken/chat/iburn36360/badges"
    ]
} 
```

If service unavailable or if Twitch closed remote socket:

```json
{

}
```

***  

## `chat_generateToken()`  

Generates an IRC chat login token.  Checks for scope before generation.

<code>Authenticated: </code> chat_login

### Params

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
// Instancize the class as an object
$interface = new twitch;

$chatToken = $interface->chat_generateToken('jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

If successful:

```json
"oauth:jaxvvop7l6oypwg8bwk38nsozliakd3"
```

If service unavailable or if Twitch closed remote socket or if authentication failed:

```json
""
```