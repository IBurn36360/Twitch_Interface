# Helpers

***  

These functions aid the Interface

| Call | Description |
| ---- | ----------- |
| [getURLParamValue()]() | Retrieves the value of a passed parameter in a URL string, positionally insensitive. |
| [getURLParams()]() | Grabs an array of all URL parameters and values. |
| [get_iterated()]() | This function iterates through calls. |

***  

## `getURLParamValue()`  

Retrieves the value of a passed parameter in a URL string, positionally insensitive.

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
            <td><code>$url</code></td>
            <td>required</td>
            <td>string</td>
            <td>The string URL to check through</td>
        </tr>
        <tr>
            <td><code>$param</code></td>
            <td>required</td>
            <td>string</td>
            <td>The string parameter to search for</td>
        </tr>
        <tr>
            <td><code>$maxMatchLength</code></td>
            <td>optional</td>
            <td>int</td>
            <td>Maximum number of chars to search through before failing the search</td>
        </tr>
        <tr>
            <td><code>$matchSymbols</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>This sets the regex to search for symbols in the key AND value</td>
        </tr>
    </tbody>
</table>

### Example Call

```php
$value = getURLParamValue('http://www.test.com?var1=1&var2=2&var3=3', 'var2', 40, false);
```

### Example Return

```json
'2'
```

***

## `getURLParams()`  

Grabs an array of all URL parameters and values.

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
            <td><code>$url</code></td>
            <td>required</td>
            <td>string</td>
            <td>The string URL to check through</td>
        </tr>
        <tr>
            <td><code>$maxMatchLength</code></td>
            <td>optional</td>
            <td>int</td>
            <td>Maximum number of chars to search through before failing the search</td>
        </tr>
        <tr>
            <td><code>$matchSymbols</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>This sets the regex to search for symbols in the key AND value</td>
        </tr>
    </tbody>
</table>

### Example Call

```php
$params = getURLParams('http://www.test.com?var1=1&var2=2&var3=3', 40, false);
```

### Example Return

```json
{
    "var1": "1",
    "var2": "2",
    "var3": "3"
}
```

***

## `get_iterated()`  

This function iterates through calls.  You can not interact with this function unless you extend the class.

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
            <td><code>$functionName</code></td>
            <td>required</td>
            <td>string</td>
            <td> The calling function's identity, used for logging only</td>
        </tr>
        <tr>
            <td><code>$url</code></td>
            <td>required</td>
            <td>string</td>
            <td>The URL to iterate on</td>
        </tr>
        <tr>
            <td><code>$options</code></td>
            <td>required</td>
            <td>array</td>
            <td>The array of options to use for the iteration</td>
        </tr>
        <tr>
            <td><code>$limit</code></td>
            <td>required</td>
            <td>int</td>
            <td>The limit of the query</td>
        </tr>
        <tr>
            <td><code>$offset</code></td>
            <td>required</td>
            <td>int</td>
            <td>The starting offset of the query</td>
        </tr>
        <tr>
            <td><code>$arrayKey</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The key to look into the array for for data</td>
        </tr>
        <tr>
            <td><code>$authKey</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The OAuth token for the session of calls</td>
        </tr>
        <tr>
            <td><code>$hls</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Limit the calls to only streams using HLS</td>
        </tr>
        <tr>
            <td><code>$direction</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The sorting direction</td>
        </tr>
        <tr>
            <td><code>$channels</code></td>
            <td>optional</td>
            <td>array</td>
            <td>The array of channels to be included in the query</td>
        </tr>
        <tr>
            <td><code>$embedable</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Limit query to only channels that are embedable</td>
        </tr>
        <tr>
            <td><code>$client_id</code></td>
            <td>optional</td>
            <td>string</td>
            <td>Limit searches to only show content from the applications of the supplied client ID</td>
        </tr>
        <tr>
            <td><code>$broadcasts</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Limit returns to only show broadcasts</td>
        </tr>
        <tr>
            <td><code>$period</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The period of time in which  to limit the search for</td>
        </tr>
        <tr>
            <td><code>$game</code></td>
            <td>optional</td>
            <td>string</td>
            <td>The game to limit the query to</td>
        </tr>
    </tbody>
</table>