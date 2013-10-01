# Authentication  

***  

These calls handle everything about authentication, generation of tokens and checking tokens.  

| Call | Description |
| ---- | ----------- |
| [twitch::generateToken()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#twitchgeneratetoken) | Generates an OAuth token. |
| [twitch::checkToken()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#twitchchecktoken) | Checks what scopes a provided OAuth token is allowed and the state of it |
| [twitch::generateAuthorizationURL()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#twitchgenerateauthorizationurl) | Generates an authorization URL for a user to authorize your application. |
| [twitch::retrieveRedirectCode()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#twitchretrieveredirectcode) | Retrieves the code out of a string URL if the code was not properly returned on redirect. |  

## `twitch::generateToken()`  

Generates an OAuth token for use in authenticated calls or may be called standalone to generate a token manually. Returns an unkeyed array with the first row returned as the OAuth token and the second the array of all returned scopes. 

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
            <td><code>$code</code></td>
            <td>required</td>
            <td>string</td>
            <td>The authorization code returned when the user authorized your application.</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
$testToken = twitch::generateToken('abcdefghijklmnopqrstuvwxyz12345');
```

### Example Return

```json
{
  "token": "jaxvvop7l6oypwg8bwk38nsozliakd3",
  "scopes": {
    "0": "user_read",
    "1": "user_blocks_edit"
  }
}
```

## `twitch::checkToken()`  



## `twitch::generateAuthorizationURL()`  

Generates an authorization URL to redirect your user to the Twitch page for your application.

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
            <td><code>$grantType</code></td>
            <td>required</td>
            <td>array</td>
            <td>An array of all string grant types you wish to request from the user.</td>
        </tr>
    </tbody>
</table>

### Example Call  

```php
$redirectURL = twitch::generateAuthorizationURL(array('user_read', 'user_blocks_edit'));
```

### Example Return

```json
"https://api.twitch.tv/kraken/oauth2/authorize?response_type=code&client_id=1234123412341234123412341234123&redirect_uri=http://www.testurl.com/return.php&scope=user_read+user_blocks_edit"
```

## `twitch::retrieveRedirectCode()`  
