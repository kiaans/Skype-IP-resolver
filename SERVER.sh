#!/bin/bash
cd "/home/work/Work/skypekit_sdk+runtimes_370_412/skypekit-sdk_runtime-3.7.0/bin/linux-x86/logs"
rm -rf *.*

cd "/home/work/Work/skypekit_sdk+runtimes_370_412/skypekit-sdk_runtime-3.7.0/bin/linux-x86"
./RUNTIME_linux-x86-skypekit-voicertp-videortp_3.7.0 -m -d logs/logs &

sleep 3

cd "/home/work/Work/skypekit_sdk+runtimes_370_412/skypekit-sdk_runtime-3.7.0/examples/python/tutorial"
./server.py work.research qazplm12 &

sleep 10
#python2 server.py research.sal research1212

