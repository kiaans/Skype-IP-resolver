#!/bin/bash

cd "/home/work/Work/skypekit_sdk+runtimes_370_412/skypekit-sdk_runtime-3.7.0/bin/linux-x86/logs"
LOGFILE=$(ls -t | head -n 1)

cd "/home/work/Work/Skype-iplookup"
python2 client-mod.py $1 $LOGFILE

