#!/bin/bash

echo "Installing Java Scripts..."
cd "/home/work/Work/"
chmod +x killServer.sh
chmod +x lookup.sh
chmod +x SERVER.sh

echo "Installing Lookup Scripts..."
cd "/home/work/Work/Skype-iplookup"
chmod +x client-mod.py
chmod +x client.py
chmod +x server.py

echo "Installing Skype Runtime..."
cd "/home/work/Work/skypekit_sdk+runtimes_370_412/skypekit-sdk_runtime-3.7.0/bin/linux-x86"
chmod +x RUNTIME_linux-x86-skypekit-voicertp-videortp_3.7.0

cd "/home/work/Work/skypekit_sdk+runtimes_370_412/skypekit-sdk_runtime-3.7.0/examples/python/tutorial"
chmod +x server.py

#echo "Installing JAVA..."
#cd "/home/work/Work"
#sudo dpkg -i openjdk-7-jre-headless_7u51-2.4.4-0ubuntu0.12.04.2_i386.deb

echo "Downloading and installing required JAVA version..."
sudo apt-get update
sudo apt-get install openjdk-6-jre-headless

echo "Installing XAMPP...Please use default settings on the GUI."
cd "/home/work/Work"
chmod 755 xampp-linux-x64-1.8.3-2-installer.run
sudo ./xampp-linux-x64-1.8.3-2-installer.run

sleep 3

echo "Setting up some files..."
cd "/home/work/Work"
sudo cp -r webapp/ "/opt/lampp/htdocs"
cd /opt/lampp/htdocs/
sudo chmod -R 777 webapp/
sudo rm index.php
sudo cp /home/work/Work/index.php /opt/lampp/htdocs/
sudo chmod 777 index.php

sleep 3

sudo /opt/lampp/lampp restart

sleep 10

cd "/opt/lampp/bin"
./mysql -u root -e "CREATE DATABASE ipmapping" 

sleep 5

./mysql -u root ipmapping < /home/work/Work/ipmapping.sql

sleep 2

echo "First time setup done. Now run the start.sh as per requirement." 
