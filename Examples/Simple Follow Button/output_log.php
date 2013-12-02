<?php exit; ?>
11-28-13||21:05:30 => FOLLOW_CHANNEL || Attempting to have channel testuser1 follow the user testchannel2
11-28-13||21:05:30 => Generate_Token || Generating auth token
11-28-13||21:05:30 => POST || Starting POST query
11-28-13||21:05:30 => POST || Header row => Accept: application/vnd.twitchtv.v3+json
11-28-13||21:05:30 => POST || Header row => Client-ID: 1234123412341234123412341234123
11-28-13||21:05:30 => POST || API Version set to: 3
11-28-13||21:05:30 => POST || No additional options set
11-28-13||21:05:30 => POST || Options set as an array
11-28-13||21:05:30 => POST || command POST => URL: https://api.twitch.tv/kraken/oauth2/token
11-28-13||21:05:30 => POST || POST option: client_id=>1234123412341234123412341234123
11-28-13||21:05:30 => POST || POST option: client_secret=>1234123412341234123412341234123
11-28-13||21:05:30 => POST || POST option: grant_type=>authorization_code
11-28-13||21:05:30 => POST || POST option: redirect_uri=>http://www.testurl.com
11-28-13||21:05:30 => POST || POST option: code=>1234123412341234123412341234123
11-28-13||21:05:31 => POST || Status Returned: 200
11-28-13||21:05:31 => POST || Cleaning memory
11-28-13||21:05:31 => POST || Returning result
11-28-13||21:05:31 => Generate_Token || Access token returned: smfe9vex6vn0sq52f9znsvmujys6lev
11-28-13||21:05:31 => Generate_Token || Cleaning memory
11-28-13||21:05:31 => FOLLOW_CHANNEL || Required scope found in array
11-28-13||21:05:31 => PUT || Starting PUT query
11-28-13||21:05:31 => PUT || Header row => Accept: application/vnd.twitchtv.v3+json
11-28-13||21:05:31 => PUT || Header row => Authorization: OAuth smfe9vex6vn0sq52f9znsvmujys6lev
11-28-13||21:05:31 => PUT || Header row => Client-ID: 1234123412341234123412341234123
11-28-13||21:05:31 => PUT || API Version set to: 3
11-28-13||21:05:31 => PUT || No additional options set
11-28-13||21:05:31 => PUT || Options set as an array
11-28-13||21:05:31 => PUT || command PUT => URL: https://api.twitch.tv/kraken/users/testuser1/follows/channels/testchannel2
11-28-13||21:05:31 => PUT || Status Returned: 422
11-28-13||21:05:31 => PUT || Cleaning memory
11-28-13||21:05:31 => PUT || Returning HTTPD status
11-28-13||21:05:31 => FOLLOW_CHANNEL || Unable to follow channel.  Channel not found
11-28-13||21:05:31 => FOLLOW_CHANNEL || Cleaning memory
