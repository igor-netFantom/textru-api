# Описание
PHP коннектор для API сайта text.ru.
Легко интегрируется в основные php фреймворки (протестирован на Laravel).

##Установка
composer install textru-api

##Описание API
Используется POST версия API от text.ru, более подробную информацию об API можно найти по ссылке:
https://text.ru/api-check/manual

##Примеры
Все методы можно использовать как статические (без создания класса).

####Добавление текста на проверку
```php
//Добавление текста на проверку
$userkey = 'Ваш text.ru userkey';
$text = 'Проверяемый текст, не менее 100 символов';
$options = ["exceptdomain"=>"mydomain.ru"]; //Необязательный параметр. Массив дополнительных параметров (см. описание API)

$result = TextRuApi::add($userkey, $text);
$uid = $result["text_uid"]; //идентификатор текста, сохраните его для следующего шага
```

####Получение результатов проверки
```php
$jsonvisible = 'detail'; //Необязательный параметр. Укажите "detail" чтобы получить расширенные данные по тексту
$result = TextRuApi::get($userkey, $uid, $jsonvisible);
```

##PHPUnit тесты
Запуск из корня компонента
```bash
phpunit ./tests/AddMethodTest.php --no-coverage
```