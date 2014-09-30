#!/bin/bash

echo "Initiallizing Database..."
sudo /opt/lampp/lampp restart

echo "Starting  Backend..."
java -jar IdToIp.jar
