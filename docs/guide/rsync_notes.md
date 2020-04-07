rsync -avz --exclude 'dir1' source/ destination/
rsync -avz --exclude 'dir*' source/ destination/
rsync -avz --exclude 'dir1/somefile.txt' source/ destination/
rsync -avz --exclude '*.txt' source/ destination/
rsync -avz --exclude file1.txt --exclude dir3/file4.txt source/ destination/
rsync -avz --exclude-from 'exclude-list.txt' source/ destination/
