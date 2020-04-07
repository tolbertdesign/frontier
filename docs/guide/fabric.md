Fabric
Fabric is a lightweight tool written in python that allows engineers and system administrators an easier way to perform otherwise time consuming tasks. As described on their website fabfile.org Fabric is a high level Python (2.7, 3.4+) library designed to execute shell commands remotely over SSH, yielding useful Python objects in return:


Here is a link to the official API documentation: http://docs.fabfile.org/en/2.5/


Contents
1	Pushing Code
2	Compare Environment Files
3	Push Environment File
4	Retrieve Environment File
5	Listing Servers
6	Installing Framework Dependencies
7	Enabling Maintenance Mode
8	Disabling Maintenance Mode
Pushing Code
If you would like to push a specific branch to an environment, you would execute the following

Command

fab deploy("environment", "branch name")


Compare Environment Files
If you would like to compare your local .env file with what is in production, you would execute the following command.

Command

fab diff_env("environment")


Push Environment File
If you would like to push your local .env.environment file to a specific environment, execute the following command.

Command

fab deploy_env("environment")


Retrieve Environment File
This will get the remote .env file and save it locally to .env.environment file.

Command

fab get_env("environment")


Listing Servers
This will list IPs of all servers for a specified environment

Command

fab list_servers("Environment")


Installing Framework Dependencies
This will run the PHP composer command and install all dependencies to the application's root /vendor directory.

Command

fab composer("Environment", "Command")

Enabling Maintenance Mode
This will enable maintenance mode for the specified environment

Command

fab enable_maint_mode("Environment")

Disabling Maintenance Mode
This will disable maintenance mode for the specified environment

Command

fab disable_maint_mode("Environment")
