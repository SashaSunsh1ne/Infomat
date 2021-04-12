# Infomat
## 1 Файл настроек - config.txt
### 1.1 Расположение
Файл с параметрами должен быть расположен в папке /config и иметь название config.txt
### 1.2 Параметры
Данный файл понимает такие параметры как:
* Api-key - ключ приложения к базе данных;
* Port-Name - название порта соединенного со считывателем штрих-кодов, например, COM9;
* Port-OpenMode - права доступа к порту (чтение/запись и т.п., подробнее [fopen()](https://www.php.net/manual/ru/function.fopen.php);
* Port-BaudRate - скорость передачи данных;
* Port-Parity - проверка чётности;
* Port-CharacterLength - биты данных, то есть сколько бит передавать за один раз;
* Port-StopBits - количество стоп-бит, необходимых для правильного распознавания конца байта;
* Port-FlowControl - управление потоком, выбор режима управления потоком;

Обязательные параметры:
* Api-key
* Port-Name

Значения по умолчанию: 
```ini
Port-OpenMode        : r;
Port-BaudRate        : 9600;
Port-Parity          : none;
Port-CharacterLength : 8;
Port-StopBits        : 1;
Port-FlowControl     : none;
```
### 1.3 Синтаксис
При заполнении файла с настройками важно придерживаться синтаксиса. В противном случае программа может работать некорректро или не рабоать совсем.

Каждую настройку необходимо писать таким образом:
```ini
НазваниеПараметра : ЗначениеПараметра;
```
Пример заполнения файла:
```ini
Api-key              : fsof00af9fbg08derjvsre9;
Port-Name            : COM1;
Port-OpenMode        : r;
Port-BaudRate        : 9600;
Port-Parity          : none;
Port-CharacterLength : 8;
Port-StopBits        : 1;
Port-FlowControl     : none;
```
Порядок параметров в данном файле соблюдать необязательно.
