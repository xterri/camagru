# set up docker-machine
docker-machine --storage-path "/tmp/docker" -d virtualbox camagru-docker
# set up the environment
eval $(docker-machine -s "/tmp/docker" env camagru-docker)
# create app directory on docker-machine
docker-machine -s "/tmp/docker" scp --delta --recursive ./app/ camagru-docker:/home/docker/camagru
