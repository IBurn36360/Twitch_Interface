# Blocks

***  

These calls handle everything reguarding blocked users.  This includes listing them, adding them and removing them.  All of these calls are authenticated.

| Call | Description |
| ---- | ----------- |
| [twitch::getBlockedUsers()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/blocks.md#twitchgetblockedusers) | Grabs a list of all blocked user objects to limit or end of list. |
| [twitch::addBlockedUser()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/blocks.md#twitchaddblockeduser) | Attempts to add a user to your list of blocked users. |
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
            <td>This is the channel name to grab the blocked users list from. (target channel in call)</td>
        </tr>
        <tr>
            <td><code>$limit</code></td>
            <td>optional <br />(defaults to -1)</td>
            <td>int</td>
            <td>The high edge limit of rows to return for the call.  Should there be more rows to the list than this value, this is the limit of rows that will be retuned instead.  -1 is a limitless return (theoretically)</td>
        </tr>
        <tr>
            <td><code>$offset</code></td>
            <td>optional <br />(defaults to 0)</td>
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

[Blocks object returned from Twitch](https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md#example-response)

```json
{
  "testuser11": { [Blocks object returned from Twitch]
  },
  "testuser12": {
  }
}
```

If no users were returned:

```json
{

}
```

If authentication failiure:  (Will pass an error out to the output functions before returning)

```json
{

}
```

***  

## `twitch::addBlockedUser()`  

Attempts to add a user to a channel's list of blocked users.

<code>Authenticated: </code> user_blocks_edit

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
            <td>string</td>
            <td>This is the channel name to add the blocked user to.</td>
        </tr>
        <tr>
            <td><code>$username</code></td>
            <td>required</td>
            <td>string</td>
            <td>This is the username of the user to add to said channel's blocks list.</td>
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
$testToken = twitch::addBlockedUser('testchannel1', 'testUser1', 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

### Example Return

If user was blocked:

```json
true
```

If user was either not found or was unable to be blocked:

```json
false
```

If authentication failiure:  (Will pass an error out to the output functions before returning)

```json
false
```

***  

## `twitch::removeBlockedUser()`  

Attempts to reamove a user from a channel's list of blocked users.

<code>Authenticated: </code> user_blocks_edit

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
            <td>string</td>
            <td>This is the channel name to add the blocked user to.</td>
        </tr>
        <tr>
            <td><code>$username</code></td>
            <td>required</td>
            <td>string</td>
            <td>This is the username of the user to add to said channel's blocks list.</td>
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
$testToken = twitch::removeBlockedUser('testchannel1', 'testUser1', 'jaxvvop7l6oypwg8bwk38nsozliakd3', '1234123412341234123412341234');
```

### Example Return

If user was successfully unblocked:

```json
true
```

If user was unable to be blocked or was not on target channels list of blocked users:

```json
false
```

If authentication failiure:  (Will pass an error out to the output functions before returning)

```json
false
`
