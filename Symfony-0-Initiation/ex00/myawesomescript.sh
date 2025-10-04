#!/usr/bin/sh

if [ -z "$1" ]
then
    echo "Error: Missing URL!"
    exit 1
fi

curl -s $1 | grep "body" |cut -d'"' -f2