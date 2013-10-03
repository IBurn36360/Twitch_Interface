# Configuration  

***  

| Set | Description |
| --- | ----------- |
| [Twitch Credentials](https://github.com/IBurn36360/Twitch_Interface/blob/master/configuration.md#twitch-credentials) | This is your set of API credentials for use in authenticated calls or in use with generating tokens |
| [Config Options](https://github.com/IBurn36360/Twitch_Interface/blob/master/configuration.md#config-options) | This is the set of options that control how the interface works and what options are enabled/diabled |


## Twitch Credentials

***  

<table>
    <thead>
        <tr>
            <th>Variable</th>
            <th>Default Value</th>
            <th width=50>Type</th>
            <th width=100%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>$twitch_clientKey</td>
            <td>''</td>
            <td>String</td>
            <td>Defines the Twitch value client_key</td>
        </tr>
        <tr>
            <td>$twitch_clientSecret</td>
            <td>''</td>
            <td>String</td>
            <td>Defines the Twitch value client_secret</td>
        </tr>
        <tr>
            <td>$twitch_clientUrl</td>
            <td>String</td>
            <td>''</td>
            <td>Defines the Twitch value client_uri</td>
        </tr>
    </tbody>
</table>

All of these values are empty strings by default and can be easily chaged to be a string with a space or any value as a short-circuit to allow the interface to bypass its credential check.  in order to use the interface you MUST either add any value into each of the 3 strings or add your credentials in order to perform all generation calls.

## Config options

***  

This is a list of all configuration options found in the interface between lines 36 to 56.  

### $twitch_DebugLevels

***  

<table>
    <thead>
        <tr>
            <th>Level</th>
            <th width=100%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>FINE</td>
            <td>Sets the output functions to only accept initialization output.</td>
        </tr>
        <tr>
            <td>FINER</td>
            <td>Sets the output functions to output initialization output and any variable updates or checks</td>
        </tr>
        <tr>
            <td>FINEST</td>
            <td>Sets the output functions to accept all output <b>EXCEPT</b> raw returns</td>
        </tr>
        <tr>
            <td>ALL</td>
            <td>Sets the output functions to accept all output <b>including</b> raw returns.  This is <b>NOT</b> a recommended setting unless you are using it for specific debugging.</td>
        </tr>
    </tbody>
</table>

### $twitch_configuration  

***  

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Default Value</th>
            <th width="50">Type</th>
            <th width=100%>Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>CALL_LIMIT_SETTING</td>
            <td>CALL_LIMIT_MAX</td>
            <td>String</td>
            <td>Set limit for the number of returns in one call, used to seperate calls out into segments of a specified length.  Accepted values are <code>CALL_LIMIT_DEFAULT</code>, <code>CALL_LIMIT_DOUBLE</code> and <code>CALL_LIMIT_MAX</code>.</td>
        </tr>
        <tr>
            <td>KEY_NAME</td>
            <td>name</td>
            <td>String</td>
            <td>This sets the interface keys to either <code>name</code> or <code>display_name</code>, or even any key that you wish the interface to use.  It is safer to use <code>name</code> as your key as this is a static key to use and needs to be change by a Twitch staff member.</td>
        </tr>
        <tr>
            <td>DEFAULT_TIMEOUT</td>
            <td>5</td>
            <td>Integer</td>
            <td>This sets the default time, in seconds, to await for a successful connection to the Twitch Kraken API servers.  This does not affect how long the interface will await to finish recieving data from Twitch, only the time to establish a connection.</td>
        </tr>
        <tr>
            <td>DEFAULT_RETURN_TIMEOUT</td>
            <td>20</td>
            <td>Integer</td>
            <td>This sets the default time, in seconds, to wait to finish downloading data from thw Twitch Kraken API servers.  This does not affect how long the interface will await for a connection to the Twitch servers, only how long it will wait while recieving data.</td>
        </tr>
        <tr>
            <td>API_VERSION</td>
            <td>3</td>
            <td>Integer</td>
            <td>This sets what version of the API to use from the Twitch Kraken API servers.  This is set in the header and can affect returns.  Currently ONLY tested with V3, but will soon accept all V2 calls as well.</td>
        </tr>
        <tr>
            <td>TOKEN_SEND_METHOD</td>
            <td>HEADER</td>
            <td>String</td>
            <td>This sets how an OAuth token is sent to validate authenticated calls.  Accepts either <code>HEADER</code> or <code>QUERY</code>.  It is recommended that you always use <code>HEADER</code>.</td>
        </tr>
        <tr>
            <td>RETRY_COUNTER</td>
            <td>3</td>
            <td>Integer</td>
            <td>This sets how many times the interface will attemppt tp rety a call in iteration before giving up.  This will accept any integer.</td>
        </tr>
        <tr>
            <td>DEBUG_SUPPRESSION_LEVEL</td>
            <td>$twitch_debugLevels['FINE']</td>
            <td>Array[Key]</td>
            <td>This sets what debug suppression level that the interface will use when checking what output is passed to the user defined functions.  This accepts one of four values: <code>$twitch_debugLevels['FINE']</code>, <code>$twitch_debugLevels['FINER']</code>, <code>$twitch_debugLevels['FINEST']</code> and <code>$twitch_debugLevels['ALL']</code></td>
        </tr>
        <tr>
            <td>CALL_LIMIT_DEFAULT</td>
            <td>25</td>
            <td>String</td>
            <td>This sets the upper limit of any single call to 25.  This is a value that should <b>NOT</b> be changed under any circumstances unless you know how Twitch handles its limits.</td>
        </tr>
        <tr>
            <td>CALL_LIMIT_DOUBLE</td>
            <td>50</td>
            <td>String</td>
            <td>This sets the upper limit of any single call to 50.  This is a value that should <b>NOT</b> be changed under any circumstances unless you know how Twitch handles its limits.</td>
        </tr>
        <tr>
            <td>CALL_LIMIT_MAX</td>
            <td>100</td>
            <td>String</td>
            <td>This sets the upper limit of any single call to 100.  This is a value that should <b>NOT</b> be changed under any circumstances unless you know how Twitch handles its limits.</td>
        </tr>
    </tbody>
</table>
