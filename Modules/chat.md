# Chat  

***  

These calls handle everything about getting chat related information  

| Call | Description |
| ---- | ----------- |
| [twitch::chat_getEmoticonsGlobal()]() | Gets a list of all currently registered and cached amoticons. |
| [twitch::chat_getEmoticons()]() | Grabs a list of all emoticons publically available on Twitch including any sub emotes for their channel. |
| [twitch::chat_getBadges()]() | Gets all badge related data for the specified channel. |
| [twitch::chat_generateToken()]() | Generates an IRC login token. |  

***  

## `twitch::chat_getEmoticonsGlobal()`  

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
            <td><code>$chan</code></td>
            <td>required</td>
            <td>string</td>
            <td>This is the channel name to grab the emotes for. (Target of the call)</td>
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

## `twitch::chat_getEmoticons()`  

Grabs a list of all emoticons publically available on Twitch including any sub emotes for their channel.

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
