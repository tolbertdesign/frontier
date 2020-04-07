1. Discarding All local Changes in a file

git checkout HEAD <filename>

2. Restoring a Deleted file

git checkout HEAD <filename>

3. Discarding Chunks / Lines in a file

git checkout -p <filename>

4. Discarding All Local Changes

git reset --hard HEAD

git reset --mixed <commithash>

8. Reseting a file to an old revision

git checkout <commithash> -- <filename>

Reflog -- a journal that logs every movement of the HEAD pointer

git reflog

git branch <branch> <commithash>
feature/login HEAD~1 --hard

git reset --hard HEAD~1

git rebase -i HEAD~3

git commit --fixup <commithash>
git rebase -i HEAD~3 autosquash
