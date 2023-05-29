# SETUP
- in the directory of docker-compose.yml run
    - $ docker compose down
    - $ docker compose build
    - $ docker compose up
- in a new terminal tab run
    - $ docker exec php composer require mongodb/mongodb
    - in order to install mongodb source using the composer on the php container
- browse for localhost:8081 and log in with username and password "mexpress" (specified in the docker-compose file)
    - create a database named "wai" and a collection named "users" in the mongo-express gui
- browse for localhost/src/web/index.php and register as a new user

# RESULTS
    localhost/src/web/index.php,
    localhost:8085 -> phpmyadmin,
    localhost:8081 -> mongo express

# SOURCES
https://devops.tutorials24x7.com/blog/containerize-php-with-apache-mysql-and-mongodb-using-docker-containers
https://packagist.org/packages/mongodb/mongodb

# further work
CI/CD: https://docs.docker.com/build/ci/github-actions/