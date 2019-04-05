## INSTALLING

### Installing the web gui (basic)

for the basic version just pull the branch web or copy the single index.html file into the server web directory
you need to modify the url to the API to the one corresponding to your envronment setup
line 83 & line 127

### Installing the web gui (pretty)

you will require node.js & npm to make this work

pull the repository to your machine

modify the VUE_APP_API variable in the .env file to the address corresponding to you environment setup (TRAILING FLASH IS REQUIRED)

```run npm serve``` to lunch the application on your desktop

or

```run npm build``` to build the application for publishing on remote server

### Installing the api
just pull or copy the file into your api server

update the ```login.php``` and ```recover.php``` file on line 13 and change the consumer url to the one corresponding to your environmental setup

### Installing the consumer service
pull the file into your server web directory

the repository includes the PHPMailer to eliminate the need to download and configure separate dependency

file ```config.php``` contain database connection details. edit the file to match to your environment. the database structure is as per the task description

inside the ```queue.php``` file you will find the configuration for the email smtp server ( ```function email()``` ) - this need to be updated to reflect your setup. you will have to make sure you have smtp service running to be able to receive emails (I used MailSlurper)


### and the famous last words :)
I have take some liberties in the design. you will see that the api and consumer services are a mixture or procedural and OOP programming, just to show I can do both

I have also made 2 versions of the front end:

basic - with the plain html/javascript/css without use of any frameworks (this is very, very basic)
pretty - modernised version using vue.js & uikit css frameworks

also, for the same purpose of showing I can do both.

and finally, I have tested this across 3 virtual machines and all works fine - however depending on your environment setup, you might have to take care of various other variables, for example CORS
