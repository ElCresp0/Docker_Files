# SETUP
1. in the directory of docker-compose.yml run
```
$ docker compose down
$ docker compose build
$ docker compose up
```
or on next ocasions:
```
$ docker compose start
$ docker compose stop
```
2. in a new terminal tab run
```
$ docker exec php composer require mongodb/mongodb
```
in order to install mongodb source using the composer on the php container

3. browse for localhost:8081 and log in with username and password "mexpress" (specified in the docker-compose file)

4. create a database named "wai" and a collection named "users" in the mongo-express gui

5. browse for localhost/src/web/index.php and register as a new user

# RESULTS
- localhost/src/web/index.php,
- localhost:8085 -> phpmyadmin,
- localhost:8081 -> mongo express

# SOURCES
https://devops.tutorials24x7.com/blog/containerize-php-with-apache-mysql-and-mongodb-using-docker-containers
https://packagist.org/packages/mongodb/mongodb

# TAKE IT FURTHER
CI/CD: https://docs.docker.com/build/ci/github-actions/