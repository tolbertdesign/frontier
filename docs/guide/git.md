---
title: Undoing Things in Git
---

## Discarding All local Changes in a file

```sh
git checkout HEAD <filename>
```

## Restoring a Deleted file

```bash
git checkout HEAD <filename>
```

## Discarding Chunks / Lines in a file

```sh
git checkout -p <filename>
```

## Discarding All Local Changes

```sh
git reset --hard HEAD

git reset --mixed <commithash>
```

## Reseting a file to an old revision

```sh
git checkout <commithash> -- <filename>
```

## Reflog

A journal that logs every movement of the HEAD pointer

```sh
git reflog

git branch <branch> <commithash>
feature/login HEAD~1 --hard

git reset --hard HEAD~1

git rebase -i HEAD~3

git commit --fixup <commithash>
git rebase -i HEAD~3 autosquash
```
