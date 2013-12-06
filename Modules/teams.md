# Teams

These calls handle querying about teams.

| Call | Description |
| ---- | ----------- |
| [getTeams()]() | Gets the team objects for all active teams. |
| [getTeam()]() | Grabs the team object for the supplied team. |

***

## `getTeams()`

Gets the team objects for all active teams.

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
            <td>The high limit of teams to grab.</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The starting offset of the list.</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$teams = $interface->getTeams(-1, 0);
```

### Example Return

If service available:

```json
"testteam": {
  "info": "I love working for Twitch!\n\n",
  "_links": {
    "self": "https://api.twitch.tv/kraken/teams/testteam"
  },
  "background": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-testteam-background_image-c72e038f428c9c7d.png",
  "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-testteam-banner_image-cc318b0f084cb67c-640x125.jpeg",
  "name": "testteam",
  "_id": 1,
  "updated_at": "2012-11-14T01:30:00Z",
  "display_name": "test",
  "created_at": "2011-10-11T22:49:05Z",
  "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-testteam-team_logo_image-46943237490be5e7-300x300.jpeg"
},
"eg": {
  "info": "Team Info\n",
  "_links": {
    "self": "https://api.twitch.tv/kraken/teams/eg"
  },
  "background": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-eg-background_image-da36973b6d829ac6.png",
  "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-eg-banner_image-1ad9c4738f4698b1-640x125.png",
  "name": "eg",
  "_id": 2,
  "updated_at": "2012-10-03T01:48:25Z",
  "display_name": "Evil Geniuses",
  "created_at": "2011-10-11T23:59:43Z",
  "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-eg-team_logo_image-9107b874d4c3fc3b-300x300.jpeg"
},
...
```

If service unavailable:

```json
{
    
}
```

***

## `getTeam()`

Grabs the team object for the supplied team.

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
            <td><code>$team</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The specific team you wish to grab the object for</td>
        </tr>            
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$team = $interface->getTeam('eg');
```

### Example Return

If service available:

```json
"eg": {
  "_id": 2,
  "created_at": "2011-10-11T23:59:43Z",
  "info": "Team Info\n",
  "updated_at": "2012-01-15T19:43:40Z",
  "background": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-eg-background_image-089a407eb59fe3b2.png",
  "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-eg-banner_image-8089b058e6ffe4cd-640x125.png",
  "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-eg-team_logo_image-53eaf029dad7d5c9-300x300.png",
  "_links": {
    "self": "https://api.twitch.tv/kraken/teams/eg"
  },
  "display_name": "Evil Geniuses",
  "name": "eg"
}
...
```

If service unavailable:

```json
{
    
}
```