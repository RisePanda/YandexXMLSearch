# Yandex XML Search

PHP-����� ��� ������� ������ � [������ XML](https://xml.yandex.ru/)

```php
$yxml = new yxml($user = '', $key = '', $cache = true, $cache_dir = '');
```

## ���������:

* **$user** - ��� ������������ (string)
* **$key** - ���� ������������ (string)
* **$cache** - ���������� �� ����������� �������� � XML (bool)
* **$cache_dir** - ���������� ��� ���������� ������ ���� (string)

## ������

### getResult
�������� ���������� ������ �� ������� $keyword � ������� $geo
```php
$yxml->getResult($keyword = '', $geo = 213);
```
* $keyword - �������� ����� (string)
* $geo - ID ������� (int)

### position
�������� ������� ������ � ��������� ������
```php
$yxml->position($domain = '', $xml_result = '');
```
* $domain - ��� ������ (string)
* $xml_result - ��������� xml ���������

### log
�������� ��� ������ ������ ��� ������
```php
$yxml->log();
```

�������� ������
-----------------------------------
* [������ XML](http://xml.yandex.ru/)
* [������ �������� � �� ID](https://yandex.ru/yaca/geo.c2n)