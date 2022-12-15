                                        Docker configuration for the Task-Challange
                                        -------------------------------------------

* Description:
  - Instructions on configuring and running the docker container.

* Files:
  - docker-compose.yml is found in task-challange dir:
      This file defines the multi-container Docker application, and is used to configure each app's services.
  - Dockerfile in the react-website dir:
      This file containes the docker configuration for the react website.

* Step by Step instructions on Installing the dependencies and configurind docker:

  Sail is used for interacting with Laravel's default Docker development environment.
    1- Install the Composer dependencies:
      *composer require laravel/sail --dev
       php artisan sail:install*

  This will create the docker-compose.yml and configure the first app CustomerAPI(task-challange)
  and Postgresql as well as the host and port configurations with the NumverifyAPI.

    2- Add to the task-challange's .env file the following:

      i.
        *APP_PORT=8000*

      This will expose "laravel.test" at the port=8000

      ii.
        *PHONE_API_HOST=task-challange-laravel.phone-api-1
         PHONE_API_PORT=80*

      This will hard code the host and port of the NumverifyAPI being called from the
       CustomerController in the CustomerAPI.

      iii.
        *DB_CONNECTION=pgsql
         DB_HOST=task-challange-pgsql-1
         DB_PORT=5432
         DB_DATABASE=task_challange
         DB_USERNAME=task_challange
         DB_PASSWORD=task@123*

       This is the DB configuration for the Postgresql.

    3- Defining the NumverifyAPI app:
      Note: We are not exposing the NumverifyAPI's port because the CustomerAPI is the only app communicating with it.

    - Add to the docker-compose.yml file the following:
      i.
        *- laravel.phone-api*

      Under the "depends on" tag in the "laravel.test" container. This will link the "laravel.test" container
       to the "laravel.phone-api" container.

      ii.
        *
        laravel.phone-api:
        build:
            context: ./vendor/laravel/sail/runtimes/8.1
            dockerfile: Dockerfile
            args:
                WWWGROUP: '${WWWGROUP}'
        image: sail-8.1/app
        extra_hosts:
            - 'host.docker.internal:host-gateway'
        environment:
            WWWUSER: '${WWWUSER}'
            LARAVEL_SAIL: 1
            XDEBUG_MODE: '${SAIL_XDEBUG_MODE:-off}'
            XDEBUG_CONFIG: '${SAIL_XDEBUG_CONFIG:-client_host=host.docker.internal}'
        volumes:
            - "../NumberValidation:/var/www/html"
        networks:
            - sail
        *


    4-Defining the ReactJS app
      Note: We will create a Dockerfile in the react app directory and refernce it in the docker-compose.yml

    - Add to the docker-compose.yml file the following:
    *
    test_front:
        build:
            context: ../react-website
            dockerfile: Dockerfile
        ports:
            - "3000:3000"
        container_name: test_front
        networks:
            - sail
        depends_on:
            - laravel.test
    *

    - Create the Dockerfile in the react-website dir with the following:
    *
    FROM node:18.12.1

    WORKDIR /usr/src/app/my-app

    COPY . ./

    RUN npm install

    EXPOSE 3000

    CMD ["npm", "start"]
    *

    5- Use
      *Sail up*
      In order to run the container in docker.