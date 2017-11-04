# copy / updates any changes to site data to host
docker-machine -s "/tmp/camagru" scp -d -r ./app/ camagru-docker:/home/docker/camagru 
