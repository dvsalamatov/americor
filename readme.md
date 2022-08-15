# Обсчет стока

## Запуск сборки
 
- `cp .env.dist .env`  
- `docker-compose up -d --build`
- `docker exec -it api_php composer create-project --prefer-dist yiisoft/yii2-app-basic basic`

Команда клонирует yii в папку basic, а надо в корень src. Или переделать команду, или руками вынести файлы Yii в корень src