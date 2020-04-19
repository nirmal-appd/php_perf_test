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
./install.sh -a=e2e-customer@7ac19086-25d6-4c9c-b7cf-e0a2c85d309f -e /usr/lib64/php/modules -p /usr/bin/ -v 7.2 -s master-saas-controller.e2e.appd-test.com 443 phpDockExceptionTest_AppKn dockTierException_Kn dockNodeException_Kn

#run load for DB, redis and
siege URL