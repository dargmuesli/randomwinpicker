#!/bin/sh
rm -r /var/www/randomwinpicker/server/*
cp -r /usr/src/randomwinpicker/server/ /var/www/randomwinpicker/

exec "$@"