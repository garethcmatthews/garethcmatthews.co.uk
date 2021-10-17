# DOCKER HUB: https://hub.docker.com/_/mysql/
FROM mysql:8.0.22

COPY ./create_garethcmatthews.sql /docker-entrypoint-initdb.d/1.sql
COPY ./create_garethcmatthews_testing.sql /docker-entrypoint-initdb.d/2.sql
COPY ./create_phpmyadmin.sql /docker-entrypoint-initdb.d/3.sql

# Docker
EXPOSE 3306
