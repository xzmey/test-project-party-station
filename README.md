# Test-project-party-station Docker


## Подготовка
Для начала склонируйте проект

## .env
Скопировать .env.example в .env

## Установка / сборка

Из папки с докером (.docker) запустите команду
```
docker-compose up -d
```
Вход `http://localhost:81`

## Полезные команды
Запуск:
```
docker-compose up -d
```
Пересборка контейнера:
```
docker-compose up -d --no-deps --build [container_name]
```
Выполнить команду в контейнере от рута:
```
docker-compose exec -u 0 [container_name] bash -c  'command'
```
## Возможные проблемы

### Нехватает прав
Выдаем права на смонтированную папку(это нужно делать внутри контейнера)
```
chown -R 1000:1000 /var/www
