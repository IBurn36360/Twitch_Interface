# Requirements  

***  

System and installation requirements of this interface.  

| System Name | Version | Recommended |
| ---- | -------------- | ----------- |
| PHP | Version 4.0.0 or later | 5.0.0 |
| cURL Utilities | Version 1.0 or Higher | NA (All calls are 1.0 compatable) |
| JSON Utilities | Compiled in or added as a PECL extension | Compiled | 

# Kraken API Credentials 

*** 

You do not require credentials for this interface to work, as not all calls require authorization to use.  However, this interface WILL check that you have modified the credential variables and will throw a user level error should you not change them.  

| Variable Name | API key name | Expected type |
| ---- | --------------------- | ------------- |
| $twitch_clientKey | client_key | String |
| $twitch_clientSecret | client_secret | String| 
| $twitch_clientUrl | client_uri | String |

In order to avoid putting in any credentials, you are able to put a space in the string value of the credential to satisfy my chack here.  If you wish to use your credentials, please put them into the file as is from Twitch directly.