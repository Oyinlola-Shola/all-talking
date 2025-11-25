ANSOFRA WAS DEVELOPED AND MAINTAINED BY NEWDICH TECHNOLOGY(A Software Engineering firm)
OFFICIAL WEBSITE: WWW.NEWDICH.TECH | SUPPORT EMAIL: NEWDICHNGR@GMAIL.COM | FACEBOOK: FACEBOOK.COM/NEWDICH
CREATED BY: SAMUEL IDEBI(A senior Software Engineer at NEWDICH TECHNOLOGY)
DESCRIPTION: ANSOFRA IS A FRAMEWORK THAT IS PERFECT FOR DEVELOPING ANY SOFTWARE.
THE NAME ANSOFRA IS AN ACRONYM OF THE PHRASE: ANY SOFTWARE FRAMEWORK(ANSOFRA)
IT FOLLOWS THE CQRS(COMMAND QUERY RESPONSIBILITY SEGREGATION) PATTERN WHICH IS A PERFECT ARCHITECTURE FOR BUILDING ANY SOFTWARE INCLUDING ENTERPRISE APPLICATIONS
IT MAKES MVP FASTER.
ANSOFRA SPEEDS UP DEVELOPMENT BY 60%
SOFTWARES BUILT WITH ANSOFRA FRAMEWORK ARE EASY TO MAINTAIN.
ANSOFRA ALLOWS A .NET DEVELOPER, JAVA DEVELOPER, C++ DEVELOPER TO EASILY GET ON AND EASILY BUILD IN PHP
TO USE ANSOFRA, YOU SHOULD HAVE A SOUND KNOWLEDGE IN CQRS ARCHITECTURE PATTERN.

BELOW ARE SOME DIRECTORIES AND FILES TO UNDERSTAND IN ANSOFRA.
index.php
    is the entry to the framework.
    it contains the autoload, it is where all request land before sending it to route

route
    The route directory contains an index.php file which receives the request sent from
    the landing index.php
    From the route directory, requests are then passed to the Controllers of
    the microservices in the apis directory, app directory, src directory.
    The namespace is NewdichRoute

apis
    This is the directory that contains microservices of API or third parties
    It contains an index.php file which is just a file for prevention
    It contains a DTO directory for Data Transfer Objects(stored in ApisDTO.php) of these third parties APIs
    It can contain microservices of other third parties APIs(Each microservice has Command, Controller, Query,)
    The namespace is NewdichApis

app
    The app directory is the backend for users and it contains all the apis microservices of users on this project, 
    it is scannable on Swagger framework(that is it works with swagger)
    It contains the Auth directory for Authentication and Authorization
    It contains the Cache directory for In-Memory(RAM) services like Redis or Memchache
    It contains a docs directory which is holds the JSON documentation(newdichapp.json) for Swagger framework
    It contains a DTO directory for Data Transfer Objects(AnsofraAppDto.php)
    It contains a Middleware directory, the Middleware has methods that can run on requests/responses
    It contains a swagger directory, the GUI for swagger documentation. This directory has an index.html file that can be loaded on a browser to show/see the API documentation for the whole app/ main directory
    It contains AppSpecification.php which is the file that contains the Info Details of the app/ swagger documentation
    It contains an index.php file, which is just an empty file(do not touch it).
    It can contain as many microservices as you want, for example, a default Account/ and Wallet/ microservices comes with it, which you may delete if you don't need it.
    The namespace is NewdichApp

Mail
    This is the directory for sending notifications via Emails, SMS, WhatsApp, Telegram, etc..
    The class NewdichMailer is the class that sends Emails
    The class NewdichSms is the class that sends SMS
    The class NewdichWa is the class that sends WhatsApp notifications/messages
    The class NewdichTg is the class that sends Telegram notifications/messages
    The namespace is NewdichMail

public
    The public folder is the directory for the FrontEnd
    It has an admin/ directory which is the FrontEnd for admins, this sends and receives requests and responses from the src/ directory
    It contains assets/ directory that stores all the static assets like images, videos, gifs, favicon, logos, etc..
    It contains css/ directory that stores the CSS styling codes
    It contains js/ directory that stores the JS codes
    index.html is the landing page to the FrontEnd(This is where all users to the app lands)

Schema
    The Schema directory houses everything about the Database and the settings of the software
    The Dealer.php file contains the server connection codes
    index.php is an empty file(do not touch)
    Migration.php contains Database Migration codes
    Platform.php contains the lists of Database tables and the table Ids
    Settings.php contains the software's configuration like port, ips, names, otp emails, etc..
    The namespace is NewdichSchema

src
    The src/ directory is the backend for admins.
    It can contain all the microservices for admins only
    it is scannable on Swagger framework(that is it works with swagger)
    It contains the Auth directory for Authentication and Authorization
    It contains the Cache directory for In-Memory(RAM) services like Redis or Memchache
    It contains a docs directory which is holds the JSON documentation(newdichsrc.json) for Swagger framework
    It contains a DTO directory for Data Transfer Objects(AnsofraSrcDto.php)
    It contains a Middleware directory, the Middleware has methods that can run on requests/responses
    It contains a swagger directory, the GUI for swagger documentation. This directory has an index.html file that can be loaded on a browser to show/see the API documentation for the whole app/ main directory
    It contains SrcSpecification.php which is the file that contains the Info Details of the app/ swagger documentation
    It contains an index.php file, which is just an empty file(do not touch it)
    It can contain as many microservices as you want.
    The namespace is NewdichSrc

vendor
    The vendor/ directory contains all installed PHP libraries usable in your project

composer.json
    This file contains list of all installed PHP libraries
    It also contains autoload namespace declaration(psr-4) and other important PHP setups in your project in a JSON format
    Note: whenever you make any changes to your composer.json, always dump composer by running:
        composer dump-autoload
composer.lock
    It contains the locked of the composer.json file

ansofra-generator.sh 
    This is a shell file that generates the swagger annotation JSON documentation into the docs/ directory of /app and /src respectively.
    After you have made any changes to your Swagger/OpenApi annotations endponts, you must execute this file by running:
        ./ansofra-generator.sh

USING ANSOFRA
TO USE ANSOFRA, YOU MUST INSTALL IT GLOBALLY ON YOUR DEVICE/MACHINE.
MAKE SURE YOU ALREADY HAVE composer INSTALLED.
THEN FOLLOW THESE STEPS.

STEP 1 : INSTALL ANSOFRA GLOBALLY
OPEN YOUR TERMINAL AND RUN:
    composer global require newdich/ansofra

STEP 2 : CONFIRM ANSOFRA IS INSTALLED
TO CONFIRM IT'S INSTALLED, OPEN YOUR TERMINAL AND RUN
    ansofra --version
YOU SHOULD SEE SOMETHING LIKE: ANSOFRA BY NEWDICH TECHNOLOGY
NOTE: IF YOU GET command not found ERROR, MAKE SURE TO ADD YOUR COMPOSER BIN TO YOUR ENVIRONMENT PATH

STEP 3 : CREATE YOUR PROJECT(APP/SOFTWARE) WITH ANSOFRA
NOW THAT YOU HAVE ANSOFRA INSTALLED ON YOUR MACHINE, YOU CAN NOW CREATE YOUR SOFTWARE FRAMEWORK WITH IT.
cd TO WHERE YOU WANT TO CREATE THE PROJECT AND RUN
    ansofra new name_of_your_project
EXAMPLE
    ansofra new myEcommerce
IT WILL CREATE A PROJECT NAMED myEcommerce WITH ALL THE ANSOFRA FRAMEWORKS(DIRECTORIES AND FILES) IN IT.
IT WILL ALSO START A SERVER AT http://localhost:8000
OPEN YOUR BROWSER AND LOAD https://localhost:8000 AND YOU SHOULD SEE THE ANSOFRA PAGE.
CONGRATULATIONS!! YOU CAN NOW START CODING AND USE..

STEP 4(OPTIONAL) : ALWAYS UPDATE YOUR ANSOFRA
WE REGULARLY MAINTAIN THE ANSOFRA FRAMEWORK, SO IT'S A GOOD PRACTICE TO ALWAYS UPDATE YOUR ANSOFRA ON YOUR MACHINE
TO UPDATE YOUR ANSOFRA, RUN
    composer global update newdich/ansofra