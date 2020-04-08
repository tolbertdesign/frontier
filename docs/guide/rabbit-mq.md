---
title: RabbitMQ
---

## RabbitMQ Setup


Steps to Setup RabbitMQ on Ubuntu Server

Add the following line to your `/etc/apt/sources.list`

`deb http://www.rabbitmq.com/debian/ testing main`

```sh
wget http://www.rabbitmq.com/rabbitmq-signing-key-public.asc
sudo apt-key add rabbitmq-signing-key-public.asc
sudo apt-get update
sudo apt install rabbitmq-server
sudo service rabbitmq-server start
sudo rabbitmq-plugins enable rabbitmq_management No longer valid in 2.7.1, also provided by scalr.
sudo rabbitmqctl add_user admin password
sudo rabbitmqctl set_user_tags admin administrator
sudo rabbitmqctl set_permissions -p / admin ".*" ".*" ".*"
sudo rabbitmqctl delete_user guest
sudo service rabbitmq-server restart
sudo rabbitmqctl status
```

For monitoring, to see RabbitMQ Management Plugin: The web UI is located at:

http://server-name:15672/

For Initial Test of CodeIgniter / RabbitMQ / php-amqplib client library add a test email address in rabbitmq controller in test_mail action open browser to http://staging.funrun.com/rabbitmq/test_mail to queue a test message verify message is queued using RabbitMQ Management Plugin in separate window open browser to http://staging.funrun.com/rabbitmq/mail_worker to load a messgae consumer/worker verify message was proceesed using RabbitMQ/CI and that email was sent Run Mail Workers once Initial testing Complete ./scripts/rmq_worker.sh mail_worker run 5 times to start mail workers

./scripts/rmq_worker.sh model_method_worker run 3 times to start model method workers

and

Pledge completion quicker As a student, when completing a pledge pledge success takes awhile. Lets make refresh immediately the page to "My Pledges"

If success: Thank you message

if failure: failure message
