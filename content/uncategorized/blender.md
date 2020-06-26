Installing Blender Animation Nodes

Below are the steps required to install Animation Nodes for Blender on Debian
based linux systems.

    sudo apt update
    sudo apt install python3-pip
    sudo apt install unzip
    pip3 install numpy
    pip3 install cython
    Downloaded Source code (zip) from https://github.com/JacquesLucke/animation_nodes/releases/tag/v2.0 (Dl link https://github.com/JacquesLucke/animation_nodes/archive/v2.0.zip)
    Unzipped source code
    cd into source code folder
    python3 setup.py build --export --noversioncheck
    This will give us animation_nodes.zip
    blender -b --python-console
    import bpy
    bpy.ops.wm.addon_install(filepath = '/home/ubuntu/animation_nodes-2.0/animation_nodes.zip', overwrite = True)
    bpy.ops.wm.addon_enable(module = 'animation_nodes')
    bpy.ops.wm.save_userpref()
    exit()
    this will save to /home/ubuntu/.config/blender/2.79/config/userpref.blend
    In real usage www-data user is the one that makes the blends so we need to copy the user preferences file over to www-data's home folder
    cp -rf /home/ubuntu/.config /var/www/
    sudo chown -Rf www-data:www-data /var/www/.config

To test if it works under your current user run the following

    run blender -b whatever_blend.blend -t 0 -x 1 -o "testblenderoutput/" -F PNG -a

To test that it works in with the www-data user

    upload and save new image in funrun.com to spin up a new job on your server.
