# Follows  

***  

These calls handle queries about follows.  This includes getting list of followed and following channels and adding or removing followers.

| Call | Description |
| ---- | ----------- |
| [getFollowers()]() | Grabs a list of the users following the specified channel. |
| [getFollows()]() | Grabs a list of the channels followed by a specified user. |
| [followChan()]() | Attempts to add a target channel to a subject users follows list. |
| [unfollowChan()]() | Attempts to remove a target channel from a subject users follows list. |

***  

## `getFollowers()`  

Grabs a list of the users following the specified channel.

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
            <td>Required</td>
            <td>string</td>
            <td>The channel name to grab the followers from.</td>
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
        <tr>
            <td><code>$sorting</code></td>
            <td>$optional</td>
            <td>string</td>
            <td>Sets the sorting option for the query.  Accepts string 'asc' (Ascending order) or string 'desc' (Descending order)</td>
        </tr>  
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$followers = $interface->getFollowers('testchannel1', -1, 0, 'desc');
```

If successful:
```json
"test_user2": {
  "created_at": "2013-06-02T09:38:45Z",
  "_links": {
    "self": "https://api.twitch.tv/kraken/users/test_user2/follows/channels/test_user1"
  },
  "user": {
    "_links": {
      "self": "https://api.twitch.tv/kraken/users/test_user2"
    },
    "staff": false,
    "logo": null,
    "display_name": "test_user2",
    "created_at": "2013-02-06T21:21:57Z",
    "updated_at": "2013-02-13T20:59:42Z",
    "_id": 40091581,
    "name": "test_user2"
  }
},
...
```

If Authentication failed or an error occured:

```json
{

}
```

***  

 