# Yandex XML Search

PHP-класс для удобной работы с [Яндекс XML](https://xml.yandex.ru/)

```php
$yxml = new yxml($user = '', $key = '', $cache = true, $cache_dir = '');
```

## Параметры:
* **$user** - имя пользователя *(string)*
* **$key** - ключ пользователя *(string)*
* **$cache** - необходимо ли кэширование запросов к XML *(bool)*
* **$cache_dir** - директория для размещения файлов кэша *(string)*

## Методы

### getResult ($keyword, $geo)
Получить результаты поиска по запросу $keyword в регионе $geo
*Возвращаемое значение - string | bool*
```php
$yxml->getResult($keyword = '', $geo = 213);
```
* **$keyword** - ключевое слово *(string)*
* **$geo** - ID региона *(int)*


### position ($domain, $xml_result)
Получить позицию домена в поисковой выдаче
*Возвращаемое значение - string | bool*
```php
$yxml->position($domain = '', $xml_result = '');
```
* **$domain** - имя домена *(string)*
* **$xml_result** - кастомный xml результат *(string)*


### log()
Получить лог работы класса для дебага
*Возвращаемое значение - string*
```php
$yxml->log();
```


## TODO
* Получение кол-ва доступных лимитов

## Полезные ссылки
* [Яндекс XML](http://xml.yandex.ru/)
* [Список регионов и их ID](https://yandex.ru/yaca/geo.c2n)