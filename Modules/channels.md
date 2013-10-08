# Chsnnels  

***  

These calls handle everything about getting channel data and updating channel data  

| Call | Description |
| ---- | ----------- |
| [twitch::getChannelObject()]() | Gets an unauthenticated channel object for the target channel. |
| [twitch::getChannelObject_Authd()]() | Gets an authenticated channel object using an OAuth token as the identifying parameter. |
| [twitch::getEditors()]() | Grabs a list of all editors to targe channel. |
| [twitch::updateChannelObject()]() | Updates the target channel with new information. |
| [twitch::resetStreamKey()]() | Attempts to reset target channels stream key and have a new one generated. |
| [twitch::startCommercial()]() | Attempts to start a commercial on target channel. |

***  

## `twitch::getChannelObject()`  

Grabs a channel object containing all publicallly available data for that channel.  

