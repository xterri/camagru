# set up docker-machine
docker-machine --storage-path "/tmp/docker" create -d virtualbox camagru-docker
# set up the environment
eval $(docker-machine -s "/tmp/docker" env camagru-docker)
# create app directory on docker-machine
docker-machine -s "/tmp/docker" scp --delta --recursive ./ camagru-docker:/home/docker/camagru
