#!/usr/bin/env bash

#
# GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
#
# author eidng8
#
#

APP_KEY=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
echo APP_KEY=$APP_KEY
echo APP_KEY=$APP_KEY >> .env
