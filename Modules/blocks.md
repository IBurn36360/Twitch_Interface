# Blocks

***  

These calls handle everything reguarding blocked users.  This includes listing them, adding them and removing them.  All of these calls are authenticated.

| Call | Description |
| ---- | ----------- |
| [twitch::getBlockedUsers()]() | Grabs a list of all blocked user objects to limit or end of list. |
| [twitch::addBlockedUser()]() | Attempts to add a user to your list of blocked users. |
| [twitch::removeBlockedUser()]() | Attempts to remove a user from your list of blocked users. |

***  

## `twitch::getBlockedUsers()`  

Attempts to grab a list of all blocked user objects to limit or end of listing.

<code>Authenticated: </code> user_blocks_read

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
            <td><code>$chan</code></td>
            <td>required</td>
            <td>string</td>
            <td>This is the channel name to grab the blocked users list from. (target channel in call)</td>
        </tr>
        <tr>
            <td><code>$limit</code></td>
            <td>optional (defaults to -1)</td>
            <td>int</td>
            <td>The high edge limit of rows to return for the call.  Should there be more rows to the list than this value, this is the limit of rows that will be retuned instead.  -1 is a limitless return (theoretically)</td>
        </tr>
        <tr>
            <td><code>$offset</code></td>
            <td>optional (defaults to 0)</td>
            <td>int</td>
            <td>The numbeer of rows to offset the call by.  Of instance, if the integer 50 is supplied, will skip over the first 50 returns completely and then apply the limit for the calls.</td>
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
$testToken = twitch::getBlockedUsers('testchannel1', 100, 10, 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

### Example Return

If successful:

```json
{
  "testuser11": { [Blocks object returned from Twitch](https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md#example-response)
  },
  "testuser12": {
  }
}
```

If no token was returned:
```json
{
  "token": false,
  "scopes": {
  }
}
```
