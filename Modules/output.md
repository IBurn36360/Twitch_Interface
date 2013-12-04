# Output

***  

These functions aid in generating errors and function output.  These calls are, by default, not able to do anything and all output is disabled due to that.  In order to enable output, simply add your output code into the functions like the examples show.

| Call | Description |
| ---- | ----------- |
| [generateError()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/output.md#generateerror) | Handles output for all errors encountered by the interface.  Almost all error output is authentication issues. |
| [generateOutput()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/output.md#generateoutput) | Handles all function output, including function init and walkthrough.  Refer to the [output config](https://github.com/IBurn36360/Twitch_Interface/blob/master/configuration.md#twitch_debuglevels) for more information. |

***

## `generateError()`

Handles output for all errors encountered by the interface.  Almost all error output is authentication issues.

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
            <td><code>$errNo</code></td>
            <td>Required</td>
            <td>int</td>
            <td>The error number reported.</td>
        </tr>
        <tr>
            <td><code>$errStr</code></td>
            <td>Required</td>
            <td>string</td>
            <td>The error string reported.</td>
        </tr>
        <tr>
            <td><code>$return</code></td>
            <td>Optional</td>
            <td>string</td>
            <td>The string return that caused the error if supplied.</td>
        </tr>
    </tbody>
</table>

### Use

Unlike most of the documented functions, you can not directly interact with this function unless you extend the class.  What this documentation is for is to show how to add your own ability to record the errors from the interface for development or logging use.

Writing to a file

```php
    private function generateError($errNo, $errStr, $return = null)
    {
        // Enter your output format code here
        
        // Check to see if the file exists
        if (!file_exists('./error_log.php'))
        {
            $handle = @fopen('./error_log.php', 'a');
            fwrite($handle, '<?php exit; ?>' . "\n");
        } else {
            $handle = @fopen('./error_log.php', 'a');
        }
        
        // Write the log
        @fwrite($handle, $errNo . ':' . $errStr . "\n");
        @fclose($handle);
    }
```

***

## `generateOutput()`

Handles output for all errors encountered by the interface.  Almost all error output is authentication issues.

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
            <td><code>$function</code></td>
            <td>Required</td>
            <td>string</td>
            <td>The function name generating output.</td>
        </tr>
        <tr>
            <td><code>$errStr</code></td>
            <td>Required</td>
            <td>string</td>
            <td>The output string.</td>
        </tr>
        <tr>
            <td><code>$outputLevel</code></td>
            <td>Optional</td>
            <td>int</td>
            <td>The required level of output requred for the output to be parsed. Refer to the <a href="https://github.com/IBurn36360/Twitch_Interface/blob/master/configuration.md#twitch_debuglevels">debug level configuration</a>.</td>
        </tr>
    </tbody>
</table>

### Use

Unlike most of the documented functions, you can not directly interact with this function unless you extend the class.  What this documentation is for is to show how to add your own ability to record the output from the interface for development or logging use.

Writing to a file

```php
    private function generateOutput($function, $errStr, $outputLevel = 4)
    {
        global $twitch_configuration;
        
        // Our debug level needs to be lower than the suppression level
        if ($twitch_configuration['DEBUG_SUPPRESSION_LEVEL'] >= $outputLevel)
        {
            // Enter your output format code here
            
            // Check to see if the file exists
            if (!file_exists('./output_log.php'))
            {
                $handle = @fopen('./output_log.php', 'a');
                fwrite($handle, '<?php exit; ?>' . "\n");
            } else {
                $handle = @fopen('./output_log.php', 'a');
            }
            
            // Write the log
            @fwrite($handle, $function . '=>' . $errStr . "\n");
            @fclose($handle);
        }
    }
```