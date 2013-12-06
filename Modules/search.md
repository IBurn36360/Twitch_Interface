# Authentication  

***  

This call allows you to query Twitch for all currently recognized games (From GiantBomb)

| Call | Description |
| ---- | ----------- |
| [searchGameCat()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/search.md#searchgamecat) | Searches Twitch's list of all games for the matching string. |

***

## `searchGameCat()`  

Searches Twitch's list of all games for the matching string.

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
            <td><code>$query</code></td>
            <td>required</td>
            <td>string</td>
            <td>the string you wish to search Twitch's game library for.</td>
        </tr>
        <tr>
            <td><code>$live</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Sets the query to accept only games being streamed</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$games = $interface->searchGameCat('Star', true);
```

### Example Return

If successful:

```json
{
    "StarCraft II: Wings of Liberty": {
      "box": {
        "small": "http://static-cdn.jtvnw.net/ttv-boxart/StarCraft%20II%3A%20Wings%20of%20Liberty.jpg?w=52&h=72&fit=scale",
        "large": "http://static-cdn.jtvnw.net/ttv-boxart/StarCraft%20II%3A%20Wings%20of%20Liberty.jpg?w=272&h=380&fit=scale",
        "medium": "http://static-cdn.jtvnw.net/ttv-boxart/StarCraft%20II%3A%20Wings%20of%20Liberty.jpg?w=136&h=190&fit=scale",
        "template": "http://static-cdn.jtvnw.net/ttv-boxart/StarCraft%20II%3A%20Wings%20of%20Liberty.jpg?w={width}&h={height}&fit=scale"
      },
      "logo": {
        "small": "http://static-cdn.jtvnw.net/ttv-logoart/StarCraft%20II%3A%20Wings%20of%20Liberty.jpg?w=60&h=36&fit=scale",
        "large": "http://static-cdn.jtvnw.net/ttv-logoart/StarCraft%20II%3A%20Wings%20of%20Liberty.jpg?w=240&h=144&fit=scale",
        "medium": "http://static-cdn.jtvnw.net/ttv-logoart/StarCraft%20II%3A%20Wings%20of%20Liberty.jpg?w=120&h=72&fit=scale",
        "template": "http://static-cdn.jtvnw.net/ttv-logoart/StarCraft%20II%3A%20Wings%20of%20Liberty.jpg?w={width}&h={height}&fit=scale"
      },
      "images": {
        "thumb": "http://media.giantbomb.com/uploads/0/30/1319229-sc2_se_2d_rgb_web_na_thumb.jpg",
        "tiny": "http://media.giantbomb.com/uploads/0/30/1319229-sc2_se_2d_rgb_web_na_tiny.jpg",
        "small": "http://media.giantbomb.com/uploads/0/30/1319229-sc2_se_2d_rgb_web_na_small.jpg",
        "super": "http://media.giantbomb.com/uploads/0/30/1319229-sc2_se_2d_rgb_web_na_super.jpg",
        "medium": "http://media.giantbomb.com/uploads/0/30/1319229-sc2_se_2d_rgb_web_na_small.jpg",
        "icon": "http://media.giantbomb.com/uploads/0/30/1319229-sc2_se_2d_rgb_web_na_icon.jpg",
        "screen": "http://media.giantbomb.com/uploads/0/30/1319229-sc2_se_2d_rgb_web_na_screen.jpg"
      },
      "popularity": 114,
      "name": "StarCraft II: Wings of Liberty",
      "_id": 63011880,
      "_links": { },
      "giantbomb_id": 20674          
    },
    ...
}
```

If no games were found to match that query:
```json
{

}
```
