# Table of contents
* [Introduction](#introduction)
* [install the demo site locally](#install-the-demo-site-locally)

# Introduction #

# install the demo site locally #
- install docker (see : https://docs.docker.com/engine/install/ )
- go to the **parent's path** of the project
- download the project
> git clone git@github.com:clopenclassrooms/p5.git
- build the docker image
> cd ./p5/docker
> 
> docker build -t p5:v0.1 .
- launch the docker container
> docker run -i -t -p "80:80" -p "3306:3306" -v <parent's path>/p5/website:/app -v <parent's path>/p5/mysql:/var/lib/mysql p5:v0.1
- test in test in a browser 
> http://localhost


