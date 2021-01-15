#!/usr/bin/env bash

#
# GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
#
# author eidng8
#
#

if [ "-h" == "$1" ] || [ "--help" == "$1" ]; then
    echo "start.sh [swoole]"
    echo "Starts a swoole server, or default PHP dev server if omitted."
    exit
fi

# shellcheck disable=SC2164
WD="$(
    cd "$(dirname "$0")" >/dev/null 2>&1
    pwd -P
)"

USE_IP=0.0.0.0
USE_PORT=8000

DB_DATABASE="$WD/storage/app/database.sqlite"

ip address | grep -F --color=never 'scope global'

if [ "swoole" == "$1" ]; then
    SWOOLE_BOX='TEST_REMOTE_BASE=http://'$(ip address | grep -F --color=never 'scope global' | xargs | cut -d' ' -f2 | cut -d'/' -f1)':1215'
    echo "$SWOOLE_BOX" >.swoole.env
    DB_DATABASE="$DB_DATABASE" SWOOLE_HTTP_HOST="$USE_IP" php "$WD/artisan" swoole:http start
    exit
fi

rm -f .swoole.env
DB_DATABASE="$DB_DATABASE" php -S "$USE_IP:$USE_PORT" -t "$WD/public"
