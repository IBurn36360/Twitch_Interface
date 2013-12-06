# cURL

***

This is the light weight cURL implimentation that the interface uses.  All calls use this implimentation, however, you can not interact with the functions unless you extend the class.

| Call | Description |
| ---- | ----------- |
| [cURL_get()]() | Handles all cURL GET style calls. |
| [cURL_post()]() | Handles all cURL POST style calls. |
| [cURL_put()]() | Handles all cURL PUT style calls. |
| [cURL_delete()]() | Handles all cURL DELETE style calls. |

***

## `cURL_get()`

Handles all cURL GET style calls.

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
            <td>The URL you wish to access in the call.</td>
        </tr>
        <tr>
            <td><code>$get</code></td>
            <td>optional</td>
            <td>array</td>
            <td>All GET data required for the call.</td>
        </tr>
        <tr>
            <td><code>$options</code></td>
            <td>optional</td>
            <td>array</td>
            <td>Additional options for the cURL environment.</td>
        </tr>
        <tr>
            <td><code>$returnStatus</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Sets the function to return the int HTTPD status of the call.<br />Is automatically set to tru on 503 returns and 0 returns.</td>
        </tr>
    </tbody>
</table>

***

## `cURL_post()`

Handles all cURL POST style calls.

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
            <td>The URL you wish to access in the call.</td>
        </tr>
        <tr>
            <td><code>$post</code></td>
            <td>optional</td>
            <td>array</td>
            <td>All POST data required for the call.</td>
        </tr>
        <tr>
            <td><code>$options</code></td>
            <td>optional</td>
            <td>array</td>
            <td>Additional options for the cURL environment.</td>
        </tr>
        <tr>
            <td><code>$returnStatus</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Sets the function to return the int HTTPD status of the call.<br />Is automatically set to tru on 503 returns and 0 returns.</td>
        </tr>
    </tbody>
</table>

***

## `cURL_put()`

Handles all cURL PUT style calls.

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
            <td>The URL you wish to access in the call.</td>
        </tr>
        <tr>
            <td><code>$put</code></td>
            <td>optional</td>
            <td>array</td>
            <td>All PUT data required for the call.</td>
        </tr>
        <tr>
            <td><code>$options</code></td>
            <td>optional</td>
            <td>array</td>
            <td>Additional options for the cURL environment.</td>
        </tr>
        <tr>
            <td><code>$returnStatus</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Sets the function to return the int HTTPD status of the call.<br />Is automatically set to tru on 503 returns and 0 returns.</td>
        </tr>
    </tbody>
</table>

***

## `cURL_delete()`

Handles all cURL DELETE style calls.

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
            <td>The URL you wish to access in the call.</td>
        </tr>
        <tr>
            <td><code>$post</code></td>
            <td>optional</td>
            <td>array</td>
            <td>All POST data required for the call.</td>
        </tr>
        <tr>
            <td><code>$options</code></td>
            <td>optional</td>
            <td>array</td>
            <td>Additional options for the cURL environment.</td>
        </tr>
        <tr>
            <td><code>$returnStatus</code></td>
            <td>optional</td>
            <td>bool</td>
            <td>Sets the function to return the int HTTPD status of the call.<br />Is automatically set to tru on 503 returns and 0 returns.</td>
        </tr>
    </tbody>
</table>