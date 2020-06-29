---
title: Debugging
---

## Xdebug

## Installing Xdebug on macOS, Valet, & VSCode with Derick Rethans

## Debug Actions

| Action         | Shortcut                         | Description                           |
| -------------- | -------------------------------- | ------------------------------------- |
| Continue/Pause | <kbd>F5</kbd>                    |                                       |
| Step Over      | <kbd>F10</kbd>                   | Go to the next line in the same scope |
| Step Into      | <kbd>F11</kbd>                   | Go to the next executable statatement |
| Step Out       | <kbd>⇧ Shift</kbd><kbd>F11</kbd> | Finish running this function          |
| Restart        | <kbd>⇧⌘F5</kbd>                  |                                       |

## Launch versus attach configurations

https://code.visualstudio.com/docs/editor/debugging#_launch-versus-attach-configurations

The best way to explain the difference between **launch** and **attach** is to
think of a **launch** configuration as a recipe for how to start your app in
debug mode **before** VS Code attaches to it, while an attach configuration is a
recipe for how to connect VS Code's debugger to an app or process that's
**already** running.
