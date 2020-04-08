---
title: Deployment
category: DevOps
---

frontier.now.sh
grit.netlify.com

tolbert.design

docs.tolbert.design
app.tolbert.design
api.tolbert.design
examples.tolbert.design





## Communication and Notifications

### Deployment flow

1. Identify a dedicated communication point. This can be either Engineer or QA.Their role is provide all communication status up to and including the final notification.
2. Communication Point shares the Zoom information for deployment in the #deployment channel.
3. Add an initial status: **Release ##170510804 – High Priority Push: Starting deployment.**
4. Communicate status as you go, such as but not limited to:
     1. Deployed to Staging.
     2. Testing in Staging.
     3. Accepted in Staging.
     4. Deploying to Production.
     5. Deployed to Production.
     6. Testing in Production.
     7. Accepted in Production.
     8. Post Release Notification in the "Announce To All" Slack channel

If there are issues, communicate that, too. Its helpful for Support to know if you’ve run into a problem. Think of what would help Chris when dealing with the front line. Finally, wrap up the release similar to how you started. Ex “Release ##170510804 – High Priority Push: Deployment complete, and live in Production.”


::: tip Important note on the above
 Sample statuses are for illustration. You don’t have to use these verbatim. 😊
:::
