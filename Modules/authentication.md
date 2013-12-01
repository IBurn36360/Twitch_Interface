# Authentication  

***  

These calls handle everything about authentication, generation of tokens and checking tokens.  

| Call | Description |
| ---- | ----------- |
| [generateToken()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#twitchgeneratetoken) | Generates an OAuth token. |
| [checkToken()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#twitchchecktoken) | Checks what scopes a provided OAuth token is allowed and the state of it |
| [generateAuthorizationURL()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#twitchgenerateauthorizationurl) | Generates an authorization URL for a user to authorize your application. |
| [retrieveRedirectCode()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#twitchretrieveredirectcode) | Retrieves the code out of a string URL if the code was not properly returned on redirect. |  

***  

## `generateToken()`  

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
// Instancize the class as an object
$interface = new twitch;

$testToken = $interface->generateToken('abcdefghijklmnopqrstuvwxyz12345');
```

### Example Return

If successful:

```json
{
  "token": "jaxvvop7l6oypwg8bwk38nsozliakd3",
  "scopes": {
    "0": "user_read",
    "1": "user_blocks_edit"
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

***  

## `checkToken()`  

Does several functions, first, checks the validity of a token, of it is valid, will also return the array of all scopes granted to the token.  

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
            <td><code>$authToken</code></td>
            <td>required</td>
            <td>string</td>
            <td>The OAuth token you wish to verify.</td>
        </tr>
    </tbody>
</table>

### Example Call 

```php
// Instancize the class as an object
$interface = new twitch;

$testToken = $interface->checkToken('jaxvvop7l6oypwg8bwk38nsozliakd3');
```

### Example Return

If successful:

```json
{
  "token": "jaxvvop7l6oypwg8bwk38nsozliakd3",
  "scopes": {
    "0": "user_read",
    "1": "user_blocks_edit"
  },
  "name": "testUser1"
}
```

If the token was no longer valid:  

```json
{
  "token": false,
  "scopes": {
  },
  "name": ""
}
```

***  

## `generateAuthorizationURL()`  

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
// Instancize the class as an object
$interface = new twitch;

$redirectURL = $interface->generateAuthorizationURL(array('user_read', 'user_blocks_edit'));
```

### Example Return

```json
"https://api.twitch.tv/kraken/oauth2/authorize?response_type=code&client_secret=1234123412341234123412341234123&client_id=1234123412341234123412341234123&redirect_uri=http://www.testurl.com/return.php&scope=user_read+user_blocks_edit"
```

## `retrieveRedirectCode()`  

Grabs the authorization code out of a string URL, useful if you do not have your URL parameters handled, or if you want to have users manually put in the code themselves.  This function is positionally insensitive, meaning that the order of parameters does NOT matter.

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
            <td><code>$url</code></td>
            <td>required</td>
            <td>array</td>
            <td>The string URL to grab the authorization code out from.</td>
        </tr>
    </tbody>
</table>

### Example Call  

```php
// Instancize the class as an object
$interface = new twitch;

$code = $interface->retrieveRedirectCode('http://www.testurl.com/return.php?client_id=1234123412341234123412341234123&redirect_uri=http://www.testurl.com/return.php&scope=user_read+user_blocks_edit?code=1234123412341234123412341234123');
```

### Example Return

```json
"1234123412341234123412341234123"
```
