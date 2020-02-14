#!/bin/sh
rm -r /var/www/randomwinpicker/server/*
cp -a /usr/src/randomwinpicker/server/ /var/www/randomwinpicker/

exec "$@"