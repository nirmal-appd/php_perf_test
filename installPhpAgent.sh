#!/bin/sh
dir = "/opt/appd/php_agent"
extract_dir = "php_agent_files"
#check if a diretory exist
if [! -d "$dir"]
then
    #dir not exist
    mkdir $dir
fi

cp $1 $dir
cd $dir

Dir_name=`tar -tzf $1 | head -1 | cut -f1 -d"/"`
echo $Dir_name
tar -xzvf $1
#go to extracted folder
cd $Dir_name

#run install command
./install.sh -e /usr/lib64/php/modules -p /usr/bin/ -v 7.2 -s $2 443 $3 $4 $5

#run load for DB, redis and
siege URL