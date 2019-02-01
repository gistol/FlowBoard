# FlowBoard
Jira only than better


# Clone the project

run -> composer install 

Edit your .env file to the required settings. See .env.dist for more information.

run -> npm install 

run -> npm run build

## Creation of the hosts:

Flowboard is domain routed:

### !! If the hosts are not created like below flowboard will not work !!

### DEV ENV:

api.flowboard.local -> location /public folder

authentication.flowboard.local -> location /public folder

dashboard.flowboard.local -> location /public folder

### PROD ENV:

api.flowboard.app -> location /public folder

authentication.flowboard.app -> location /public folder

dashboard.flowboard.app -> location /public folder


## Database

create the database specified in your .env file and run the following script in your project dir

php bin/console doctrine:schema:update -f

Now all the tables should be created happy flowboarding ;)

