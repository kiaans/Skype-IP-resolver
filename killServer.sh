#!/bin/bash

kill `ps -ef | grep RUNTIME | awk '{ print $2 }'`
sleep 2
kill `ps -ef | grep server.py | awk '{ print $2 }'`
sleep 2
