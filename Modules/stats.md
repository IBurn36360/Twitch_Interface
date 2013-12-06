# Stats

***

This call grabs some base statistics about Twitch

| Call | Description |
| ---- | ----------- |
| [getTwitchStatistics()]() | Gets the current viewers and the current live channels for Twitch |

***

## `getTwitchStatistics()`

Gets the current viewers and the current live channels for Twitch

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
            <td><code>$hls</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Sets the check to only include streams abiding by HLS</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$stats = $interface->getTwitchStatistics(false);
```

### Example Return

If service was available:

```json
{
  "viewers": 194774,
  "_links": {
    "self": "https://api.twitch.tv/kraken/streams/summary"
  },
  "channels": 4144
}
```

If service was unavailable:
```json
{
    
}
```