#build project

echo -en "\033[37;1;41m Building project \033[0m" &&
echo -en "\n" &&
docker-compose up -d --build site &&

#composer install
echo -en "\033[37;1;41m composer install... \033[0m" &&
echo -en "\n" &&
docker-compose run --rm composer install &&

#generate key
echo -en "\033[37;1;41m key:generate... \033[0m" &&
echo -en "\n" &&
docker-compose run --rm artisan key:generate  &&

#migrate db
echo -en "\033[37;1;41m migrate tables database... \033[0m" &&
echo -en "\n" &&
docker-compose run --rm artisan migrate &&

#seeds
echo -en "\033[37;1;41m seeds... \033[0m" &&
echo -en "\n" &&
docker-compose run --rm artisan migrate --seed &&

#passport
echo -en "\033[37;1;41m passport:install... \033[0m" &&
echo -en "\n" &&
docker-compose run --rm artisan passport:install &&

#npm install
echo -en "\033[37;1;41m npm install... \033[0m" &&
echo -en "\n" &&
docker-compose run --rm npm install &&
docker-compose run --rm npm audit fix &&

#npm run prod
echo -en "\033[37;1;41m npm run prod... \033[0m" &&
echo -en "\n" &&
docker-compose run --rm npm run prod

#start laravel-websocket server and queue server
#echo -en "\033[37;1;41m starting demons... \033[0m" &&
#echo -en "\n" &&
#docker-compose run --rm demons