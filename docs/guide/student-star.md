---
title: Student Star
---

## Deploying Student Star

Below are the steps required to deploy a new release of the Student Star application.

- Start up a blender server
- Remove it from the server list
- Upload new content
- Fix supervisor to manage the redis queue under www-data user for the process
- Make image
- Edit `env` to use new image
- Push `env`
- Push new code
- Run Migration
