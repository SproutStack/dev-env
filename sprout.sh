#!/bin/bash
here="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd )"

if [ -t 0 ]; then
	DOCKER_FLAGS="-it"
else
	DOCKER_FLAGS="-t"
fi
if [ -f ${here}/.env ]; then
	source ./.env
fi

docker run \
--rm \
${DOCKER_FLAGS} \
-v "${here}:/sproutstack" \
-w "/sproutstack" \
-u="${USERID:-1000}:${GROUPID:-1000}" \
-e="TERM=xterm-256color" \
php:cli-alpine \
php -d memory_limit=1024M sproutstack "$@"

