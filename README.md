# SproutStack Development Environment
#### _Built by SproutDesk_

We've built a set of multi-purpose docker images to host PHP web applications in a production environment, and so we've made them publicly available to run on your own Linux machine for local development here. 

This was built to handle multiple virtual hosts to make switching between projects a breeze, using defined hostnames other than the normal `localhost`, each being able to run their respective PHP versions.

There is a branch `OSX` dedicated to a Mac OS X compatible build, though it should be considered experimental

## Getting Started

### Prerequisites

* Docker
* Docker Compose
* Git
* Linux (preferred)
* Your UNIX user must be a member of the `docker` group & must not be the `root` user.

### Installing

Clone this repo to where you want your development environment to be located, e.g. `$HOME/sproutstack/`

```
$ git clone https://github.com/SproutStack/dev-env.git $HOME/sproutstack
```

Copy the `.env.example` file to `.env`. Then modify the `.env` file to change the User/Group IDs to match the user you're running as.

**Note** The default MySQL password is defined here as "root".
```
$ id -u                   #This returns your User ID
$ id -g                   #This returns your Group ID
$ cp .env.example .env    #Copy the example ENV file over
$ vim .env                #Modify the IDs here (use any text editor)
```

Alternatively you can run this one-liner from the root of the project.
```
$ echo "USERID=`id -u`\nGROUPID=`id -g`\nMYSQL_ROOT_PASSWORD=root" > .env
```

Now you can run `docker-compose up` to boot up the default SproutStack development environment. Note that on first-run it may take a short while as it will need to download the Docker images to run each container.

## Usage

Applications should be built within the `workspace/` folder in the project, which is mounted to `/workspace` in the Nginx & PHP containers.
e.g. `/home/developer/sproutstack/workspace/` on the host would map its path to `/workspace/` within the Nginx & PHP containers

### Creating a new virtualhost/server

//TODO: write about nginx

goto nginx/sites/ & copy and example. Change the server_name, root, and PHP version to what you need.

### Using xDebug

To activate xDebug, open `docker-compose.yml` in a text editor, and append `-xdebug` to the PHP image you want to enable xDebug. Example:

**FROM**
```
....
    phpfpm73:
        image: sproutstack/phpfpm:7.3
        container_name: ss_phpfpm7.3
....
```
**TO**
```
....
    phpfpm73:
        image: sproutstack/phpfpm:7.3-xdebug
        container_name: ss_phpfpm7.3
....
```
The xDebug options can be found in `php/X.X/xdebug.ini` where X.X is the PHP version for the container.
You can find the other xDebug options available [HERE](https://xdebug.org/docs/all_settings)

### Database Management

PHPMyAdmin comes packaged with the development environment as its own container. This can be accessed by visiting `http://localhost:8080/` in your browser. 

### Varnish Caching

//TODO: write about caching.


### Email testing

Each PHP container comes packaged with SSMTP to relay mail to `localhost:25`. This therefore routes to the MailHog container, which will trap all emails sent by PHP's mail function.

You can view trapped emails in your browser by visiting `http://localhost:8025`

For more info on using MailHog, see [HERE](https://hub.docker.com/r/mailhog/mailhog/)

### Using Redis

Redis is available to your application at `127.0.0.1:6379`. No setup is required for local development. 


## Specification
### Images
* **PHP**: 5.6.x, 7.0.x, 7.1.x, 7.2.x, 7.3.x - Extended from official Alpine image
* **Nginx**: 1.15 - Extended from official Alpine image
* **MySQL**: 5.7 - Official image
* **Varnish**: VCL 4.0, Engine 6.1 - Alpine image
* **Redis**: Latest official Alpine image
* **PHPMyAdmin**: Latest official image
* **MailHog**: Latest official image

### Networking/Ports
Nginx, PHP-FPM, and Varnish are run on the host network, rather than behind the docker bridge.
All other containers are bound to ports through the docker bridge.
#### Ports Bound
* **PHP**: 90xx _(9056 for PHP5.6, 9070 for PHP7.0, 9071 for PHP7.1, etc...)_
* **Nginx**: 80 _(HTTP)_ & 443 _(HTTPS - self-signed SSL)_
* **MySQL**: 3306
* **Varnish**: 8888 _(relayed to port 80 for the backend)_
* **Redis**: 6379
* **PHPMyAdmin**: 8080 _(HTTP GUI)_
* **MailHog**: 25 _(SMTP)_ & 8025 _(HTTP GUI)_

## Authors

* **Rhys Botfield** - *Initial work* - [SproutDesk](https://sproutdesk.co.uk/)

## License
