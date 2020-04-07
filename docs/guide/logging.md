---
title: Logging
categories: engineering, standards
---

| Level     | Description                                                                         | Action Steps                                                                                                |
| --------- | ----------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------- |
| Info      | Something worth making not of for future discovery reasons.                         | No action required.                                                                                         |
| Warning   | Failed but recovered logging.                                                       | No action required. Review warning report regularly.                                                        |
| Error     | Something failed gracefully and couldn't recover, but was of a non-critical nature. | No immediate action required. Review error report regularly.                                                |
| Critical  | A failure that needs to be addressed immediately.                                   | Send alerts (Slack or email). Have 1 team member investigate and quarterback as needed.                     |
| Emergency | Critical operational failure.                                                       | Send alerts (Slack, email, text, and/or phone calls), All team members required to investigate immediately. |
