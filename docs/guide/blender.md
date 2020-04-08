---
title: Installing Blender
---

Below are the steps required to install Blender on Debian based linux systems.

apt-get install libglu1-mesa-dev
wget <http://mirror.cs.umn.edu/blender.org/release/Blender2.78/blender-2.78c-linux-glibc219-x86_64.tar.bz2>
tar xvf blender-2.78c-linux-glibc219-x86_64.tar.bz2
mv blender-2.78c-linux-glibc219-x86_64 /opt/blender
ln -s /opt/blender/blender /usr/bin
