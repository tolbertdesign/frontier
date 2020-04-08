---
title: Fabric
description: Fabric is a lightweight tool written in python that allows engineers and system administrators an easier way to perform otherwise time consuming tasks. 
---



As described on their website fabfile.org Fabric is a high level Python (2.7, 3.4+) library designed to execute shell commands remotely over SSH, yielding useful Python objects in return:


Here is a link to the official API documentation: http://docs.fabfile.org/en/2.5/

## Pushing Code

To push a specific branch to an environment

```sh
fab deploy("environment", "branch name")
```

## Compare Environment Files

To compare your local `.env` file with what is in production

```sh
fab diff_env("environment")
```

## Push Environment File

To push your local `.env.environment` file to a specific environment

```sh
fab deploy_env("environment")
```

## Retrieve Environment File

Get the remote `.env` file and save it locally to `.env.environment`

```sh
fab get_env("environment")
```

## Listing Servers

List IPs of all servers for a specified environment

```sh
fab list_servers("Environment")
```

## Installing Framework Dependencies

Run the PHP composer command and install all dependencies to the application's root `/vendor` directory.

```sh
fab composer("Environment", "Command")
```

### Enabling Maintenance Mode

Enable maintenance mode for the specified environment

```sh
fab enable_maint_mode("Environment")
```

## Disabling Maintenance Mode

Disable maintenance mode for the specified environment

```sh
fab disable_maint_mode("Environment")
```
