# mfl-test
This is simple system build using Extjs, Javascript and Php to demonstrate:
A simple user interface for capturing data,retrieving and displaying data entered

It allows the user to add new data using the build in form UI in addition to a rest endpoint 

It also utilizes various user notifications to allow the users to confirm various actions eg, when attempting
to delete a record.

Requirements:
Apache, Mysql is required to deploy the system.

Api usage:
For instance creating a new facility can be achieved through usage of
/server/add.php with the following JSON payload:

{
"name": "Matayos Health Center",
"status": "Operational"
}

App Demo:
A demo of the app is available at https://intellibizafrica.co.ke/mfl