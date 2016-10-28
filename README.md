# YandexXMLSearch

PHP-класс для удобной работы с [Яндекс XML](https://xml.yandex.ru/)

```php
$yxml = new yxml($user = '', $key = '', $cache = false, $cache_dir = '');
```

## Параметры:

* **$user** - имя пользователя (string)
* **$key** - ключ пользователя (string)
* **$cache** - необходимо ли кэширование запросов к XML (bool)
* **$cache_dir** - директория для размещения файлов кэша (string)

## Методы

**getResult** - получить результаты поиска по запросу $keyword в регионе $geo
```php
getResult($keyword = '', $geo = 213)
```
* $keyword - ключевое слово (string)
* $geo - ID региона (int)


Полезные ссылки
-----------------------------------
* [Яндекс XML](http://xml.yandex.ru/)
* [Список регионов и их ID](https://yandex.ru/yaca/geo.c2n)