# Bits

Function | API Alias | Description
-------- | --------- | -----------
[`Bits::getCheermotes`](#bitsgetcheermotes) | [`/bits/cheermotes`](#bitsgetcheermotes) | Gets the cheermotes for a channel, or the default list of cheermotes if no channel ID is provided


## Bits::getCheermotes
Gets the cheermotes for a channel, or the default list of cheermotes if no channel ID is provided.

### API Aliases
`/bits/cheermotes`

### Parameters
### Parameters
Parameter|Type|Required|Description
---------|----|--------|-----------
`channelID`|string|No|The string channel ID to pull cheermotes for

### Usage
Static
```php
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Bits;

$cheermotes = Bits::getCheermotes(new Configuration([
    'clientID' => 'Your Twitch ClientID'
]));
```

Object
```php
use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;

$twitchClient = new Twitch(new Configuration([
    'clientID' => 'Your Twitch ClientID',
]));

$cheermotes = $twitchClient->api('/bits/cheermotes');
```

### Return Example
```json
{
   "actions": [
      {
         "backgrounds": [
               "light",
               "dark"
         ],
         "prefix": "Cheer",
         "scales": [
               "1",
               "1.5",
               "2",
               "3",
               "4"
         ],
         "states": [
               "static",
               "animated"
         ],
         "tiers": [
               {
                  "color": "#979797",
                  "id": "1",
                  "images": {
                     "dark": {
                           "animated": {
                              "1": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/dark/animated/1/1.gif",
                              "1.5": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/dark/animated/1/1.5.gif",
                              "2": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/dark/animated/1/2.gif",
                              "3": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/dark/animated/1/3.gif",
                              "4": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/dark/animated/1/4.gif"
                           },
                           "static": {
                              "1": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/dark/static/1/1.png",
                              "1.5": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/dark/static/1/1.5.png",
                              "2": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/dark/static/1/2.png",
                              "3": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/dark/static/1/3.png",
                              "4": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/dark/static/1/4.png"
                           }
                     },
                     "light": {
                           "animated": {
                              "1": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/light/animated/1/1.gif",
                              "1.5": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/light/animated/1/1.5.gif",
                              "2": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/light/animated/1/2.gif",
                              "3": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/light/animated/1/3.gif",
                              "4": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/light/animated/1/4.gif"
                           },
                           "static": {
                              "1": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/light/static/1/1.png",
                              "1.5": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/light/static/1/1.5.png",
                              "2": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/light/static/1/2.png",
                              "3": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/light/static/1/3.png",
                              "4": "https://d3aqoihi2n8ty8.cloudfront.net/actions/cheer/light/static/1/4.png"
                           }
                     }
                  },
                  "min_bits": 1
               },
               ...
         ]
      },
      ...
   ]
}
```
