# marvel-fluentech

#### Clonner le projet #####
git clone https://github.com/ezekiela0701/marvel-fluentech.git

#### bascule en branche develop ####
git checkout develop

#### lancement docker backend ####
-cd backend/docker

-sudo docker compose exec app bash

-composer install

-sudo docker compose up -d --build

-sudo docker compose ps

Base url + endpoint : http://localhost:8000/api/marvel/characters

#### mise en place docker frontend ####
-cd frontend

-npm install

-sudo docker build -t marvel-test .

-sudo docker run -it -p 8082:80 --rm --name dockerize-vuejs-app marvel-test

URL FRONT : http://localhost:8082