# copy / updates any changes to site data to host
sh update.sh
# print site url
GREEN="\e[0;32m"
CLEAR="\e[0m"
printf "Site URL:\n$GREEN http://%s:8088 $CLEAR\n" "$(docker-machine -s /tmp/docker ip camagru-docker)"
# initialize / update the stack
docker-compose up --build
