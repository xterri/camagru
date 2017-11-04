# set up docker-machine
docker-machine --storage-path "/tmp/camagru" -d virtualbox camagru-docker
# set up the environment
eval $(docker-machine -s "/tmp/camagru" env camagru-docker)
# create app directory on docker-machine
docker-machine -s "/tmp/camagru" scp --delta --recursive ./app/ camagru-docker:/home/docker/camagru
