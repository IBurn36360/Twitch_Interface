# Games

***

This call handles grabbing the list of all top streamed games.

| Call | Description |
| ---- | ----------- |
| [getLargestGame()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/games.md#getlargestgame) | Attempts to grab a list of all games currently streamed in order of current viewers (descending) |

***

## `getLargestGame()`

Attempts to grab a list of all games currently streamed in order of current viewers (descending)

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
        <tr>
            <td><code>$hls</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>Sets the query to only return streams abiding by HLS standards.</td>
        </tr>  
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$topGames = $interface->getLargestGame(-1, 0, true);
```

If Successful:
```json
"League of Legends": [
{
  "game": {
    "name": "League of Legends",
    "box": {
      "large": "http://static-cdn.jtvnw.net/ttv-boxart/League%20of%20Legends.jpg?w=272&h=380&fit=scale",
      "medium": "http://static-cdn.jtvnw.net/ttv-boxart/League%20of%20Legends.jpg?w=136&h=190&fit=scale",
      "small": "http://static-cdn.jtvnw.net/ttv-boxart/League%20of%20Legends.jpg?w=52&h=72&fit=scale",
      "template": "http://static-cdn.jtvnw.net/ttv-boxart/League%20of%20Legends.jpg?w={width}&h={height}&fit=scale"
    },
    "logo": {
      "large": "http://static-cdn.jtvnw.net/ttv-logoart/League%20of%20Legends.jpg?w=240&h=144&fit=scale",
      "medium": "http://static-cdn.jtvnw.net/ttv-logoart/League%20of%20Legends.jpg?w=120&h=72&fit=scale",
      "small": "http://static-cdn.jtvnw.net/ttv-logoart/League%20of%20Legends.jpg?w=60&h=36&fit=scale",
      "template": "http://static-cdn.jtvnw.net/ttv-logoart/League%20of%20Legends.jpg?w={width}&h={height}&fit=scale"
    },
    "_links": {},
    "_id": 21779,
    "giantbomb_id": 24024
  },
  "viewers": 23873,
  "channels": 305
},
...
```

If the service was unavailable or if the socket was closed:
```json
{
    
}
```