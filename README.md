# YandexXMLSearch

PHP-����� ��� ������� ������ � [������ XML](https://xml.yandex.ru/)

```php
$yxml = new yxml($user = '', $key = '', $cache = false, $cache_dir = '');
```

## ���������:

* **$user** - ��� ������������ (string)
* **$key** - ���� ������������ (string)
* **$cache** - ���������� �� ����������� �������� � XML (bool)
* **$cache_dir** - ���������� ��� ���������� ������ ���� (string)

## ������

**getResult** - �������� ���������� ������ �� ������� $keyword � ������� $geo
```php
getResult($keyword = '', $geo = 213)
```
* $keyword - �������� ����� (string)
* $geo - ID ������� (int)


�������� ������
-----------------------------------
* [������ XML](http://xml.yandex.ru/)
* [������ �������� � �� ID](https://yandex.ru/yaca/geo.c2n)