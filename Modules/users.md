# Users

These calls handle grabbing user data.

| Call | Description |
| ---- | ----------- |
| [getUserObject()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/users.md#getuserobject) | Grabs an unauthenticated user object for the supplied username. |
| [getUserObject_Authd()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/users.md#getuserobject_authd) | Grabs an authenticated user object for the supplied username.  Contains some sensitive data. |

***

## `getUserObject()`

Grabs an unauthenticated user object for the supplied username.

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
            <td><code>$user</code></td>
            <td>required</td>
            <td>string</td>
            <td>The specified user you wish to grab the object for.</td>
        </tr>            
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$user = $interface->getUserObject('test_user1');
```

### Example Return

If service available:

```json
{
  "type": "user",
  "name": "test_user1",
  "created_at": "2011-03-19T15:42:22Z",
  "updated_at": "2012-06-14T00:14:27Z",
  "_links": {
    "self": "https://api.twitch.tv/kraken/users/test_user1"
  },
  "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-profile_image-6947308654ad603f-300x300.jpeg",
  "_id": 21229404,
  "display_name": "test_user1",
  "bio": "test bio woo I'm a test user"
}
```

If the channel was not found or the service is unavailable:
```json
{
    
}
```

***

## `getUserObject_Authd()`

Grabs an unauthenticated user object for the supplied username.

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
            <td><code>$user</code></td>
            <td>required</td>
            <td>string</td>
            <td>The specified user you wish to grab the object for.</td>
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
// Instancize the class as an object
$interface = new twitch;

$user = $interface->getUserObject_Authd('test_user1', 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

### Example Return

If service available:

```json
{
  "type": "user",
  "name": "test_user1",
  "created_at": "2011-06-03T17:49:19Z",
  "updated_at": "2012-06-18T17:19:57Z",
  "_links": {
    "self": "https://api.twitch.tv/kraken/users/test_user1"
  },
  "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/test_user1-profile_image-62e8318af864d6d7-300x300.jpeg",
  "_id": 22761313,
  "display_name": "test_user1",
  "email": "asdf@asdf.com",
  "partnered": true,
  "bio": "test bio woo I'm a test user"
}
```

If the channel was not found or the service is unavailable:
```json
{
    
}
```
