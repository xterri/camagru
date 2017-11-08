# copy / update site data to host
docker-machine -s "/tmp/docker" scp -d -r ./app/ camagru-docker:/home/docker/camagru
