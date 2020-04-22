#!/bin/sh
dir = "/opt/appd/php_agent"

#remove php agent

#go to folder
cd $dir
#shutdown server if running
apachectl stop

#run uninstall
./install.sh -u
#delete agent install folder
#go one dir back
cd ../
#run rm command on install folder
rm -rf *