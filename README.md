#[UNSTABLE] Twitch Interface V2

[![Build Status](https://travis-ci.org/IBurn36360/Twitch_Interface.svg?branch=master)](https://github.com/IBurn36360/Twitch_Interface)

##[PHP] Twitch Interface

This is a universal PHP interface designed specifically to connect to and interact with the twitch.tv Kraken API servers.  It was designed with the intention of being very controlled, safe and light for both the user server and the Kraken API servers.  Almost, if not all capable calls are coded directly into the interface, allowing the interface to perform almost, if not all functions that the API allows.  Any functions that you believe need to be added or improved can be done via a pull request or opening up an issue.

Currently this interface supports all V5 API calls.

#Disclaimer
I am in no way, shape or form associated with, in contract with or partnered with Twitch.  This interface is not officially sponsored, endorsed or supported by Twitch.  For support on this interface, you may open an issue.  Please DO NOT post for help on the developer forums.  That is not the place to get library specific help.  If you require help in understanding the API, the purpose of endpoints, or help in general with figuring out the workflow for your application, please go to the support forums for those kinds of queries. (No, no one at Twitch asked me to do this...but I saw a few posts asking specifically about my code and that is not the place to get help with the library, here is)

###License (TL`DR version)

You can do whatever you want with this piece of software, including modifying it and using it in any way, shape or form.  The only requirement is that you keep the credit and the license in the header of the file itself and that you not, in any circumstances redistribute the file in question for the safety of any people who wish to use this software.  If you wish to have other people use this software, it is best that you give them the link to this particular git for the latest version of this software and to allow them to find all of the information relating to this piece of software.

For any information about the interface, please look in the module list below.

# Advantages

1. Covers all endpoints for the Kraken V5 API, using a nearly identical structure to Twitch's own documentation.
2. Smart memory management when making calls
3. Exception-based error handling for consistent and clean results in production environments
4. Built-in iterator for making calls over large datasets
5. Built-in authorization validation

#Installation
You may either download the library, or use Composer.  Composer is the preferred method of installation for current and dev versions of the library.

##Composer
If you do not already have Composer installed, please [install composer using the instructions here]().

Once composer is installed, you can install the following package using whatever your composer implementation demands.

<pre>iburn36360/twitch-interface</pre>

If you are using composer from the command line, go to your sources directory and run the following command (Replace composer.phar with the real location of your composer PHPArchive and be sure PHP is an environment variable for your system.  If you run into errors...these are your issues to google about)

<pre>php composer.phar require iburn36360/twitch-interface</pre>

Once the package is installed, be sure to include the composer autoloader in your runtime and you'll have access to the interface.

#Examples

#Documentation
