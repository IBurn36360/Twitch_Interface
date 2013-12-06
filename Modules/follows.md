# Follows  

***  

These calls handle queries about follows.  This includes getting list of followed and following channels and adding or removing followers.

| Call | Description |
| ---- | ----------- |
| [getFollowers()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/follows.md#getfollowers) | Grabs a list of the users following the specified channel. |
| [getFollows()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/follows.md#getfollows) | Grabs a list of the channels followed by a specified user. |
| [followChan()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/follows.md#followchan) | Attempts to add a target channel to a subject users follows list. |
| [unfollowChan()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/follows.md#unfollowchan) | Attempts to remove a target channel from a subject users follows list. |

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
            <td>The high limit of editors to grab.</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The starting offset of the list.</td>
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

If service was unavailable or an error occured:

```json
{

}
```

***  

## `getFollowers()`  

Grabs a list of the channels followed by a specified user.

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
            <td>The high limit of editors to grab.</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The starting offset of the list.</td>
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

$followers = $interface->getFollows('testchannel1', -1, 0, 'desc');
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

If service was unavailable or an error occured:

```json
{

}
```

***  

## `followChan()`  

Grabs a list of the channels followed by a specified user.

<code>Authenticated: </code> user_follows_edit

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
            <td><code>$user</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The target username to add the subject channel to.</td>
        </tr>  
        <tr>
            <td><code>$chan</code></td>
            <td>Required</td>
            <td>string</td>
            <td>The subject channel to perform the query with.</td>
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

$followers = $interface->followChan('test_user_1', 'testchannel1', 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

If successful:
```json
true
```

If service was unavailable or an error occured (includes authentication errors):

```json
false
```

## `unfollowChan()`  

Grabs a list of the channels followed by a specified user.

<code>Authenticated: </code> user_follows_edit

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
            <td><code>$user</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The target username to add the subject channel to.</td>
        </tr>  
        <tr>
            <td><code>$chan</code></td>
            <td>Required</td>
            <td>string</td>
            <td>The subject channel to perform the query with.</td>
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

$followers = $interface->unfollowChan('test_user_1', 'testchannel1', 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

If successful:
```json
true
```

If service was unavailable or an error occured (includes authentication errors):

```json
false
```