# Subscriptions

These calls handle grabbing subscriber lists and checking if a user is suscribed to a channel.

| Call | Description |
| ---- | ----------- |
| [getChannelSubscribers()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/subscriptions.md#getchannelsubscribers) | Gets a lits of all users subscribed to a channel. |
| [checkChannelSubscription()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/subscriptions.md#checkchannelsubscription) | Checks to see if a user is subscribed to a specified channel from the channel side. |
| [checkUserSubscription()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/subscriptions.md#checkusersubscription) | Checks to see if a user is subscribed to a specified channel from the user side |

***

## `getChannelSubscribers()`

Gets a lits of all users subscribed to a channel.

<code>Authenticated: </code> channel_subscriptions

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
            <td>bool</td>
            <td>The channel you wish to grab subscribers for</td>
        </tr>
        <tr>
            <td><code>$limit</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The high limit of subscribers to grab.</td>
        </tr>            
        <tr>
            <td><code>$offset</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The starting offset of the list.</td>
        </tr>
        <tr>
            <td><code>$direction</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The sorting durection of the list.  Accepts <code>asc</code> <code>desc</code></td>
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
        <tr>
            <td><code>$returnTotal</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Returns a _total row in the array</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$subscribers = $interface->getChannelSubscribers('testChannel1', -1, 0, 'desc', 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234', true);
```

### Example Return

If successful:

```json
"_total": 448,
"testuser": {
  "_id": "88d4621871b7274c34d5c3eb5dad6780c8533318",
  "user": {
    "_id": 38248673,
    "logo": null,
    "staff": false,
    "created_at": "2012-12-06T00:32:36Z",
    "name": "testuser",
    "updated_at": "2013-02-06T21:27:46Z",
    "display_name": "testuser",
    "_links": {
      "self": "https://api.twitch.tv/kraken/users/testuser"
    }
  },
  "created_at": "2013-02-06T21:33:33Z",
  "_links": {
    "self": "https://api.twitch.tv/kraken/channels/test_channel/subscriptions/testuser"
  }
},
...
```

If no subscribers were returned or service was unavailable or if authentication failure:

```json
{

}
```

***

## `checkChannelSubscription()`

Checks to see if a user is subscribed to a specified channel from the channel side.

<code>Authenticated: </code> channel_subscriptions

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
            <td>bool</td>
            <td>Username of the user check against.</td>
        </tr>
        <tr>
            <td><code>$chan</code></td>
            <td>required</td>
            <td>string</td>
            <td>Channel name of the channel to check against.</td>
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

$subscribers = $interface->checkChannelSubscription('testChannel1', 'test_channel', 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

### Example Return

If the user is subscribed to the channel:

```json
true
```

If the user is not subscribed to the channel or service was unavailable or if authentication failure:

```json
false
```

***

## `checkUserSubscription()`

Checks to see if a user is subscribed to a specified channel from the user side

<code>Authenticated: </code> channel_check_subscription

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
            <td>bool</td>
            <td>Username of the user check against.</td>
        </tr>
        <tr>
            <td><code>$chan</code></td>
            <td>required</td>
            <td>string</td>
            <td>Channel name of the channel to check against.</td>
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

$subscribers = $interface->checkUserSubscription('testChannel1', 'test_channel', 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

### Example Return

If the user is subscribed to the channel:

```json
true
```

If the user is not subscribed to the channel or service was unavailable or if authentication failure:

```json
false
```
