#Twitch Interface

[PHP] Twitch Interface

This is a universal PHP interface designed specifically to connect to and interact with the twitch.tv Kraken API servers.  It was designed with the intention of being very controlled, safe and light for both the user server and the Kraken API servers.  Almost, if not all capable calls are coded directly into the interface, allowing the interface to perform almost, if not all functions that the API allows.  Any functions that you believe need to be added or improved can be done via a pull request or opening up an issue.

Currently this interface supports all V3 API calls.

# News

<code>2-15-2014:</code> The API is fully covered as far as V3 of Twitch's Kraken API is documented or as far as I feel needs to be supported (I have no intention of supporting either depreciated or unofficial API endpoints).  This does not mean I will no longer work on this and as soon as anything on the API changes/becomes avaiable, I will update the interface accordingly.

#License

    This Twitch Interface is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This Twitch Interface is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    A copy of the GNU GPLV3 license can be found at http://www.gnu.org/licenses/
    or can be found in the folder distributed with the software.

###TL`DR

You can do whatever you want with this piece of software, including modifying it and using it in any way, shape or form.  The only requirement is that you keep the credit and the license in the header of the file itself and that you not, in any circumstances redistribute the file in question for the safety of any people who wish to use this software.  If you wish to have other people use this software, it is best that you give them the link to this particular git for the latest version of this software and to allow them to find all of the information relating to this piece of software.

For any information about the interface, please look in the module list below (Yes, I know PHP does not actually have a module system, it is just easier to sort them by this).

# Advantages

1. Encompass all currently documented API endpoints available in [Twitch's kraken V3](https://github.com/justintv/Twitch-API/tree/master/v3_resources)
2. Very simple calls: <code>$editors = $interface->getEditors('test_channel_1', -1, 0, 'Your OAuth Token', 'Your Access Code');</code>
3. Able to grab theoretically unlimited information
4. Automatically adds your client-id into the header of every call to avoid rate limits (Don't abuse twitch though, they still reserve the right to rate limit you or even deny your application access.  I take no responsibility for any actions Twitch may or may not take in order to stop abuse of the API)
5. Automatically uses a defined certificate for true HTTPS (Has a workaround in case a certificate is not provided to allow calls to go through properly)
6. Extremely configurable (See [configuration](https://github.com/IBurn36360/Twitch_Interface/blob/master/configuration.md))
7. Very light weight both in CPU usage and in memory usage (Developed with a single core system in mind [My machine is single core])
8. Easy to use returns (Everything is either an array or a bool for ease of use for novice and starting developers)
9. Checks on all authenticated calls (Will go as far as to validate that a token has the required scope for the call before attempting it)
10. Complete function walkthrough output and error output (See [Output](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/output.md))
11. Built on base calls for dependencies (cURL and JSON Utilities), allowing base versions to be used.
12. Easy to [install](https://github.com/IBurn36360/Twitch_Interface/blob/master/installation.md) (Composer compatibility will be built in once first port is completed)

# Module Directory

### [Authentication](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md)

| Call | Description |
| ---- | ----------- |
| [generateToken()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#generatetoken) | Generates an OAuth token. |
| [checkToken()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#checktoken) | Checks what scopes a provided OAuth token is allowed and the state of it |
| [generateAuthorizationURL()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#generateauthorizationurl) | Generates an authorization URL for a user to authorize your application. |
| [retrieveRedirectCode()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/authentication.md#retrieveredirectcode) | Retrieves the code out of a string URL if the code was not properly returned on redirect. |  

### [Blocks](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/blocks.md)

| Call | Description |
| ---- | ----------- |
| [getBlockedUsers()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/blocks.md#getblockedusers) | Grabs a list of all blocked user objects to limit or end of list. |
| [addBlockedUser()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/blocks.md#addblockeduser) | Attempts to add a user to your list of blocked users. |
| [removeBlockedUser()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/blocks.md#removeblockeduser) | Attempts to remove a user from your list of blocked users. |

### [Channels](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/channels.md)

| Call | Description |
| ---- | ----------- |
| [getChannelObject()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/channels.md#getchannelobject) | Gets an unauthenticated channel object for the target channel. |
| [getChannelObject_Authd()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/channels.md#getchannelobject_authd) | Gets an authenticated channel object using an OAuth token as the identifying parameter. |
| [getEditors()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/channels.md#geteditors) | Grabs a list of all editors to targe channel. |
| [updateChannelObject()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/channels.md#updatechannelobject) | Updates the target channel with new information. |
| [resetStreamKey()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/channels.md#resetstreamkey) | Attempts to reset target channels stream key and have a new one generated. |
| [startCommercial()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/channels.md#startcommercial) | Attempts to start a commercial on target channel. |

### [Chat](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/chat.md)

| Call | Description |
| ---- | ----------- |
| [chat_getEmoticonsGlobal()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/chat.md#chat_getemoticonsglobal) | Gets a list of all currently registered and cached amoticons. |
| [chat_getEmoticons()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/chat.md#chat_getemoticons) | Grabs a list of all emoticons publically available on Twitch including any sub emotes for their channel. |
| [chat_getBadges()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/chat.md#chat_getbadges) | Gets all badge related data for the specified channel. |
| [chat_generateToken()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/chat.md#chat_generatetoken) | Generates an IRC login token. |  

### [cURL](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/curl.md)

| Call | Description |
| ---- | ----------- |
| [cURL_get()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/curl.md#curl_get) | Handles all cURL GET style calls. |
| [cURL_post()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/curl.md#curl_post) | Handles all cURL POST style calls. |
| [cURL_put()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/curl.md#curl_put) | Handles all cURL PUT style calls. |
| [cURL_delete()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/curl.md#curl_delete) | Handles all cURL DELETE style calls. |

### [Follows](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/follows.md)

| Call | Description |
| ---- | ----------- |
| [getFollowers()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/follows.md#getfollowers) | Grabs a list of the users following the specified channel. |
| [getFollows()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/follows.md#getfollows) | Grabs a list of the channels followed by a specified user. |
| [followChan()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/follows.md#followchan) | Attempts to add a target channel to a subject users follows list. |
| [unfollowChan()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/follows.md#unfollowchan) | Attempts to remove a target channel from a subject users follows list. |

### [Games](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/games.md)

| Call | Description |
| ---- | ----------- |
| [getLargestGame()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/games.md#getlargestgame) | Attempts to grab a list of all games currently streamed in order of current viewers (descending) |

### [Helpers](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/helpers.md)

| Call | Description |
| ---- | ----------- |
| [getURLParamValue()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/helpers.md#geturlparamvalue) | Retrieves the value of a passed parameter in a URL string, positionally insensitive. |
| [getURLParams()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/helpers.md#geturlparams) | Grabs an array of all URL parameters and values. |
| [get_iterated()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/helpers.md#get_iterated) | This function iterates through calls. |

### [Ingests](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/ingests.md)

| Call | Description |
| ---- | ----------- |
| [getIngests()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/ingests.md#getingests) | Grabs All currently registered Ingest servers and some base stats |

### [Output](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/output.md)

| Call | Description |
| ---- | ----------- |
| [generateError()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/output.md#generateerror) | Handles output for all errors encountered by the interface.  Almost all error output is authentication issues. |
| [generateOutput()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/output.md#generateoutput) | Handles all function output, including function init and walkthrough.  Refer to the [output config](https://github.com/IBurn36360/Twitch_Interface/blob/master/configuration.md#twitch_debuglevels) for more information. |

### [Search](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/search.md)

| Call | Description |
| ---- | ----------- |
| [searchGameCat()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/search.md#searchgamecat) | Searches Twitch's list of all games for the matching string. |

### [Stats](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/stats.md)

| Call | Description |
| ---- | ----------- |
| [getTwitchStatistics()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/stats.md#gettwitchstatistics) | Gets the current viewers and the current live channels for Twitch |

### [Streams](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/streams.md)

| Call | Description |
| ---- | ----------- |
| [getStreamObject()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/streams.md#getstreamobject) | Queries Twitch for the stream object of the specified channel. |
| [getStreamsObjects()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/streams.md#getstreamsobjects) | Queries Twitch for the stream objects of multiple channels or by a set of conditions or both. |
| [getFeaturedStreams()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/streams.md#getFeaturedStreams) | Returns currently featured streamers. |
| [getFollowedStreams()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/streams.md#getfollowedstreams) | Grabs the list of online channels that a user is following |

### [Subscriptions](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/subscriptions.md)

| Call | Description |
| ---- | ----------- |
| [getChannelSubscribers()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/subscriptions.md#getchannelsubscribers) | Gets a lits of all users subscribed to a channel. |
| [checkChannelSubscription()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/subscriptions.md#checkchannelsubscription) | Checks to see if a user is subscribed to a specified channel from the channel side. |
| [checkUserSubscription()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/subscriptions.md#checkusersubscription) | Checks to see if a user is subscribed to a specified channel from the user side |

### [Teams](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/teams.md)

| Call | Description |
| ---- | ----------- |
| [getTeams()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/teams.md#getteams) | Gets the team objects for all active teams. |
| [getTeam()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/teams.md#getteam) | Grabs the team object for the supplied team. |

### [Users](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/users.md)

| Call | Description |
| ---- | ----------- |
| [getUserObject()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/users.md#getuserobject) | Grabs an unauthenticated user object for the supplied username. |
| [getUserObject_Authd()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/users.md#getuserobject_authd) | Grabs an authenticated user object for the supplied username.  Contains some sensitive data. |

### [Videos](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/videos.md)

| Call | Description |
| ---- | ----------- |
| [getVideo_ID()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/videos.md#getvideo_id) | Returns the video object for the specified ID. |
| [getVideo_channel()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/videos.md#getvideo_channel) | Returns the video objects of the given channel. |
| [getVideo_followed()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/videos.md#getvideo_followed) | Grabs all videos for all channels a user is following. |
| [getTopVideos()](https://github.com/IBurn36360/Twitch_Interface/blob/master/Modules/videos.md#gettopvideos) | Gets a list of the top viewed videos by the sorting parameters. |
