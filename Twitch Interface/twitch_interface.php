<?php
/**
 * This Twitch Interface is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This Twitch Interface is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * A copy of the GNU GPLV3 license can be found at http://www.gnu.org/licenses/
 * or can be found in the folder distributed with the software.
 * 
 * Author: Anthony 'IBurn36360' Diaz - 2013
 */

// Make sure we meet our dependency requirements
if (!function_exists('curl_version')) trigger_error('cURL is not currently installed on your server, please install cURL');
if (!function_exists('json_decode')) trigger_error('PECL JSON or pear JSON is not installed, please install either PECL JSON or compile pear JSON');

// Define some things in the global scope (yes...global, if you want to make it defined in the class scope, go for it)

// Your API info goes here
$twitch_clientKey = '';
$twitch_clientSecret = '';
$twitch_clientUrl = '';

// Did our user forget any of their credentials?
if (($twitch_clientKey === '' || null) || ($twitch_clientSecret === '' || null) || ($twitch_clientUrl === '' || null))
{
    trigger_error('Please enter your Kraken API credentials into the main file on lines 26, 27 and 28');
}

$twitch_debugLevels = array(
    'FINE' => 1,   // Displays only call inits
    'FINER' => 2,  // Displays variable changes
    'FINEST' => 3, // Displays all output other than RAW returns
    'ALL' => 4,    // Displays all output possible
);

// This holds many of the limitation settings for performing calls, stored as an array for ease of calling [Keyed]
$twitch_configuration = array(
    'CALL_LIMIT_SETTING'      => 'CALL_LIMIT_MAX', // This sets the query limit for all calls
    'KEY_NAME'                => 'name',           // This controls how the key is determined, valid values are 'name' and 'display_name'
    'DEFAULT_TIMEOUT'         => 5,                // This sets the timeout for the cURL interaction for the Kraken servers (connect timeout)
    'DEFAULT_RETURN_TIMEOUT'  => 20,               // This sets the default return timeout for all returns (Post connection established)
    'API_VERSION'             => 3,                // This sets what API version to use.  Specifies that value in the header
    'TOKEN_SEND_METHOD'       => 'HEADER',         // This sets how any OAuth tokens are sent.  Valid options are 'HEADER' and 'QUERY'
    'RETRY_COUNTER'           => 3,                // This sets the number of retries the interface will do when faced with status 0 returns
    'DEBUG_SUPPRESSION_LEVEL' => $twitch_debugLevels['FINE'], // This sets the maximum debug level that gets to output, ALL sets to display all returns, including RAW JSON returns
    'CALL_LIMIT_DEFAULT'      => '25',
    'CALL_LIMIT_DOUBLE'       => '50',
    'CALL_LIMIT_MAX'          => '100'
);

// This is a helper function that I have decided to make available outside of the class scope
if (!function_exists('getURLParamValue'))
{
    /**
     * Retrieves the value of a passed parameter in a URL string, positionally insensitive
     * 
     * @param $url - [string] URL string provided
     * @param $param - [string] The string parameter name to look for
     * @param $maxMatchLength - [int] The maximum match length for the value, defaults to 40
     * @param $matchSymbols - [bool] Sets the search to look for symbols in the value
     * 
     * @return $value - [string] The string value of that parameter searched for
     */ 
    function getURLParamValue($url, $param, $maxMatchLength = 40, $matchSymbols = false)
    {
        if ($matchSymbols)
        {
            $match = '[\w._@#$%\^\*\(\)!+\\|-]';
        } else {
            $match = '[\w]';
        }
        
        //init and dump the chars into the regex
        $param_regex = '';
        $chars = str_split($param);
        
        // Build a char match for the param, case insensitive
        foreach ($chars as $char)
        {
            $param_regex .= '[' . strtoupper($char) . strtolower($char) . ']';
        }
        
        $value_arr = array();
        preg_match('(' . $param_regex . '=' . $match . '{1,' . $maxMatchLength . '})', $url, $value_arr);
        
        // Dump to a string
        $value = $value_arr[0];
        
        // Strip out the identifier
        $value = preg_replace('([a-z]{1,40}=)', '', $value);
        
        // Clean memory
        unset($url, $param, $maxMatchLength, $matchSymbols, $match, $param_regex, $chars, $char, $value_arr);
        
        return $value;
    }
}

// This is a helper function that I have decided to make available outside of the class scope
if (!function_exists('getURLParams'))
{
    /**
     * Grabs an array of all URL parameters and values
     * 
     * @param $url - [string] URL string provided
     * @param $maxMatchLength - [int] The maximum match length for all matches, defaults to 40
     * @param $matchSymbols - [bool] Sets the search to look for symbols in the value
     * 
     * @return $parameters - [array] A keyed array of all values returned, key is param
     */
     function getURLParams($url, $maxMatchLength = 40, $matchSymbols = false)
     {
        if ($matchSymbols)
        {
            $match = '[\w._@#$%\^\*\(\)!+\\|-]';
        } else {
            $match = '[\w]';
        }
        
        $matches = array();
        $parameters = array();
        preg_match('(([\w]{1,' . $maxMatchLength . '}=' . $match . '{1,' . $maxMatchLength . '}[&]{0,1}){1,' . $maxMatchLength . '})', $url, $matches);

        $split = split('&', $matches[0]);
        
        foreach ($split as $row)
        {
            $splitRow = split('=', $row);
            $parameters[$splitRow[0]] = $splitRow[1];
        }
        
        unset($url, $maxMatchLength, $matchSymbols, $match, $matches, $split, $row, $splitRow);
        
        return $parameters;
     }
}

class twitch
{           
    /**
     * This allows users to bind into their error systems, here for compatability, defaults to echos for testing
     * 
     * @param $errNo - [int] Error number of the error tossed
     * @param $errStr - [str] Error string returned for the error tossed
     * @param $return - [mixed] The return provided to the query
     * 
     * @return User defined return
     */ 
    private function generateError($errNo, $errStr, $return = null)
    {
        // Enter your output format code here
        
    }
    
    /**
     * This allows users to bind into their output systems, here for compatability, defaults to echo's for testing
     * 
     * @param $function - [string] String name of the function or alias being called
     * @param $errStr - [string] debug output to be passed
     * @param $outputLevel - [int] The level of the output passed, used in output suppression, Default level of output is 5 (Lowest)
     * 
     * @return User defined return
     */ 
    private function generateOutput($function, $errStr, $outputLevel = 4)
    {
        global $twitch_configuration;
        
        // Our debug level needs to be lower than the suppression level
        if ($twitch_configuration['DEBUG_SUPPRESSION_LEVEL'] >= $outputLevel)
        {
            // Enter your output format code here
            
        }
    }
    
    /**
     * This operates a GET style command through cURL.  Will return raw data as an associative array
     * 
     * @param $url - [string] URL supplied for the connection
     * @param $get - [array]  All supplied data used to define what data to get
     * @param $options - [array] Set options for the cURL session
     * @param $returnStatus - [bool] Sets the function to return the numerical status instead of the raw result
     * 
     * @return $result - [mixed] The raw return of the resulting query or the numerical status
     */
    private function cURL_get($url, array $get = array(), array $options = array(), $returnStatus = false)
    {
        global $twitch_configuration;
        $functionName = 'GET';
        
        self::generateOutput($functionName, 'Starting GET query', 1);
        
        // Specify the header
        
        if ((array_key_exists('oauth_token', $get) == 1) && ($twitch_configuration['TOKEN_SEND_METHOD'] == 'HEADER'))
        {
            $header = array('Accept: application/vnd.twitchtv.v' . $twitch_configuration['API_VERSION'] . '+json',
                'Authorization: OAuth ' . $get['oauth_token']);
            unset($get['oauth_token']);
        } else {
           $header = array('Accept: application/vnd.twitchtv.v' . $twitch_configuration['API_VERSION'] . '+json');
        }
        
        // Send the header info to the output
        foreach ($header as $row)
        {
            self::generateOutput($functionName, 'Header row => ' . $row, 3);
        }
        
        $cURL_URL = rtrim($url . '?' . http_build_query($get), '?');
        
        self::generateOutput($functionName, 'API Version set to: ' . $twitch_configuration['API_VERSION'], 3);
        
        $defaults = array(
            CURLOPT_URL => $cURL_URL, 
            CURLOPT_HEADER => 0, 
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_CONNECTTIMEOUT => $twitch_configuration['DEFAULT_RETURN_TIMEOUT'],
            CURLOPT_TIMEOUT => $twitch_configuration['DEFAULT_TIMEOUT'],
            CURLOPT_HTTPHEADER => $header
        );
        
        if (empty($options))
        {
            self::generateOutput($functionName, 'No additional options set', 3);
        }
        
        $handle = curl_init();
        
        if (function_exists('curl_setopt_array')) // Check to see if the function exists
        {
            self::generateOutput($functionName, 'Options set as an array', 3);
            curl_setopt_array($handle, ($options + $defaults));
        } else { // nope, set them one at a time
            foreach (($defaults + $options) as $key => $opt) // Options are set last so you can override anything you don't want to keep from defaults
            {
                self::generateOutput($functionName, 'Options set as individual values', 3);
                curl_setopt($handle, $key, $opt);
            }
        }
        
        self::generateOutput($functionName, 'Command GET => URL: ' . $cURL_URL, 2);
        
        foreach ($get as $param => $val)
        {
            if (is_array($val))
            {
                foreach ($val as $key => $value)
                {
                    self::generateOutput($functionName, 'GET option: [' . $param . '] ' . $key . '=>' . $value, 2);
                }
            } else {
                self::generateOutput($functionName, 'GET option: ' . $param . '=>' . $val, 2);
            }
        }
        
        $result = curl_exec($handle);
        $httpdStatus = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        
        // Check to see if the call existed
        if ($httpdStatus == 404) 
        {
            $errStr = curl_error($handle);
            $errNo = curl_errno($handle);
            self::generateError($errNo, $errStr, $result);
        }
        
        // Check to see if we got a null return and return 0 if the query nulled out
        if ($httpdStatus == 0)
        {
            $returnStatus = true;
        }
        
        curl_close($handle);
        
        self::generateOutput($functionName, 'Status Returned: ' . $httpdStatus, 3);
        self::generateOutput($functionName, 'Raw Return: ' . $result, 4);
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($url, $get, $options, $debug, $header, $cURL_URL, $defaults, $key, $opt, $k, $v, $handle, $row);
        
        // Are we returning the HHTPD status?
        if ($returnStatus)
        {
            self::generateOutput($functionName, 'Returning HTTPD status', 3);
            unset($result, $functionName);
            return $httpdStatus;
        } else {
            self::generateOutput($functionName, 'Returning result', 3);
            unset($httpdStatus, $functionName);
            return $result; 
        }
        
    }
    
    /**
     * This operates a POST style cURL command.  Will return success.
     * 
     * @param $url - [string] URL supplied for the connection
     * @param $post - [array] All supplied data used to define what data to post
     * @param $options - [array] Set options for the cURL session
     * @param $returnStatus - [bool] Sets the function to return the numerical status instead of the raw result
     * 
     * @return $result - [mixed] The raw return of the resulting query or the numerical status
     */ 
    private function cURL_post($url, array $post = array(), array $options = array(), $returnStatus = false)
    {
        global $twitch_configuration;
        $functionName = 'POST';
        $postfields = '';
        
        self::generateOutput($functionName, 'Starting POST query', 1);
        
        // Specify the header
        if ((array_key_exists('oauth_token', $post) == 1) && ($twitch_configuration['TOKEN_SEND_METHOD'] == 'HEADER'))
        {
            $header = array('Accept: application/vnd.twitchtv.v' . $twitch_configuration['API_VERSION'] . '+json',
                'Authorization: OAuth ' . $post['oauth_token']);
            unset($post['oauth_token']);
        } else {
           $header = array('Accept: application/vnd.twitchtv.v' . $twitch_configuration['API_VERSION'] . '+json');
        }
                
        // Send the header info to the output
        foreach ($header as $row)
        {
            self::generateOutput($functionName, 'Header row => ' . $row, 3);
        }
        
        self::generateOutput($functionName, 'API Version set to: ' . $twitch_configuration['API_VERSION'], 3);
        
        // Custom build the post fields
        foreach ($post as $field => $value)
        {
            $postfields .= $field . '=' . urlencode($value) . '&';
        }
        // Strip the trailing &
        $postfields = rtrim($postfields, '&');
        
        $default = array( 
            CURLOPT_CONNECTTIMEOUT => $twitch_configuration['DEFAULT_RETURN_TIMEOUT'],
            CURLOPT_TIMEOUT => $twitch_configuration['DEFAULT_TIMEOUT'],
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_URL => $url, 
            CURLOPT_POST => count($post),
            CURLOPT_HEADER => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_FRESH_CONNECT => 1, 
            CURLOPT_RETURNTRANSFER => 1, 
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_HTTPHEADER => $header
        );
        
        if (empty($options))
        {
            self::generateOutput($functionName, 'No additional options set', 3);
        }
        
        $handle = curl_init();
        
        if (function_exists('curl_setopt_array')) // Check to see if the function exists
        {
            self::generateOutput($functionName, 'Options set as an array', 3);
            curl_setopt_array($handle, ($options + $default));
        } else { // nope, set them one at a time
            foreach (($default + $options) as $key => $opt) // Options are set last so you can override anything you don't want to keep from defaults
            {
                self::generateOutput($functionName, 'Options set as individual values', 3);
                curl_setopt($handle, $key, $opt);
            }
        }
        
        self::generateOutput($functionName, 'command POST => URL: ' . $url, 2);
        
        foreach ($post as $param => $val)
        {
            if (is_array($val))
            {
                foreach ($val as $key => $value)
                {
                    self::generateOutput($functionName, 'POST option: [' . $param . '] ' . $key . '=>' . $value, 2);
                }
            } else {
                self::generateOutput($functionName, 'POST option: ' . $param . '=>' . $val, 2);
            }
        }
        
        $result = curl_exec($handle);
        $httpdStatus = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        
        // Check the HTTP error
        if ($httpdStatus == 404 || 0) 
        {
            $errStr = curl_error($handle);
            $errNo = curl_errno($handle);
            self::generateError($errNo, $errStr, $result); 
        }
        
        curl_close($handle);
        
        self::generateOutput($functionName, 'Status Returned: ' . $httpdStatus, 3);
        self::generateOutput($functionName, 'Raw Return: ' . $result, 4);
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($url, $post, $options, $debug, $postfields, $header, $field, $value, $postfields, $default, $errStr, $errNo, $handle, $row);
        
        // Are we returning the HHTPD status?
        if ($returnStatus)
        {
            self::generateOutput($functionName, 'Returning HTTPD status', 3);
            unset($result, $functionName);
            return $httpdStatus;
        } else {
            self::generateOutput($functionName, 'Returning result', 3);
            unset($httpdStatus, $functionName);
            return $result; 
        }
    }
    
    /**
     * This operates a PUT style cURL command.  Will return success.
     * 
     * @param $url - [string] URL supplied for the connection
     * @param $put - [array] All supplied data used to define what data to put
     * @param $options - [array] Set options for the cURL session
     * @param $returnStatus - [bool] Sets the function to return the numerical status instead of the raw result
     * 
     * @return $result - [mixed] The raw return of the resulting query or the numerical status
     */ 
    private function cURL_put($url, array $put = array(), array $options = array(), $returnStatus = false)
    {
        global $twitch_configuration;
        $functionName = 'PUT';
        $postfields = '';
        
        self::generateOutput($functionName, 'Starting PUT query', 1);
        
        // Specify the header
        if ((array_key_exists('oauth_token', $put) == 1) && ($twitch_configuration['TOKEN_SEND_METHOD'] == 'HEADER'))
        {
            $header = array('Accept: application/vnd.twitchtv.v' . $twitch_configuration['API_VERSION'] . '+json',
                'Authorization: OAuth ' . $post['oauth_token']);
            unset($post['oauth_token']);
        } else {
           $header = array('Accept: application/vnd.twitchtv.v' . $twitch_configuration['API_VERSION'] . '+json');
        }
                
        // Send the header info to the output
        foreach ($header as $row)
        {
            self::generateOutput($functionName, 'Header row => ' . $row, 3);
        }
        
        self::generateOutput($functionName, 'API Version set to: ' . $twitch_configuration['API_VERSION'], 3);
        
        // Custom build the post fields
        $postfields = (is_array($put)) ? http_build_query($put) : $put;
        
        $default = array( 
            CURLOPT_CONNECTTIMEOUT => $twitch_configuration['DEFAULT_RETURN_TIMEOUT'],
            CURLOPT_TIMEOUT => $twitch_configuration['DEFAULT_TIMEOUT'],
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_FRESH_CONNECT => 1, 
            CURLOPT_RETURNTRANSFER => 1, 
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_HTTPHEADER => $header
        );
        
        if (empty($options))
        {
            self::generateOutput($functionName, 'No additional options set', 3);
        }
        
        $handle = curl_init();
        
        if (function_exists('curl_setopt_array')) // Check to see if the function exists
        {
            self::generateOutput($functionName, 'Options set as an array', 3);
            curl_setopt_array($handle, ($options + $default));
        } else { // nope, set them one at a time
            foreach (($default + $options) as $key => $opt) // Options are set last so you can override anything you don't want to keep from defaults
            {
                self::generateOutput($functionName, 'Options set as individual values', 3);
                curl_setopt($handle, $key, $opt);
            }
        }
        
        self::generateOutput($functionName, 'command PUT => URL: ' . $url, 2);
        
        foreach ($put as $param => $val)
        {
            if (is_array($val))
            {
                foreach ($val as $key => $value)
                {
                    self::generateOutput($functionName, 'PUT option: [' . $param . '] ' . $key . '=>' . $value, 2);
                }
            } else {
                self::generateOutput($functionName, 'PUT option: ' . $param . '=>' . $val, 2);
            }
        }
        
        $result = curl_exec($handle);
        $httpdStatus = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        
        if (!gettype($result) == 'array') 
        { 
            $errStr = curl_error($handle);
            $errNo = curl_errno($handle);
            self::generateError($errNo, $errStr, $result); 
        }

        curl_close($handle);
        
        self::generateOutput($functionName, 'Status Returned: ' . $httpdStatus, 3);
        self::generateOutput($functionName, 'Raw Return: ' . $result, 4);
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($url, $put, $options, $debug, $postfields, $header, $field, $value, $postfields, $default, $errStr, $errNo, $handle, $row);
        
        // Are we returning the HHTPD status?
        if ($returnStatus)
        {
            self::generateOutput($functionName, 'Returning HTTPD status', 3);
            unset($result, $functionName);
            return $httpdStatus;
        } else {
            self::generateOutput($functionName, 'Returning result', 3);
            unset($httpdStatus, $functionName);
            return $result; 
        }
    }
    
    /**
     * This operates a POST style cURL command with the DELETE custom command option.
     * 
     * @param $url - [string] URL supplied for the connection
     * @param $post = [array]  All supplied data used to define what data to delete
     * @param $options - [array] Set options for the cURL session
     * @param $returnStatus - [bool] Sets the function to return the numerical status instead of the raw result {DEFAULTS TRUE}
     * 
     * @return $result - [mixed] The raw return of the resulting query or the numerical status
     */ 
    private function cURL_delete($url, array $post = array(), array $options = array(), $returnStatus = true)
    {
        global $twitch_configuration;
        $functionName = 'DELETE';
        
        self::generateOutput($functionName, 'Starting DELETE query', 1);
        
        // Specify the header
        if ((array_key_exists('oauth_token', $post) == 1) && ($twitch_configuration['TOKEN_SEND_METHOD'] == 'HEADER'))
        {
            $header = array('Accept: application/vnd.twitchtv.v' . $twitch_configuration['API_VERSION'] . '+json',
                'Authorization: OAuth ' . $post['oauth_token']);
            unset($post['oauth_token']);
        } else {
           $header = array('Accept: application/vnd.twitchtv.v' . $twitch_configuration['API_VERSION'] . '+json');
        }
                
        // Send the header info to the output
        foreach ($header as $row)
        {
            self::generateOutput($functionName, 'Header row => ' . $row, 3);
        }
        
        self::generateOutput($functionName, 'API Version set to: ' . $twitch_configuration['API_VERSION'], 3);
        
        $default = array(
            CURLOPT_URL => $url,
            CURLOPT_CONNECTTIMEOUT => $twitch_configuration['DEFAULT_RETURN_TIMEOUT'], 
            CURLOPT_TIMEOUT => $twitch_configuration['DEFAULT_TIMEOUT'],
            CURLOPT_HEADER => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => $header
        );
        
        $handle = curl_init();
        
        if (function_exists('curl_setopt_array')) // Check to see if the function exists
        {
            self::generateOutput($functionName, 'Options set as an array', 3);
            curl_setopt_array($handle, ($options + $default));
        } else { // nope, set them one at a time
            foreach (($default + $options) as $key => $opt) // Options are set last so you can override anything you don't want to keep from defaults
            {
                self::generateOutput($functionName, 'Options set as individual values', 3);
                curl_setopt($handle, $key, $opt);
            }
        }
        
        self::generateOutput($functionName, 'command DELETE => URL: ' . $url, 2);
        
        foreach ($post as $param => $val)
        {
            if (is_array($val))
            {
                foreach ($val as $key => $value)
                {
                    self::generateOutput($functionName, 'DELETE option: [' . $param . '] ' . $key . '=>' . $value, 2);
                }
            } else {
                self::generateOutput($functionName, 'DELETE option: ' . $param . '=>' . $val, 2);
            }
        }        
        
        ob_start();
        $result = curl_exec($handle);
        $httpdStatus = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle); 
        ob_end_clean();
        
        self::generateOutput($functionName, 'Status returned: ' . $httpdStatus, 3);   

        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);        
        unset($url, $post, $options, $header, $handle, $default, $key, $opt, $row);
        
        // Are we returning the HHTPD status?
        if ($returnStatus)
        {
            self::generateOutput($functionName, 'Returning HTTPD status', 3);
            unset($result, $functionName);
            return $httpdStatus;
        } else {
            self::generateOutput($functionName, 'Returning result', 3);
            unset($httpdStatus, $functionName);
            return $result; 
        }
    }
    
    /**
     * This function iterates through calls.  Put in here to keep the code the exact same every time
     * This assumes that all values are checked before being passed to here, PLEASE CHECK YOUR PARAMS
     * 
     * @param $functionName - [string] The calling function's identity, used for logging only
     * @param $url - [string] The URL to iterate on
     * @param $options - [array] The array of options to use for the iteration
     * @param $limit - [int] The limit of the query
     * @param $offset - [int] The starting offset of the query
     * 
     * -- OPTIONAL PARAMS --
     * The following params are all optional and are specific the the calling funciton.  Null disables the param from being passed
     * 
     * @param $arrayKey - [string] The key to look into the array for for data
     * @param $authKey - [string] The OAuth token for the session of calls
     * @param $hls - [bool] Limit the calls to only streams using HLS
     * @param $direction - [string] The sorting direction
     * @param $channels - [array] The array of channels to be included in the query
     * @param $embedable - [bool] Limit query to only channels that are embedable
     * @param $client_id - [string] Limit searches to only show content from the applications of the supplied client ID
     * @param $broadcasts - [bool] Limit returns to only show broadcasts
     * @param $period - [string] The period of time in which  to limit the search for
     * @param $game - [string] The game to limit the query to
     * 
     * @return $object - [arary] unkeyed array of data requested or null if no data was returned
     */ 
    private function get_iterated($functionName, $url, $options, $limit, $offset, $arrayKey = null, $authKey = null, $hls = null, $direction = null, $channels = null, $embedable = null, $client_id = null, $broadcasts = null, $period = null, $game = null)
    {
        global $twitch_configuration;
        $functionName = 'ITERATION-' . $functionName;
        
        self::generateOutput($functionName, 'starting Iteration sequence', 1);
        self::generateOutput($functionName, 'Calculating parameters', 3); 
        self::generateOutput($functionName, 'Limit recieved as: ' . $limit, 2);
        
        // Check to make sure limit is an int
        if ((gettype($limit) != 'integer') && (gettype($limit) != 'double') && (gettype($limit) != 'float'))
        {
            // Either the limit was not valid
            $limit = -1;
        } elseif (gettype($limit != 'integer')) {
            // Make sure we have an int
            $limit = floor($limit);
            
            if ($limit < 0)
            {
                // Set to unlimited
                $limit = -1;
            }
        }
        
        self::generateOutput($functionName, 'Limit set to: ' . $limit, 2);
        self::generateOutput($functionName, 'Offset recieved as: ' . $offset, 2);
        
        // Perform the same check on the offset
        if ((gettype($offset) != 'integer') && (gettype($offset) != 'double') && (gettype($offset) != 'float'))
        {
            $offset = 0;
        }  elseif (gettype($offset != 'integer')) {
            // Make sure we have an int
            $offset = floor($offset);
            
            if ($offset < 0)
            {
                // Set to base
                $offset = 0;
            }
        }
        
        self::generateOutput($functionName, 'Offset set to: ' . $offset, 2);
        
        // Init some vars  
        $grabbedRows = 0;
        $toDo = 0;
        $currentReturnRows = 0;
        $counter = 1;
        $iterations = 1;
        $object = array();
        if ($limit == -1)
        {
            $toDo = 100000000; // Set to an arbritrarily large number so that we can itterate forever if need be
        } else {
            $toDo = $limit; // We have a finite amount of iterations to do, account for the _links object in the first return
        }
        
        // Calculate the starting limit
        if ($toDo > ($twitch_configuration[$twitch_configuration['CALL_LIMIT_SETTING']] + 1))
        {
            $startingLimit = $twitch_configuration[$twitch_configuration['CALL_LIMIT_SETTING']];
            self::generateOutput($functionName, 'Starting Limit set to: ' . $startingLimit, 2);
        } else {
            $startingLimit = $toDo + 1;
            self::generateOutput($functionName, 'Starting Limit set to: ' . $startingLimit, 2);
        }
        
        // Build our GET array for the first iteration, these values will always be supplied
        $get = array('limit' => $startingLimit,
            'offset' => $offset);
            
        // Now check every optional param to see if it exists and att it to the array
        if ($authKey != null) 
        {
            $get['oauth_token'] = $authKey;
            self::generateOutput($functionName, 'Auth Key added to GET array', 2);
        }
        if ($hls != null)
        {
            $get['hls'] = $hls;
            self::generateOutput($functionName, 'HLS added to GET array', 2);            
        }
        if ($direction != null)
        {
            $get['direction'] = $direction;
            self::generateOutput($functionName, 'Direction added to GET array', 2);   
        }
        if ($channels != null)
        {
            foreach ($channels as $channel)
            {
                $channelBlock .= $channel . ',';
                $channelBlock = rtrim($channelBlock, ','); 
                $get['channel'] = $channelBlock;
            }
            self::generateOutput($functionName, 'Channels added to GET array', 2);
        }
        if ($embedable != null)
        {
            $get['embedable'] = $embedable;
            self::generateOutput($functionName, 'Embedable added to GET array', 2);
        }
        if ($client_id != null)
        {
            $get['client_id'] = $client_id;
            self::generateOutput($functionName, 'Client ID added to GET array', 2);
        }
        if ($broadcasts != null)
        {
            $get['broadcasts'] = $broadcasts;
            self::generateOutput($functionName, 'Broadcasts only added to GET array', 2);
        }
        if ($period != null)
        {
            $get['period'] = $period;
            self::generateOutput($functionName, 'Period added to GET array', 2);
        }
        if ($game != null)
        {
            $get['game'] = $game;
            self::generateOutput($functionName, 'Game added to GET array', 2);
        }
        
        // Build our cURL query and store the array
        $return = json_decode(self::cURL_get($url, $get, $options), true);

        // check to see if return was 0, this indicates a staus return
        if ($return == 0)
        {
            for ($i = 1; $i <= $twitch_configuration['RETRY_COUNTER']; $i++)
            {
                $return = json_decode(self::cURL_get($url, $get, $options), true);
                
                if ($return != 0)
                {
                    break;
                }
            }
        }
        
        // How many returns did we get?
        if ($arrayKey != null)
        {
            $currentReturnRows = count($return[$arrayKey]);
        } else {
            $currentReturnRows = count($return);
        }
        
        self::generateOutput($functionName, 'Iterations Completed: ' . $iterations, 3);
        self::generateOutput($functionName, 'Current return rows: ' . $currentReturnRows, 3);
        self::generateOutput($functionName, 'Current return flushed: ' . json_encode($return), 4);
        
        // Iterate until we have everything grabbed we want to have
        while ((($toDo > ($twitch_configuration[$twitch_configuration['CALL_LIMIT_SETTING']] + 1)) && ($toDo > 0)) || ($limit == -1))
        {
            // check to see if return was 0, this indicates a staus return
            if ($return == 0)
            {
                for ($i = 1; $i <= $twitch_configuration['RETRY_COUNTER']; $i++)
                {
                    $return = json_decode(self::cURL_get($url, $get, $options), true);
                    
                    if ($return != 0)
                    {
                        break;
                    }
                }
            }
            
            if ($arrayKey != null)
            {
                $currentReturnRows = count($return[$arrayKey]);
            } else {
                $currentReturnRows = count($return);
            }
            
            $grabbedRows += $currentReturnRows;

            foreach ($return as $set)
            {
                if (is_array($set)) // Skip a singular _link object that is not an array
                {
                    foreach ($set as $key => $value)
                    {
                        if (($key != 'next') && ($key != 'self') && (is_array($value)))
                        {
                            $object[$counter] = $value;
                            $counter ++;
                        }
                    }
                }
            }
            
            // Calculate our returns and our expected returns
            $expectedReturns = $startingLimit * $iterations - (1 * ($iterations - 1));
            $currentReturns = $counter;

            
            // Have we gotten everything we requested?
            if ($toDo <= 0)
            {
                self::generateOutput($functionName, 'All items requested returned, breaking iteration', 3);
                break;
            }
            
            self::generateOutput($functionName, 'Current counter: ' . $currentReturns, 3);
            self::generateOutput($functionName, 'Expected counter: ' . $expectedReturns, 3);
            
            // Are we no longer getting data? (Some fancy math here)
            if ($currentReturns != $expectedReturns)
            {
                self::generateOutput($functionName, 'Expected number of returns not met, breaking', 3);
                break;
            }
            
            if ($limit != -1)
            {
                $toDo = $limit - $currentReturns;
            }
            
            if ($toDo == 1)
            {
                $toDo = 2; // Catch this, it will drop one return
            }
            
            self::generateOutput($functionName, 'Returns to grab: ' . $toDo, 3);
            self::generateOutput($functionName, 'Calculating new Parameters', 3);
            
            // Check how many we have left
            if (($toDo > $startingLimit) && ($toDo > 0) && ($limit != -1))
            {
                self::generateOutput($functionName, 'Continuing iteration', 3);
                
                $get = array('limit' => $currentReturns + $startingLimit,
                    'offset' => $currentReturns);
                    
                // Now check every optional param to see if it exists and att it to the array
                if ($authKey != null) 
                {
                    $get['oauth_token'] = $authKey;
                    self::generateOutput($functionName, 'Auth Key added to GET array', 2);
                }
                if ($hls != null)
                {
                    $get['hls'] = $hls;
                    self::generateOutput($functionName, 'HLS added to GET array', 2);            
                }
                if ($direction != null)
                {
                    $get['direction'] = $direction;
                    self::generateOutput($functionName, 'Direction added to GET array', 2);   
                }
                if ($channels != null)
                {
                    foreach ($channels as $channel)
                    {
                        $channelBlock .= $channel . ',';
                        $channelBlock = rtrim($channelBlock, ','); 
                        $get['channel'] = $channelBlock;
                    }
                    self::generateOutput($functionName, 'Channels added to GET array', 2);
                }
                if ($embedable != null)
                {
                    $get['embedable'] = $embedable;
                    self::generateOutput($functionName, 'Embedable added to GET array', 2);
                }
                if ($client_id != null)
                {
                    $get['client_id'] = $client_id;
                    self::generateOutput($functionName, 'Client ID added to GET array', 2);
                }
                if ($broadcasts != null)
                {
                    $get['broadcasts'] = $broadcasts;
                    self::generateOutput($functionName, 'Broadcasts only added to GET array', 2);
                }
                if ($period != null)
                {
                    $get['period'] = $period;
                    self::generateOutput($functionName, 'Period added to GET array', 2);
                }
                if ($game != null)
                {
                    $get['game'] = $game;
                    self::generateOutput($functionName, 'Game added to GET array', 2);
                }
            } elseif ($limit == -1) {
                 self::generateOutput($functionName, 'Continuing iteration', 3);
                
                $get = array('limit' => $currentReturns + $startingLimit,
                    'offset' => $currentReturns);
                    
                // Now check every optional param to see if it exists and att it to the array
                if ($authKey != null) 
                {
                    $get['oauth_token'] = $authKey;
                    self::generateOutput($functionName, 'Auth Key added to GET array', 2);
                }
                if ($hls != null)
                {
                    $get['hls'] = $hls;
                    self::generateOutput($functionName, 'HLS added to GET array', 2);            
                }
                if ($direction != null)
                {
                    $get['direction'] = $direction;
                    self::generateOutput($functionName, 'Direction added to GET array', 2);   
                }
                if ($channels != null)
                {
                    foreach ($channels as $channel)
                    {
                        $channelBlock .= $channel . ',';
                        $channelBlock = rtrim($channelBlock, ','); 
                        $get['channel'] = $channelBlock;
                    }
                    self::generateOutput($functionName, 'Channels added to GET array', 2);
                }
                if ($embedable != null)
                {
                    $get['embedable'] = $embedable;
                    self::generateOutput($functionName, 'Embedable added to GET array', 2);
                }
                if ($client_id != null)
                {
                    $get['client_id'] = $client_id;
                    self::generateOutput($functionName, 'Client ID added to GET array', 2);
                }
                if ($broadcasts != null)
                {
                    $get['broadcasts'] = $broadcasts;
                    self::generateOutput($functionName, 'Broadcasts only added to GET array', 2);
                }
                if ($period != null)
                {
                    $get['period'] = $period;
                    self::generateOutput($functionName, 'Period added to GET array', 2);
                }
                if ($game != null)
                {
                    $get['game'] = $game;
                    self::generateOutput($functionName, 'Game added to GET array', 2);
                }                
            } else { // Last return in a limited case
                self::generateOutput($functionName, 'Last return to grab', 3);
                
                $get = array('limit' => $toDo + 1,
                    'offset' => $currentReturns);
                    
                // Now check every optional param to see if it exists and att it to the array
                if ($authKey != null) 
                {
                    $get['oauth_token'] = $authKey;
                    self::generateOutput($functionName, 'Auth Key added to GET array', 2);
                }
                if ($hls != null)
                {
                    $get['hls'] = $hls;
                    self::generateOutput($functionName, 'HLS added to GET array', 2);            
                }
                if ($direction != null)
                {
                    $get['direction'] = $direction;
                    self::generateOutput($functionName, 'Direction added to GET array', 2);   
                }
                if ($channels != null)
                {
                    foreach ($channels as $channel)
                    {
                        $channelBlock .= $channel . ',';
                        $channelBlock = rtrim($channelBlock, ','); 
                        $get['channel'] = $channelBlock;
                    }
                    self::generateOutput($functionName, 'Channels added to GET array', 2);
                }
                if ($embedable != null)
                {
                    $get['embedable'] = $embedable;
                    self::generateOutput($functionName, 'Embedable added to GET array', 2);
                }
                if ($client_id != null)
                {
                    $get['client_id'] = $client_id;
                    self::generateOutput($functionName, 'Client ID added to GET array', 2);
                }
                if ($broadcasts != null)
                {
                    $get['broadcasts'] = $broadcasts;
                    self::generateOutput($functionName, 'Broadcasts only added to GET array', 2);
                }
                if ($period != null)
                {
                    $get['period'] = $period;
                    self::generateOutput($functionName, 'Period added to GET array', 2);
                }
                if ($game != null)
                {
                    $get['game'] = $game;
                    self::generateOutput($functionName, 'Game added to GET array', 2);
                }
            }
            
            self::generateOutput($functionName, 'New query built, passing to GET:', 3);
            
            // Run a new query
            unset($return); // unset for a clean return
            $return = json_decode(self::cURL_get($url, $get, $options), true);
            
            $iterations ++;
            
            self::generateOutput($functionName, 'Iterations Completed: ' . $iterations, 3);
            self::generateOutput($functionName, 'Current rows returned: ' . $currentReturnRows, 3);
            self::generateOutput($functionName, 'Current return flushed: ' . json_encode($return), 4);
            self::generateOutput($functionName, 'End of iteration sequence', 3);
        }
        
        self::generateOutput($functionName, 'Exited Iteration', 3);
        
        // check to see if the loop was skipped
        if ((empty($object)) && (!empty($return)))
        {
            foreach ($return as $set)
            {
                if (is_array($set))
                {
                    foreach ($set as $key => $value)
                    {
                        if (($key != 'next') && ($key != 'self') && (is_array($value)))
                        {
                            $object[$counter] = $value;
                            $counter ++;
                        }
                    }
                }
            }
        }
        
        self::generateOutput($functionName, 'Total returned rows: ' . $counter, 3);
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($functionName, $url, $options, $limit, $offset, $arrayKey, $authKey, $hls, $direction, $channels, $embedable, $client_id, $broadcasts, $period, $game, $functionName, $grabbedRows, $currentReturnRows, $counter, $iterations, $toDo, $startingLimit, $channel, $channelBlock, $return, $set, $key, $value, $currentReturns, $expectedReturns);
        
        if (empty($object))
        {
            return null;
        }
        
        return $object;
    }

    /**
     * This function iterates through calls (nested array returns).  Put in here to keep the code the exact same every time
     * This assumes that all values are checked before being passed to here, PLEASE CHECK YOUR PARAMS
     * 
     * @param $functionName - [string] The calling function's identity, used for logging only
     * @param $url - [string] The URL to iterate on
     * @param $options - [array] The array of options to use for the iteration
     * @param $limit - [int] The limit of the query
     * @param $offset - [int] The starting offset of the query
     * @param $arrayKey - [string] The key to look into the array for for data
     * @param $arrayKey2 - [string] The second key to look into the array for for data
     * 
     * -- OPTIONAL PARAMS --
     * The following params are all optional and are specific the the calling funciton.  Null disables the param from being passed
     * 
     * @param $authKey - [string] The OAuth token for the session of calls
     * @param $hls - [bool] Limit the calls to only streams using HLS
     * @param $direction - [string] The sorting direction
     * @param $channels - [array] The array of channels to be included in the query
     * @param $embedable - [bool] Limit query to only channels that are embedable
     * @param $client_id - [string] Limit searches to only show content from the applications of the supplied client ID
     * @param $broadcasts - [bool] Limit returns to only show broadcasts
     * @param $period - [string] The period of time in which  to limit the search for
     * 
     * @return $object - [arary] unkeyed array of data requested
     */     
    private function get_iteratedNested($functionName, $url, $options, $limit, $offset, $arrayKey, $arrayKey2, $authKey = null, $hls = null, $direction = null, $channels = null, $embedable = null, $client_id = null, $broadcasts = null, $period = null)
    {
        global $twitch_configuration;
        $functionName = 'ITERATION_NESTED-' . $functionName;
        
        self::generateOutput($functionName, 'starting Iteration sequence', 1);
        self::generateOutput($functionName, 'Calculating parameters', 3); 
        self::generateOutput($functionName, 'Limit recieved as: ' . $limit, 2);
        
        // Check to make sure limit is an int
        if ((gettype($limit) != 'integer') && (gettype($limit) != 'double') && (gettype($limit) != 'float'))
        {
            // Either the limit was not valid
            $limit = -1;
        } elseif (gettype($limit != 'integer')) {
            // Make sure we have an int
            $limit = floor($limit);
            
            if ($limit < 0)
            {
                // Set to unlimited
                $limit = -1;
            }
        }
        
        self::generateOutput($functionName, 'Limit set to: ' . $limit, 2);
        self::generateOutput($functionName, 'Offset recieved as: ' . $offset, 2);
        
        // Perform the same check on the offset
        if ((gettype($offset) != 'integer') && (gettype($offset) != 'double') && (gettype($offset) != 'float'))
        {
            $offset = 0;
        }  elseif (gettype($offset != 'integer')) {
            // Make sure we have an int
            $offset = floor($offset);
            
            if ($offset < 0)
            {
                // Set to base
                $offset = 0;
            }
        }
        
        self::generateOutput($functionName, 'Offset set to: ' . $offset, 2);
        
        // Init some vars  
        $grabbedRows = 0;
        $toDo = 0;
        $currentReturnRows = 0;
        $counter = 1;
        $iterations = 1;
        $object = array();
        if ($limit == -1)
        {
            $toDo = 100000000; // Set to an arbritrarily large number so that we can itterate forever if need be
        } else {
            $toDo = $limit; // We have a finite amount of iterations to do, account for the _links object in the first return
        }
        
        // Calculate the starting limit
        if ($toDo > ($twitch_configuration[$twitch_configuration['CALL_LIMIT_SETTING']] + 1))
        {
            $startingLimit = $twitch_configuration[$twitch_configuration['CALL_LIMIT_SETTING']];
            self::generateOutput($functionName, 'Starting Limit set to: ' . $startingLimit, 2);
        } else {
            $startingLimit = $toDo + 1;
            self::generateOutput($functionName, 'Starting Limit set to: ' . $startingLimit, 2);
        }
        
        // Build our GET array for the first iteration, these values will always be supplied
        $get = array('limit' => $startingLimit,
            'offset' => $offset);
            
        // Now check every optional param to see if it exists and att it to the array
        if ($authKey != null) 
        {
            $get['oauth_token'] = $authKey;
            self::generateOutput($functionName, 'Auth Key added to GET array', 2);
        }
        if ($hls != null)
        {
            $get['hls'] = $hls;
            self::generateOutput($functionName, 'HLS added to GET array', 2);            
        }
        if ($direction != null)
        {
            $get['direction'] = $direction;
            self::generateOutput($functionName, 'Direction added to GET array', 2);   
        }
        if ($channels != null)
        {
            foreach ($channels as $channel)
            {
                $channelBlock .= $channel . ',';
                $channelBlock = rtrim($channelBlock, ','); 
                $get['channel'] = $channelBlock;
            }
            self::generateOutput($functionName, 'Channels added to GET array', 2);
        }
        if ($embedable != null)
        {
            $get['embedable'] = $embedable;
            self::generateOutput($functionName, 'Embedable added to GET array', 2);
        }
        if ($client_id != null)
        {
            $get['client_id'] = $client_id;
            self::generateOutput($functionName, 'Client ID added to GET array', 2);
        }
        if ($broadcasts != null)
        {
            $get['broadcasts'] = $broadcasts;
            self::generateOutput($functionName, 'Broadcasts only added to GET array', 2);
        }
        if ($period != null)
        {
            $get['period'] = $period;
            self::generateOutput($functionName, 'Period added to GET array', 2);
        }
        if ($game != null)
        {
            $get['game'] = $game;
            self::generateOutput($functionName, 'Game added to GET array', 2);
        }
        
        // Build our cURL query and store the array
        $return = json_decode(self::cURL_get($url, $get, $options), true);

        // check to see if return was 0, this indicates a staus return
        if ($return == 0)
        {
            for ($i = 1; $i <= $twitch_configuration['RETRY_COUNTER']; $i++)
            {
                $return = json_decode(self::cURL_get($url, $get, $options), true);
                
                if ($return != 0)
                {
                    break;
                }
            }
        }
        
        // How many returns did we get?
        $currentReturnRows = count($return[$arrayKey][$arrayKey2]);
        
        self::generateOutput($functionName, 'Iterations Completed: ' . $iterations, 3);
        self::generateOutput($functionName, 'Current return rows: ' . $currentReturnRows, 3);
        self::generateOutput($functionName, 'Current return flushed: ' . json_encode($return), 4);
        
        // Iterate until we have everything grabbed we want to have
        while ((($toDo > ($twitch_configuration[$twitch_configuration['CALL_LIMIT_SETTING']] + 1)) && ($toDo > 0)) || ($limit == -1))
        {
            // check to see if return was 0, this indicates a staus return
            if ($return == 0)
            {
                for ($i = 1; $i <= $twitch_configuration['RETRY_COUNTER']; $i++)
                {
                    $return = json_decode(self::cURL_get($url, $get, $options), true);
                    
                    if ($return != 0)
                    {
                        break;
                    }
                }
            }
            
            $currentReturnRows = count($return[$arrayKey][$arrayKey2]);
            $grabbedRows += $currentReturnRows;

            foreach ($return as $set)
            {
                if (is_array($set)) // Skip a singular _link object that is not an array
                {
                    foreach ($set as $key => $value)
                    {
                        if (($key != 'next') && ($key != 'self') && (is_array($value)))
                        {
                            $object[$counter] = $value;
                            $counter ++;
                        }
                    }
                }
            }
            
            // Calculate our returns and our expected returns
            $expectedReturns = $startingLimit * $iterations - (1 * ($iterations - 1));
            $currentReturns = $counter;

            
            // Have we gotten everything we requested?
            if ($toDo <= 0)
            {
                self::generateOutput($functionName, 'All items requested returned, breaking iteration', 3);
                break;
            }
            
            self::generateOutput($functionName, 'Current counter: ' . $currentReturns, 3);
            self::generateOutput($functionName, 'Expected counter: ' . $expectedReturns, 3);
            
            // Are we no longer getting data? (Some fancy math here)
            if ($currentReturns != $expectedReturns)
            {
                self::generateOutput($functionName, 'Expected number of returns not met, breaking', 3);
                break;
            }
            
            if ($limit != -1)
            {
                $toDo = $limit - $currentReturns;
            }
            
            if ($toDo == 1)
            {
                $toDo = 2; // Catch this, it will drop one return
            }
            
            self::generateOutput($functionName, 'Returns to grab: ' . $toDo, 3);
            self::generateOutput($functionName, 'Calculating new Parameters', 3);
            
            // Check how many we have left
            if (($toDo > $startingLimit) && ($toDo > 0) && ($limit != -1))
            {
                self::generateOutput($functionName, 'Continuing iteration', 3);
                
                $get = array('limit' => $currentReturns + $startingLimit,
                    'offset' => $currentReturns);
                    
                // Now check every optional param to see if it exists and att it to the array
                if ($authKey != null) 
                {
                    $get['oauth_token'] = $authKey;
                    self::generateOutput($functionName, 'Auth Key added to GET array', 2);
                }
                if ($hls != null)
                {
                    $get['hls'] = $hls;
                    self::generateOutput($functionName, 'HLS added to GET array', 2);            
                }
                if ($direction != null)
                {
                    $get['direction'] = $direction;
                    self::generateOutput($functionName, 'Direction added to GET array', 2);   
                }
                if ($channels != null)
                {
                    foreach ($channels as $channel)
                    {
                        $channelBlock .= $channel . ',';
                        $channelBlock = rtrim($channelBlock, ','); 
                        $get['channel'] = $channelBlock;
                    }
                    self::generateOutput($functionName, 'Channels added to GET array', 2);
                }
                if ($embedable != null)
                {
                    $get['embedable'] = $embedable;
                    self::generateOutput($functionName, 'Embedable added to GET array', 2);
                }
                if ($client_id != null)
                {
                    $get['client_id'] = $client_id;
                    self::generateOutput($functionName, 'Client ID added to GET array', 2);
                }
                if ($broadcasts != null)
                {
                    $get['broadcasts'] = $broadcasts;
                    self::generateOutput($functionName, 'Broadcasts only added to GET array', 2);
                }
                if ($period != null)
                {
                    $get['period'] = $period;
                    self::generateOutput($functionName, 'Period added to GET array', 2);
                }
                if ($game != null)
                {
                    $get['game'] = $game;
                    self::generateOutput($functionName, 'Game added to GET array', 2);
                }
            } elseif ($limit == -1) {
                 self::generateOutput($functionName, 'Continuing iteration', 3);
                
                $get = array('limit' => $currentReturns + $startingLimit,
                    'offset' => $currentReturns);
                    
                // Now check every optional param to see if it exists and att it to the array
                if ($authKey != null) 
                {
                    $get['oauth_token'] = $authKey;
                    self::generateOutput($functionName, 'Auth Key added to GET array', 2);
                }
                if ($hls != null)
                {
                    $get['hls'] = $hls;
                    self::generateOutput($functionName, 'HLS added to GET array', 2);            
                }
                if ($direction != null)
                {
                    $get['direction'] = $direction;
                    self::generateOutput($functionName, 'Direction added to GET array', 2);   
                }
                if ($channels != null)
                {
                    foreach ($channels as $channel)
                    {
                        $channelBlock .= $channel . ',';
                        $channelBlock = rtrim($channelBlock, ','); 
                        $get['channel'] = $channelBlock;
                    }
                    self::generateOutput($functionName, 'Channels added to GET array', 2);
                }
                if ($embedable != null)
                {
                    $get['embedable'] = $embedable;
                    self::generateOutput($functionName, 'Embedable added to GET array', 2);
                }
                if ($client_id != null)
                {
                    $get['client_id'] = $client_id;
                    self::generateOutput($functionName, 'Client ID added to GET array', 2);
                }
                if ($broadcasts != null)
                {
                    $get['broadcasts'] = $broadcasts;
                    self::generateOutput($functionName, 'Broadcasts only added to GET array', 2);
                }
                if ($period != null)
                {
                    $get['period'] = $period;
                    self::generateOutput($functionName, 'Period added to GET array', 2);
                }
                if ($game != null)
                {
                    $get['game'] = $game;
                    self::generateOutput($functionName, 'Game added to GET array', 2);
                }                
            } else { // Last return in a limited case
                self::generateOutput($functionName, 'Last return to grab', 3);
                
                $get = array('limit' => $toDo + 1,
                    'offset' => $currentReturns);
                    
                // Now check every optional param to see if it exists and att it to the array
                if ($authKey != null) 
                {
                    $get['oauth_token'] = $authKey;
                    self::generateOutput($functionName, 'Auth Key added to GET array', 2);
                }
                if ($hls != null)
                {
                    $get['hls'] = $hls;
                    self::generateOutput($functionName, 'HLS added to GET array', 2);            
                }
                if ($direction != null)
                {
                    $get['direction'] = $direction;
                    self::generateOutput($functionName, 'Direction added to GET array', 2);   
                }
                if ($channels != null)
                {
                    foreach ($channels as $channel)
                    {
                        $channelBlock .= $channel . ',';
                        $channelBlock = rtrim($channelBlock, ','); 
                        $get['channel'] = $channelBlock;
                    }
                    self::generateOutput($functionName, 'Channels added to GET array', 2);
                }
                if ($embedable != null)
                {
                    $get['embedable'] = $embedable;
                    self::generateOutput($functionName, 'Embedable added to GET array', 2);
                }
                if ($client_id != null)
                {
                    $get['client_id'] = $client_id;
                    self::generateOutput($functionName, 'Client ID added to GET array', 2);
                }
                if ($broadcasts != null)
                {
                    $get['broadcasts'] = $broadcasts;
                    self::generateOutput($functionName, 'Broadcasts only added to GET array', 2);
                }
                if ($period != null)
                {
                    $get['period'] = $period;
                    self::generateOutput($functionName, 'Period added to GET array', 2);
                }
                if ($game != null)
                {
                    $get['game'] = $game;
                    self::generateOutput($functionName, 'Game added to GET array', 2);
                }
            }
            
            self::generateOutput($functionName, 'New query built, passing to GET:', 3);
            
            // Run a new query
            unset($return); // unset for a clean return
            $return = json_decode(self::cURL_get($url, $get, $options), true);
            
            $iterations ++;
            
            self::generateOutput($functionName, 'Iterations Completed: ' . $iterations, 3);
            self::generateOutput($functionName, 'Current rows returned: ' . $currentReturnRows, 3);
            self::generateOutput($functionName, 'Current return flushed: ' . json_encode($return), 4);
            self::generateOutput($functionName, 'End of iteration sequence', 3);
        }
        
        self::generateOutput($functionName, 'Exited Iteration', 3);
        
        // check to see if the loop was skipped
        if ((empty($object)) && (!empty($return)))
        {
            foreach ($return as $set)
            {
                if (is_array($set))
                {
                    foreach ($set as $key => $value)
                    {
                        if (($key != 'next') && ($key != 'self') && (is_array($value)))
                        {
                            $object[$counter] = $value;
                            $counter ++;
                        }
                    }
                }
            }
        }
        
        self::generateOutput($functionName, 'Total returned rows: ' . $counter, 3);
                
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($functionName, $url, $options, $limit, $offset, $arrayKey, $arrayKey2, $authKey, $hls, $direction, $channels, $embedable, $client_id, $broadcasts, $period, $game, $functionName, $grabbedRows, $currentReturnRows, $counter, $iterations, $toDo, $startingLimit, $channel, $channelBlock, $return, $set, $key, $value, $currentReturns, $expectedReturns);
        
        if (empty($object))
        {
            return null;
        }
        
        return $object;
    }
    
    /**
     * Generate an Auth key for our session to use if we don't have one, requires a client key and secret for auth
     * 
     * @param $code - [string] String of auth code used to grant authorization
     * 
     * @return$token - The generated token and the array of all scopes returned with the token, keyed
     */
    public function generateToken($code)
    {
        global $twitch_clientKey, $twitch_clientSecret, $twitch_clientUrl;
        
        $functionName = 'Generate_Auth';
        self::generateOutput($functionName, 'Generating auth token', 1);
        
        $url = 'https://api.twitch.tv/kraken/oauth2/token';
        $post = array(
            'client_id' => $twitch_clientKey,
            'client_secret' => $twitch_clientSecret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $twitch_clientUrl,
            'code' => $code
        );
        $options = array();
        
        $result = json_decode(self::cURL_post($url, $post, $options, false), true);
        
        if (array_key_exists('access_token', $result))
        {
            $token['token'] = $result['access_token'];
            $token['scopes'] = $result['scope'];
            self::generateOutput($functionName, 'Access token returned: ' . $token['token'], 3);            
        } else {
            $token['token'] = false;
            $token['grants'] = array();
            self::generateOutput($functionName, 'Access token not returned', 3);
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($code, $functionName, $url, $post, $options, $result);
        
        return $token;
    }
    
    /**
     * Checks a token for validity and access grants available.
     * 
     * $authToken - [string] The token that you want to check
     * 
     * $authToken - [array} Either the provided token and the array of scopes if it was valid or false as the token and an empty array of scopes
     */
     
     public function checkToken($authToken)
     {
        global $twitch_clientKey, $twitch_clientSecret, $twitch_clientUrl;
        
        $functionName = 'Generate_Token';
        self::generateOutput($functionName, 'Checking OAuth token', 1);
        
        $url = 'https://api.twitch.tv/kraken';
        $post = array(
            'oauth_token' => $authToken
        );
        $options = array();
        
        $result = json_decode(self::cURL_post($url, $post, $options, false), true);
        
        if ($result['token']['valid'])
        {
            self::generateOutput($functionName, 'Token valid', 3);
            $token['token'] = $authToken;
            $token['scopes'] = $result['authorization']['scopes'];
            $token['name'] = $result['user_name'];
        } else {
            self::generateOutput($functionName, 'Token not valid', 3);
            $token['token'] = false;
            $token['scopes'] = array();
            $token['name'] = '';
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($authToken, $functionName, $url, $post, $options, $result);
        
        return $token;     
     }
    
    /**
     * Request that a user generate an auth code for our use.
     * 
     * @param $grantType - [array] All auth types requested for the application
     * 
     * @return $urlRedirect - [string] The string URL that will redirect the user to where they can authorize this application for use on their channel 
     */ 
    public function generateAuthorizationURL($grantType)
    {
        global $twitch_clientKey, $twitch_clientUrl;
        
        $scopes = '';
        $functionName = 'Request_Auth';
        
        self::generateOutput($functionName, 'Generating redirect URL', 1);
        
        foreach ($grantType as $scope)
        {
            $scopes .= $scope . ' ';
        }
        $scopes = rtrim($scopes, ' ');
        $scopes = urlencode($scopes);
        
        $urlRedirect = 'https://api.twitch.tv/kraken/oauth2/authorize?' .
            'response_type=code' . '&' .
            'client_id=' . $twitch_clientKey . '&' .
            'redirect_uri=' . $twitch_clientUrl . '&' .
            'scope=' . $scopes;
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($grantType, $scopes, $functionName, $scope);
        
        return $urlRedirect;
    }
    
    /**
     * A function able to grab the authentication code out of the return URL from Twitch's auth servers
     * 
     * @param $url - [string] The redirect URL from Twitch's authentication servers
     * 
     * @return $code - [string] The returned authentication code used in authenticated calls
     */ 
    public function retrieveRedirectCode($url)
    {
        $functionName = 'RETRIEVE_CODE';
        
        self::generateOutput($functionName, 'Retrieving code from URL String', 1);
        
        $code = getURLParamValue($url, 'code');
        
        //clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($functionName);
        
        return $code;
    }

    /**
     * Grabs a list of the users blocked from a channel
     * 
     * @param $chan - [string] Channel name to grab blocked users list from
     * @param $limit - [int] Limit of users to grab, -1 is unlimited
     * @param $offset - [int] The starting offset of the query
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $blockedUsers - Unkeyed array of all blocked users to limit
     */ 
    public function getBlockedUsers($chan, $limit = -1, $offset = 0, $authKey, $code)
    {
        global $twitch_configuration;
        
        $functionName = 'GET_BLOCKED';
        $requiredAuth = 'user_blocks_read';
        
        self::generateOutput($functionName, 'Attempting to pull a complete list of blocked users for the channel: ' . $chan, 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                        return array(); // return out here, match the fail state of the call
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                return array(); // return out after the error is passed, match the fail tate of the call
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return array(); // Match the fail state of the call so users are not thrown off
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        $url = 'https://api.twitch.tv/kraken/users/' . $chan . '/blocks';
        $options = array(); // For things where I don't put in any default data, I will leave the end user the capability to configure here
        $usernames = array();
        $usernamesObject = array();
        $counter = 0;
        
        $usernamesObject = self::get_iterated($functionName, $url, $options, $limit, $offset, 'blocks', $authKey);
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($usernamesObject), 4);
        
        // Set the array
        foreach ($usernamesObject as $user)
        {
            $usernames[$counter] = $user['user'][$twitch_configuration['KEY_NAME']];
            $counter ++;
        }
        
        // Was anything returned?  If not, put some output
        if (empty($usernames))
        {
            self::generateOutput($functionName, 'No blocked users returned for channel: ' . $chan, 3);
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($return, $options, $url, $get, $limit, $usernamesObject, $key, $k, $value, $v, $functionName);
        
        // Return out our unkeyed or empty array
        return $usernames;
    }
    
    /**
     * Adds a user to a channel's blocked list
     * 
     * @param $chan - [string] channel to add the user to
     * @param $username - [string] username of newly banned user
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $success - [bool] Result of the query
     */ 
    public function addBlockedUser($chan, $username, $authKey, $code)
    {
        global $twitch_configuration;
        
        $functionName = 'ADD_BLOCKED';
        $requiredAuth = 'user_blocks_edit';
        
        self::generateOutput($functionName, 'Attempting to add ' . $username . ' to ' . $chan . '\'s list of blocked users', 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                        return false; // return out here, match the fail state of the call
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return false; // return out after the error is passed, match the fail state of the call
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return false; // match fail state
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
                
        $url = 'https://api.twitch.tv/kraken/users/' . $chan . '/blocks/' . $username;
        $options = array();
        $post = array('oauth_token' => $authKey);
            
        $result = self::cURL_put($url, $post, $options, true);
        
        // What did we get returned status wise?
        if ($result = 200)
        {
            self::generateOutput($functionName, 'Successfully blocked channel ' . $username, 3);
            $success = true;
        } else {
            self::generateOutput($functionName, 'Unsuccessfully blocked channel ' . $username, 3);
            $success = false;
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $username, $authKey, $code, $result, $functionName, $requiredAuth, $auth, $authSuccessful, $type, $url, $options, $post);
        
        // Post handles successs, so pass the info on
        return $success;  
    }
    
    /**
     * Removes a user from being blocked on a channel
     * 
     * @param $chan     - [string] channel to remove the user from.
     * @param $username - [string] username of newly pardoned user
     * @param $authKey  - [string] Authentication key used for the session
     * @param $code     - [string] Code used to generate an Authentication key
     * 
     * @return $success - [bool] Result of the query
     */ 
    public function removeBlockedUser($chan, $username, $authKey, $code)
    {
        global $twitch_configuration;
        
        $functionName = 'REMOVE_BLOCKED';
        $requiredAuth = 'user_blocks_edit';
        
        self::generateOutput($functionName, 'Attempting to remove ' . $username . ' from ' . $chan . '\'s list of blocked users', 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                        return false; // return out here, match the fail state of the call
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return false; // return out after the error is passed, match the fail state of the call
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return false; // match fail state
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        $url = 'https://api.twitch.tv/kraken/users/' . $chan . '/blocks';
        $options = array();
        $post = array(
            'username' => $username,
            'oauth_token' => $authKey);
            
        $success = self::cURL_delete($url, $post, $options);
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($success), 4);
        
        if ($success == '204')
        {
            self::generateOutput($functionName, 'Successfully removed ' . $username . ' from ' . $chan . '\'s list of blocked users', 3);
        } else if ($success == '422') {
            self::generateOutput($functionName, 'Service unavailable or delete failed', 3);
        } else {
            self::generateOutput($functionName, 'Failed to remove ' . $username . ' from ' . $chan . '\'s list of blocked users', 3);
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $username, $authKey, $code, $auth, $authSuccessful, $type, $url, $options, $post, $functionName);
        
        // Bascally we either deleted or they were never there
        return true;  
    }
    
    /**
     * Grabs a full channel object of all publically available data for the channel
     * 
     * @param $chan - [string] Name of the channel to grab the object for
     * 
     * @return $object - [array] Keyed array of all publically available channel data
     */ 
    public function getChannelObject($chan)
    {
        $functionName = 'GET_CHANNEL';
        self::generateOutput($functionName, 'Grabbing channel object for channel: ' . $chan, 1);
        
        $url = 'https://api.twitch.tv/kraken/channels/' . $chan;
        $get = array();
        $options = array();
        
        self::generateOutput($functionName, 'Grabbing channel object for ' . $chan, 3);
        
        $object = json_decode(self::cURL_get($url, $get, $options, false), true);
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($object), 4);
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $functionName, $url, $get, $options);
        
        if (!is_array($object))
        {
            $object = array(); // Catch to make sure that an array is returned no matter what, technically our fail state
        }
        
        return $object;
    }
    
    /**
     * Grabs an authenticated channel object using an authentication key to determine what channel to grab
     * 
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $object - [array] Keyed array of all channel data
     */ 
    public function getChannelObject_Authd($authKey, $code)
    {
        $functionName = 'GET_CHANNEL_AUTHED';
        $requiredAuth = 'channel_read';
        self::generateOutput($functionName, 'Grabbing authenticated channel object', 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                        return array();
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return array(); // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return array();
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        $url = 'https://api.twitch.tv/kraken/channel';
        $get = array('oauth_token' => $authKey);
        $options = array();

        $object = json_decode(self::cURL_get($url, $get, $options, false), true);
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($object), 4);
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($authKey, $code, $auth, $authSuccessful, $type, $url, $get, $options);
        
        if (!is_array($object))
        {
            $object = array(); // Catch to make sure that an array is returned no matter what, technically our fail state
        }
        
        return $object;
    }
    
    /**
     * Grabs a list of all editors supplied for the channel
     * 
     * @param $chan - [string] the string channel name to grab the editors for
     * @param $limit - [int] Limit of users to grab, -1 is unlimited
     * @param $offset - [int] The initial offset of the query
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $editors - [array] unkeyed array of all editor names
     */ 
    public function getEditors($chan, $limit = -1, $offset = 0, $authKey, $code)
    {
        global $twitch_configuration;
        
        $functionName = 'GET_EDITORS';
        $requiredAuth = 'channel_read';
        self::generateOutput($functionName, 'Grabbing editors for ' . $chan . '\'s channel', 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                        return array();
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return array(); // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return array();
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        $url = 'https://api.twitch.tv/kraken/users/' . $chan . '/editors';
        $options = array(); // For things where I don't put in any default data, I will leave the end user the capability to configure here
        $counter = 0;
        $editors = array();
        $editorsObject = array();
            
        $editorsObject = self::get_iterated($functionName, $url, $options, $limit, $offset, 'users', $authKey);
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($editorsObject), 4);
        
        foreach ($editorsObject as $editor)
        {
            $editors[$counter] = $editor[$twitch_configuration["KEY_NAME"]];
        }
        
        // Was anything returned?  If not, put some output
        if (empty($editors))
        {
            self::generateOutput($functionName, 'No editors returned for channel: ' . $chan, 3);
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $limit, $offset, $authKey, $code, $auth, $authSuccessful, $type, $functionName, $url, $options, $counter, $editor, $editorsObject);
        
        return $editors;
    }
    
    /**
     * Updates the channel object with new info
     * 
     * @param $chan - [string] Channel to update
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * @param $title - [string] New title for the stream
     * @param $game - [string] Game title to update to the channel
     * @param $delay - [int] Seconds of stream delay to put into effect
     * 
     * @return $result - [bool] Success of the query
     */ 
    public function updateChannelObject($chan, $authKey, $code, $title = null, $game = null, $delay = null)
    {
        $requiredAuth = 'channel_editor';
        $functionName = 'UPDATE_CHANNEL';
        
        self::generateOutput($functionName, 'Updating Channel object', 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                        return false;
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return false; // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return false;
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        $url = 'https://api.twitch.tv/kraken/channels/' . $chan;
        $updatedObjects = array();
        $options = array();
        
        $updatedObjects['oauth_token'] = $authKey;
        
        if ($title != null || '')
        {
            self::generateOutput($functionName, 'New title added to array: ' . $title, 2);
            $updatedObjects['channel']['status'] = $title;
        } 
        
        if ($game  != null || '')
        {
            self::generateOutput($functionName, 'New game added to array: ' . $game, 2);
            $updatedObjects['channel']['game'] = $game;
        } 
        
        if ($delay != null || '')
        {
            self::generateOutput($functionName, 'New Stream Delay added to array: ' . $delay, 2);
            $updatedObjects['channel']['delay'] = $delay;
        } 
        
        $result = self::cURL_put($url, $updatedObjects, $options, true);
        
        self::generateOutput($functionName, 'Status return: ' . $result, 4);
        
        if (($result != 404) || ($result != 400))
        {
            $result = true;
        } else {
            $result = false;
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $authKey, $code, $title, $game, $delay, $auth, $authSuccessful, $type, $url, $updatedObjects, $options, $functionName);        
        
        return $result;
    }
    
    /**
     * This resets the stream key for a user.  Should only be used when absolutely neccesary.
     * 
     * @param $chan - [string] Channel name to reset the stream key for
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $result - True on success, else false on failure
     */ 
    public function resetStreamKey($chan, $authKey, $code)
    {   
        $requiredAuth = 'channel_stream';
        $functionName = 'RESET_STREAM_KEY';
        
        self::generateOutput($functionName, 'Resetting stream key for channel: ' . $chan, 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                        return false;
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return false; // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return false;
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        $url = 'https://api.twitch.tv/kraken/channels/' . $chan . '/stream_key';
        $options = array();
        $post = array('oauth_token' => $authKey);
        
        $result = self::cURL_delete($url, $post, $options, true);
        
        self::generateOutput($functionName, 'Status return: ' . $result, 3);
        
        if ($result == 204)
        {
            $result = true;
        } else {
            $result = false;
        }
        
        //clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $authKey, $code, $auth, $authSuccessful, $type, $url, $options, $post, $functionName);
        
        return $result;
    }
    
    /**
     * This starts a commercial on the channel in question
     * 
     * @param $chan - [string] Channel name to start the commercial on
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * @param $length - [int] Length of time for the commercial break.  Valid options are 30,60,90.
     * 
     * @return $return - True on success, else false
     */ 
    public function startCommercial($chan, $authKey, $code, $length = 30)
    {
        $functionName = 'START_COMMERCIAL';
        $requiredAuth = 'channel_commercial';
        
        self::generateOutput($functionName, 'Starting commercial for channel: ' . $chan, 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                        return false;
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return false; // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return false;
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        self::generateOutput($functionName, 'Commercial time recieved as: ' . $length, 2);
        
        // Check the length to see if it is valid
        if (($length != 30) && ($length != 60) && ($length != 90))
        {
            self::generateOutput($functionName, 'Commercial time invalid, set to 30 seconds', 2);
            $length = 30;
        }
        
        $url = 'https://api.twitch.tv/kraken/channels/' . $chan . '/commercial';
        $options = array();
        $post = array(
            'oauth_token' => $authKey,
            'length' => $length
        );
        
        $result = self::cURL_post($url, $post, $options, true);
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($result), 4);
        
        if ($result == 204)
        {
            self::generateOutput($functionName, 'Commercial successfully started', 3);
            $result = true;
        } else {
            self::generateOutput($functionName, 'Commercial unable to be started', 3);
            $result = false;
        }
        
        //clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $authKey, $code, $length, $auth, $authSuccessful, $type, $url, $options, $post, $functionName);
        
        return $result;
    }
    
    /**
     * Grabs a list of all twitch emoticons
     * 
     * @param $limit - [int] The limit of objets to grab for the query
     * @param $offset - [int] the offest to start the query from
     * 
     * @return $object - [array] Keyed array of all returned data for the emoticins, including the supplied regex match used to parse it
     */ 
    public function chat_getEmoticonsGlobal($limit, $offset)
    {
        global $twitch_configuration;
        
        $functionName = 'GET_EMOTICONS_GLOBAL';
        self::generateOutput($functionName, 'Grabbing global Twitch emoticons', 1);
        
        $url = 'https://api.twitch.tv/kraken/chat/emoticons';
        $options = array();
        $object = array();
        
        $objects = self::get_iterated($functionName, $url, $options, $limit, $offset, 'emoticons');
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($objects), 4);
        
        self::generateOutput($functionName, 'Setting Keys', 3);
        
        // Set keys
        foreach ($objects as $row)
        {
            $k = $row['regex'];
            $object[$k] = $row;
        }
        
        // clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($limit, $offset, $url, $options, $functionName, $objects, $row, $k);
        
        return $object;
    }
    
    /**
     * Grabs a list of call channel specific emoticons
     * 
     * @param $user - [string] username to grab emoticons for
     * @param $limit - [int] The limit of objects to grab for the query
     * @param $offest - [int] The offset to start the query from
     * 
     * @return $object - [array] Keyed array of all returned data for the emoticons
     */ 
    public function chat_getEmoticons($user, $limit, $offset)
    {
        global $twitch_configuration;
        
        $functionName = 'GET_EMOTICONS';
        self::generateOutput($functionName, 'Grabbing emoticons for channel: ' . $user, 1);
        
        $url = 'https://api.twitch.tv/kraken/chat/' . $user . '/emoticons';
        $options = array();
        $object = array();
        
        $objects = self::get_iterated($functionName, $url, $options, $limit, $offset, 'emoticons');
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($objects), 4);
        
        self::generateOutput($functionName, 'Setting Keys', 3);
        
        // Set keys
        foreach ($objects as $row)
        {
            $k = $row['regex'];
            $object[$k] = $row;
        }
        
        // clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($user, $limit, $offset, $functionName, $url, $options, $objects, $k, $row);
        
        return $object;
    }

    /**
     * Grabs a list of call channel specific badges
     * 
     * @param $chan - [string] Channel name to grab badges for
     * @param $limit - [int] The limit of object to grab for the query
     * @param $offest - [int] The offset to start the query from
     * 
     * @return $object - [array] Keyed array of all returned data for the badges
     */     
    public function chat_getBadges($chan)
    {        
        $functionName = 'GET_BADGES';
        
        self::generateOutput($functionName, 'Grabbing badges for channel: ' . $chan, 1);
        
        $url = 'https://api.twitch.tv/kraken/chat/' . $chan . '/badges';
        $options = array();
        $get = array();
        
        $object = json_decode(self::cURL_get($url, $get, $options, false), true);
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($object), 4);
        
        // clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $url, $options, $get, $functionName);        
        
        return $object;                
    }
    
    /**
     * Generates an OAuth token for chat login
     * 
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $chatToken - [string] complete login token for chat login
     */
     
     public function chat_generateToken($authKey, $code)
     {
        $functionName = 'CHAT_GENERATE_TOKEN';
        $requiredAuth = 'chat_login';
        $prefix = 'oauth:';
        
        self::generateOutput($functionName, 'Generating chat login token', 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return; // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return null;
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        self::generateOutput($functionName, 'Token generated, concating prefix', 3);
        $chatToken = $prefix . $authKey;
        
        self::generateOutput($functionName, 'Prefix added, login credential made: ' . $chatToken, 3);
        
        // clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($authKey, $auth, $authSuccessful, $code, $requiredAuth, $functionName, $type);        
        
        return $chatToken;                
     }
    
    /**
     * Gets a list of users that follow a given channel
     * 
     * @param $chan - [string] Channel name to get the followers for
     * @param $limit - [int] the limit of users
     * @param $offset - [int] The starting offset of the query
     * @param $sorting - [string] Sorting direction, valid options are 'asc' and 'desc'
     * 
     * @return $follows - [array] An unkeyed array of all followers to limit
     */ 
    public function getFollowers($chan, $limit, $offset, $sorting = 'desc')
    {
        global $twitch_configuration;
        
        $functionName = 'GET_FOLLOWERS';
        self::generateOutput($functionName, 'Getting the list of channels followed by channel: ' . $chan, 1);
        
        $url = 'https://api.twitch.tv/kraken/channels/' . $chan . '/follows';
        $options = array();
        $followersObject = array();
        $followers = array();
             
        $followersObject = self::get_iterated($functionName, $url, $options, $limit, $offset, 'follows');
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($followersObject), 4);
        
        foreach ($followersObject as $follower)
        {
            $key = $follower['user'][$twitch_configuration['KEY_NAME']];
            $followers[$key] = $follower;
            self::generateOutput($functionName, 'Setting key: ' . $key, 3);
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $limit, $offset, $sorting, $follower, $followersObject, $functionName, $key);
        
        // Return out our array
        return $followers;
    }
    
    /**
     * Grab a lits of all channels a user follows
     * 
     * @param $username - [string] Username to get the follows of
     * @param $limit - [int] the limit of users
     * @param $offset - [int] The starting offset of the query
     * @param $sorting - [string] Sorting direction, valid options are 'asc' and 'desc'
     * 
     * @return $channels - [array] An unkeyed array of all followed channels to limit
     */ 
    public function getFollows($username, $limit, $offset, $sorting = 'desc')
    {
        global $twitch_configuration;
        
        $functionName = 'GET_FOLLOWS';
        self::generateOutput($functionName, 'Getting the list of channels following channel: ' . $username, 1);
        
        // Init some vars       
        $channels = array();
        $url = 'https://api.twitch.tv/kraken/users/' . $username . '/follows/channels';
        $options = array();
            
        // Build our cURL query and store the array
        $channelsObject = self::get_iterated($functionName, $url, $options, $limit, $offset, 'follows');
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($channelsObject), 4);
        
        foreach ($channelsObject as $channel)
        {
            $key = $channel['channel'][$twitch_configuration['KEY_NAME']];
            $channels[$key] = $channel;
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($username, $limit, $offset, $sorting, $channelsObject, $channel, $url, $options, $key, $functionName);
        
        // Return out our unkeyed array
        return $channels;        
    }
    
    /**
     * Adds a channel to a user's following list
     * 
     * @param $user - [string] Username of the account to add the channel to
     * @param $chan - [string] Channel name that the user will have added to their list
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $success - [mixed] The updated follow object or false of the channel was not found
     */ 
    public function followChan($user, $chan, $authKey, $code)
    {
        $functionName = 'FOLLOW_CHANNEL';
        $requiredAuth = 'user_follows_edit';
        
        self::generateOutput($functionName, 'Attempting to have channel ' . $user . ' follow the user ' . $chan, 1);      
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return; // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return null;
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        $url = 'https://api.twitch.tv/kraken/users/' . $user . '/follows/channels/' . $chan;
        $options = array();
        $post = array('oauth_token' => $authKey);
        
        $result = self::cURL_put($url, $post, $options, false);
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($result), 4);
        
        if ($result['status'] == 404)
        {
            self::generateOutput($functionName, 'Unable to follow channel.  Channel not found', 3);
            $result = false;
        }

        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($user, $chan, $authKey, $code, $auth, $authSuccessful, $type, $url, $options, $post, $functionName);
        
        return $result;
    }
    
    /**
     * Removes a channel from a user's follow list
     * 
     * @param $user - [string] Username of the account to add the channel to
     * @param $chan - [string] Channel name that the user will have added to their list
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $success - [bool] Success of the query
     */ 
    public function unfollowChan($user, $chan, $authKey, $code)
    {
        $functionName = 'UNFOLLOW_CHANNEL';
        $requiredAuth = 'user_follows_edit';
        
        self::generateOutput($functionName, 'Attempting have channel ' . $user . ' unfollow channel ' . $chan, 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return; // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return null;
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        $url = 'https://api.twitch.tv/kraken/users/' . $user . '/follows/channels/' . $chan;
        $options = array();
        $delete = array('oauth_token' => $authKey);
        
        $result = self::cURL_delete($url, $delete, $options, false);
        
        self::generateOutput($functionName, 'Raw return: ' . json_encode($result), 4);
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($user, $chan, $authKey, $code, $auth, $authSuccessful, $type, $url, $options, $delete);
        
        if ($result['status'] == 404)
        {
            self::generateOutput($functionName, 'Successfully unfollowed channel', 3);
            unset($functionName);
            return true;
        } else {
            self::generateOutput($functionName, 'Unsuccessfully unfollowed channel', 3);
            unset($functionName);
            return false;
        }
    }
    
    /**
     * Grabs a list of most popular games being streamed on twitch
     * 
     * @param $limit - [int] Set the limit of objects to grab
     * @param $offset - [int] Sets the initial offset to start the query from
     * @param $hls - [bool] Sets the query only to grab streams using HLS
     * 
     * @return $object - [array] A complete array of all channel objects in order based on the sorting rules
     */ 
    public function getLargestGame($limit = -1, $offset = 0, $hls = false)
    {
        global $twitch_configuration;
        $functionName = 'GET_LARGEST_GAME';
        
        self::generateOutput($functionName, 'Attempting to get a list of the channels currently live to limit sorted by viewer count', 1);
        
        // Init some vars       
        $gamesObject = array();
        $games = array();        
        $url = 'https://api.twitch.tv/kraken/games/top';
        $options = array();
        
        $gamesObject = self::get_iterated($functionName, $url, $options, $limit, $offset, 'top', null, $hls);
        
        // Strip out only the usernames from our array set
        foreach ($gamesObject as $game)
        {
            $key = $game['game']['name'];
            $games[$key] = $game;
        }
        
        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($limit, $offset, $hls, $url, $options, $gamesObject, $key, $game, $functionName);
        
        return $games;
    }
    
    /**
     * Returns an array of all streamers streaming in the supplied game catagory
     * 
     * @param $query - [string] A string parameter to search for
     * @param $live - [bool] Sets the query to search only for live channels
     * 
     * @return $object - [array] An array of all resulting search returns
     */ 
    public function searchGameCat($query, $live = true)
    {
        global $twitch_configuration;

        $functionName = 'SEARCH_GAME';
        self::generateOutput($functionName, 'Searching all game catagories for the string: ' . $query, 1);
        
        $url = 'https://api.twitch.tv/kraken/search/games';
        $get = array(
            'q' => $query,
            'type' => 'suggest',
            'live' => $live);
        $options = array();
        $result = array();
        $object = array();
        
        $result = json_decode(self::cURL_get($url, $get, $options, false), true);
        
        foreach ($result as $key => $value)
        {
            foreach ($value as $game)
            {
                $k = $game['name'];
                if ($k != 'h')
                {
                    $object[$k] = $game;
                }
            }
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($query, $live, $url, $get, $options, $result, $k, $key, $value, $game, $functionName);
    
        return $object;
    }
    
    /**
     * Grabs the stream object of a given channel
     * 
     * @param $chan - [string] Channel name to get the stream object for
     * 
     * @return $object - [array or null] Returned array of all stream object data or null if stream is offline
     */ 
    public function getStreamObject($chan)
    {
        $functionName = 'GET_STREAM_OBJECT';
        
        self::generateOutput($functionName, 'Getting the stream object for channel ' . $chan, 1);
        
        $url = 'https://api.twitch.tv/kraken/streams/' . $chan;
        $get = array();
        $options = array();
        
        $result = json_decode(self::cURL_get($url, $get, $options, false), true);
        
        if ($result['stream'] != null)
        {
            $object = $result['stream'];
        } else {
            $object = null;
        }
        
        // Clean up
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $url, $get, $result, $functionName);
        
        return $object;
    }
    
    /**
     * Gets the stream object of multiple channels and credentials
     * All Params are optional or have default values
     * 
     * @param $game - [string] Limit returns to a specific game
     * @param $channels - [array] Limit search to a specific set of channels
     * @param $limit - [int] Limit of channel objects to return
     * @param $offset - [int] Maximum number of objects to return
     * @param $embedable - [bool] Limit search to only embedable channels
     * @param $hls - [bool] Limit sear to channels only using hls
     * @param $client_id - [string] Limit searches to only show streams from the applications of the supplied ID
     * 
     * @return $object - [array] All returned data for the query parameters
     */ 
    public function getStreamsObjects($game = null, $channels = array(), $limit = -1, $offset = 0, $embedable = false, $hls = false, $client_id = null)
    {
        global $twitch_configuration;
        
        $functionName = 'GET_STREAM_OBJECTS';
        self::generateOutput($functionName, 'Attempting to get stream objects for the provided parameters', 1);
        
        // Init some vars       
        $url = 'https://api.twitch.tv/kraken/streams';
        $options = array();
        $streamsObject = array();
        $streams = array();
        
        // Build our cURL query and store the array
        $streamsObject = self::get_iterated($functionName, $url, $options, $limit, $offset, 'streams', null, $hls, null, $channels, $embedable, $client_id);
        
        // Strip out the data we don't need
        foreach ($streamsObject as $key => $value)
        {
            foreach ($value as $k => $v)
            {
                if ($k == 'channel')
                {
                    $objKey = $v[$twitch_configuration['KEY_NAME']];
                    $streams[$objKey] = $value;
                    break;
                }
            }
        }
        
        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($game, $channels, $limit, $offset, $embedable, $hls, $client_id, $url, $options, $streamsObject, $key, $k, $value, $v, $objKey, $functionName);
        
        return $streams;              
    }
    
    /**
     * Grabs a list of all featured streamers objects
     * 
     * @param $limit - [int] Limit of channel objects to return
     * @param $offset - [int] Maximum number of objects to return
     * @param $hls - [bool] Limit sear to channels only using hls
     * 
     * @return $featuredObject - [array] Array of all stream objects for the query or false if the query fails
     */ 
    public function getFeaturedStreams($limit, $offset, $hls = false)
    {
        global $twitch_configuration;
        $functionName = 'GET_FEATURED';
        
        self::generateOutput($functionName, 'Getting all featured streamers to limit', 1);
        
        // Init some vars
        $featured = array();          
        $url = 'https://api.twitch.tv/kraken/streams/featured';
        $options = array();
        
        // Build our cURL query and store the array
        $featuredObject = self::get_iterated($functionName, $url, $options, $limit, $offset, 'featured');
        
        // Strip out the uneeded data
        foreach ($featuredObject as $key => $value)
        {
            if (($key != 'self') && ($key != 'next'))
            {
                $k = $value['stream']['channel'][$twitch_configuration['KEY_NAME']];
                $featured[$k] = $value;
            }
        }
        
        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($limit, $offset, $embedable, $hls, $url, $options, $featuredObject, $key, $value, $k, $functionName);
        
        return $featured;           
    }
    
    /**
     * Gets the current viewers and the current live channels for Twitch
     * 
     * @param $hls - [bool] Limit sear to channels only using hls
     * 
     * @return $statistics - [array] (keyed) The current Twitch Statistics 
     */ 
    public function getTwitchStatistics($hls = false)
    {
        $functionName = 'GET_STATISTICS';
        
        self::generateOutput($functionName, 'Getting current statistics for Twitch', 1);
        
        $statistics = array();
        $url = 'https://api.twitch.tv/kraken/streams/summary';
        $get = array();
        $options = array();
        
        $result = json_decode(self::cURL_get($url, $get, $options), true);
        
        // A cheap way of making sure an array is always returned
        foreach ($result as $key => $value)
        {
            $statistics[$key] = $value;
        }

        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($hls, $url, $get, $options, $result, $key, $value, $functionName);
        
        return $statistics;        
    }
    
    /**
     * Returns the video object for the specified ID
     * 
     * @param $id - [string] String ID of the video to get
     * 
     * @return $object - [array] Video object returned from the query, key is the ID
     */
    public function getVideo_ID($id)
    {
        $functionName = 'GET_VIDEO-ID';
        
        self::generateOutput($functionName, 'Getting the video object for the video with the ID: ' . $id, 1);
        
        // init some vars
        $object = array();
        $url = 'https://api.twitch.tv/kraken/videos/' . $id;
        $get = array();
        $options = array();
        
        $result = json_decode(self::cURL_get($url, $get, $options, false), true);
        
        if (!empty($result) && ($result['status'] != '404'))
        {
            // Set the key and the array
            $object[$id] = $result;            
        }

        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($id, $functionName, $url, $get, $options, $result);
        
        return $object;             
    }
    
    /**
     * Returns the video objects of the given channel
     * 
     * @param $chan - [string] Channel name to grab video objects from
     * @param $limit - [int] Limit of channel objects to return
     * @param $offset - [int] Maximum number of objects to return
     * @param $boradcastsOnly - [bool] If true, limits query to only past broadcasts, else will return highlights only
     * 
     * @return $videoObjects - [array] array of all returned video objects, Key is ID
     */ 
    public function getVideo_channel($chan, $limit = -1, $offset = 0, $boradcastsOnly = false)
    {
        global $twitch_configuration;
        $functionName = 'GET_VIDEO-CHANNEL';
        
        self::generateOutput($functionName, 'Getting the vido objects for channel: ' . $chan, 1);
        
        // Init some vars
        $videoObjects = array();     
        $videos = array();
        $options = array();
        $url = 'https://api.twitch.tv/kraken/channels/' . $chan . '/videos';
            
        // Build our cURL query and store the array
        $videos = self::get_iterated($functionName, $url, $options, $limit, $offset, 'videos', null, null, null, null, null, null, $boradcastsOnly);
        
        // Key the data
        foreach ($videos as $video)
        {
            $key = $video['_id'];
            $videoObjects[$key] = $video;
        }
        
        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $limit, $offset, $boradcastsOnly, $functionName, $video, $videos, $key, $options, $url);
        
        return $videoObjects;                  
    }
    
    /**
     * Grabs all videos for all channels a user is following
     * 
     * @param $limit - [int] Limit of channel objects to return
     * @param $offset - [int] Maximum number of objects to return
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $videosObject - [array] All video objects returned by the query, Key is ID
     */ 
    public function getVideo_followed($limit = -1, $offset = 0, $authKey, $code)
    {
        global $twitch_configuration;
        
        $requiredAuth = 'user_read';
        $functionName = 'GET_VIDEO-FOLLOWED';
        
        self::generateOutput($functionName, 'Grabbing all video objects for the channels using the code: ' . $code, 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return; // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return null;
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        // Init some vars       
        $videosObject = array();            
        $videos = array();
        $url = 'https://api.twitch.tv/kraken/videos/followed';
        $options = array();
        
        // Build our cURL query and store the array
        $videos = self::get_iterated($functionName, $url, $options, $limit, $offset, 'videos', $authKey);
        
        // Set our keys
        foreach ($videos as $video)
        {
            $key = $video['_id'];
            $videosObject[$key] = $video;
        }

        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($limit, $offset, $authKey, $code, $requiredAuth, $functionName, $auth, $authSuccessful, $authKey, $type, $videos, $video, $url, $options, $key);
        
        return $videosObject;      
    }
    
    /**
     * Gets a list of the top viewed videos by the sorting parameters
     * 
     * @param $game - [string] Game name to sory the query by
     * @param $limit - [int] Limit of channel objects to return
     * @param $offset - [int] Maximum number of objects to return
     * @param $period - [string] set the period for the query, valid values are 'week', 'month', 'all'
     * 
     * @return $videosObject - [array] Array of all returned video objects, Key is ID
     */ 
    public function getTopVideos($game = '', $limit = -1, $offset = 0, $period = 'week')
    {
        global $twitch_configuration;
        
        $functionName = 'GET_TOP_VIDEOS';
        self::generateOutput($functionName, 'Grabbing all of the top videos to limit', 1);
        
        // check the period to make sure it is valid
        if (($period != 'week') && ($period != 'month') && ($period != 'all'))
        {
            $period = 'week';
        }
        
        // Init some vars       
        $videosObject = array();
        $videos = array();
        $url = 'https://api.twitch.tv/kraken/videos/top';
        $options = array();
            
        // Build our cURL query and store the array
        $videos = self::get_iterated($functionName, $url, $options, $limit, $offset, 'videos', null, null, null, null, null, null, null, $period, $game);
        
        // Set our keys
        foreach ($videos as $video)
        {
            $key = $video['_id'];
            $videosObject[$key] = $video;
        }
        
        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($game, $limit, $offset, $period, $functionName, $video, $videos, $key, $url, $options);
        
        return $videosObject;         
    }
    
    /**
     * Gets a lits of all isers subscribed to a channel
     * 
     * @param $chan - [string] Channel name to grab the subscribers list of
     * @param $limit - [int] Limit of channel objects to return
     * @param $offset - [int] Maximum number of objects to return
     * @param $direction - [string] Sorting direction, valid options are 'asc' and 'desc'
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $subscribers - [array] Unkeyed array of all subscribed users
     */ 
    public function getChannelSubscribers($chan, $limit = -1, $offset = 0, $direction = 'asc', $authKey, $code)
    {
        global $twitch_configuration;
        
        $requiredAuth = 'channel_subscriptions';
        $functionName = 'GET_SUBSCRIBERS';
        
        self::generateOutput($functionName, 'Getting the list of subcribers to channel: ' . $chan, 1);      
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return; // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return null;
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        // Check our sorting direction
        if (($direction != 'asc') && ($direction != 'desc'))
        {
            $direction = 'asc';
        }

        // Init some vars       
        $subscribers = array();
        $subscribersObject = array();
        $url = 'https://api.twitch.tv/kraken/channels/' . $chan . '/subscriptions';
        $options = array();
        
        // Build our cURL query and store the array
        $subscribersObject = self::get_iterated($functionName, $url, $options, $limit, $offset, 'subscriptions', $authKey, null, $direction);
        
        // Set the keys and array
        foreach ($subscribersObject as $subscriber)
        {
            $key = $subscriber[$twitch_configuration['KEY_NAME']];
            $subscribers[$key] = $subscriber;
        }
        
        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($chan, $limit, $offset, $direction, $authKey, $code, $requiredAuth, $authKey, $auth, $authSuccessful, $type, $subscriber, $subscribersObject, $key, $url, $options);
        
        return $subscribers;
    }
    
    /**
     * Checks to see if a user is subscribed to a specified channel from the channel side
     * 
     * @param $user - [string] Username of the use check against
     * @param $chan - [string] Channel name of the channel to check against
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $subscribed - [bool] the status of the user subscription
     */ 
    public function checkChannelSubscription($user, $chan, $authKey, $code)
    {
        $requiredAuth = 'channel_subscriptions';
        $functionName = 'CHECK_SUBSCRIPTION';
        
        self::generateOutput($functionName, 'Checking to see if user ' . $user . ' is subscribed to channel ' . $chan, 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return; // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return null;
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        $url = 'https://api.twitch.tv/kraken/channels/' . $chan . '/subscriptions/' . $user;
        $options = array();
        $get = array('oauth_token' => $authKey);
        
        // Build our cURL query and store the array
        $subscribed = json_decode(self::cURL_get($url, $get, $options, true), true);
        
        // Check the return
        if ($subscribed)
        {
            
        } else {
            
        }
        
        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning memory', 3);
        unset($user, $chan, $authKey, $code, $requiredAuth, $functionName, $auth, $authSuccessful, $authKey, $type, $url, $options, $get);
        
        return $subscribed;
    }
    
    /**
     * Gets the team objects for all active teams
     * 
     * @param $limit - [int] Limit of channel objects to return
     * @param $offset - [int] Maximum number of objects to return
     * 
     * @return $teams - [array] Keyed array of all team objects.  Key is the team name
     */ 
    public function getTeams($limit = -1, $offset = 0)
    {
        global $twitch_configuration;        
        $functionName = 'GET_TEAMS';
        
        self::generateOutput($functionName, 'Grabbing all available teams objects', 1);
        
        // Init some vars       
        $teams = array();        
        $url = 'https://api.twitch.tv/kraken/teams';
        $options = array();
        
        // Build our cURL query and store the array
        $teamsObject = self::get_iterated($functionName, $url, $options, $limit, $offset, 'teams');
        
        // Transfer to teams
        foreach ($teamsObject as $team)
        {
            $key = $team[$twitch_configuration['KEY_NAME']];
            $teams[$key] = $team;
        }
        
        // Clean up quickly
        self::generateOutput($functionName, 'Cleaning Memory', 3);
        unset($limit, $offset, $teamsObject, $team, $url, $options, $key);
        
        return $teams;
    }
    
    /**
     * Grabs the team object for the supplied team
     * 
     * @param $team - [string] Name of the team to grab the object for
     * 
     * @return $teamObject - [array] Object returned for the team queried
     */ 
    public function getTeam($team)
    {
        $functionName = 'GET_USEROBJECT';
        self::generateOutput($functionName, 'Attempting to get the team object for user: ' . $team, 1);
        
        $url = 'https://api.twitch.tv/kraken/teams/' . $team;
        $options = array();
        $get = array('team' => $team);
        
        // Build our cURL query and store the array
        $teamObject = json_decode(self::cURL_get($url, $get, $options, false), true);

        //clean up
        self::generateOutput($functionName, 'Cleaning Memory', 3);
        unset($team, $url, $options, $get, $functionName);
        
        return $teamObject;
    }
    
    /**
     * Gets an un-authenticated user object for the specified user
     * 
     * @param $user - [string] Username to grab the object for
     * 
     * @return $userObject - [array] Returned object for the query
     */ 
    public function getUserObject($user)
    {
        $functionName = 'GET_USEROBJECT';
        self::generateOutput($functionName, 'Attempting to get the user object for user: ' . $user, 1);
        
        $url = 'https://api.twitch.tv/kraken/users/' . $user;
        $options = array();
        $get = array();
        
        // Build our cURL query and store the array
        $userObject = json_decode(self::cURL_get($url, $get, $options, false), true);
        self::generateOutput($functionName, 'Raw return: ' . $userObject, 4);
        
        //clean up
        self::generateOutput($functionName, 'Cleaning Memory', 3);
        unset($user, $url, $options, $get, $functionName);
        
        return $userObject;          
    }
    
    /**
     * Gets an authenticated user object for the specified user
     * 
     * @param $user - [string] Username to grab the object for
     * @param $authKey - [string] Authentication key used for the session
     * @param $code - [string] Code used to generate an Authentication key
     * 
     * @return $userObject - [array] Returned object for the query
     */ 
    public function getUserObject_Authd($user, $authKey, $code)
    {
        $functionName = 'GET_USEROBJECT-AUTH';
        $requiredAuth = 'user_read';
        
        self::generateOutput($functionName, 'Attempting to get the authenticated user object for user: ' . $user, 1);
        
        // We were supplied an OAuth token. check it for validity and scopes
        if (($authKey != null || '') || ($code != null || false))
        {
            if ($authKey != null || '')
            {
                $check = self::checkToken($authKey);
                
                if ($check["token"] != false)
                {
                    $auth = $check;
                } else { // attempt to generate one
                    if ($code != null || '')
                    {
                        $auth = self::generateToken($code); // Assume generation and check later for failure
                    } else {
                        self::generateError(400, 'Existing token expired and no code available for generation.');
                    }
                }
            } else { // Assume the code was given instead and generate if we can
                $auth = self::generateToken($code); // Assume generation and check later for failure
            }
            
            // check to see if we recieved a token after all of that checking
            if ($auth['token'] == false) // check the token value
            {
                self::generateError(400, 'Auth key not returned, exiting function: ' . $functionName);
                
                return; // return out after the error is passed
            }
            
            $authSuccessful = false;
            
            // Check the array of scopes
            foreach ($auth['scopes'] as $type)
            {
                if ($type = $requiredAuth)
                {
                    // We found the scope, we are good then
                    $authSuccessful = true;
                    break;
                }
            }
            
            // Did we fail?
            if (!$authSuccessful)
            {
                self::generateError(403, 'Authentication token failed to have permissions for ' . $functionName . '; required Auth: ' . $requiredAuth);
                return null;
            }
            
            // Assign our key
            self::generateOutput($functionName, 'Required scope found in array', 3);
            $authKey = $auth['token'];
        }
        
        $url = 'https://api.twitch.tv/kraken/users/' . $user;
        $options = array();
        $get = array('oauth_token' => $authKey);
        
        // Build our cURL query and store the array
        $userObject = json_decode(self::cURL_get($url, $get, $options, false), true);
        self::generateOutput($functionName, 'Raw return: ' . $userObject, 4);
        
        //clean up
        self::generateOutput($functionName, 'Cleaning Memory', 3);
        unset($user, $url, $options, $get, $authKey, $auth, $authSuccessful, $type, $functionName, $code);
        
        return $userObject;
    }
}
?>