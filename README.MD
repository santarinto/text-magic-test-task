### Тестовое задание

~~В контейнере только БД, потому что по умолчанию так делает SymfonyInstaller. Если критично - доработаю.~~
все перенес в докер контейнер

список доступных команд можно посмотреть командой `make`

Установка: 

1. Собрать `make build`
2. Запустить `make up`
3. Установить зависимости `make dev- composer-install`


### Тесты

Запускаются командой 

```bash
php vendor/bin/codecept run Unit 
```

Сразу минус, возникла проблема с одним из пакетов связывающих Codeception и Symfony. Не разобрался, так как это тестовое.  Но в идеале там должны быть и функциональные тесты. Поповоду теста сервиса `FuzzyLogicExpressionSolverService` по идее конечно нужно было бы тестировать и `event` и его обработку, но это доп время извините. Так что я его просто озеленил `mock` объектом. В работе я бы конечно же написал тесты полностью.

### Задание

Команды для выполнения задания:


Проверка файла с заданиями, выводит количество заданий и количество вопросов в каждом задании.
```bash
make app-tests-parse
```

Запускает все тесты, самая комплексная команда, также сохраняет их в БД
```bash
make app-tests-run
```

Выводит историю запуска тестов (без возможности навигации по истории)
```bash
make app-tests-history
```

Выводит результат запуска теста по ID. По идее команда должна была "проиграть" его (чтобы отразить работу event-dispatcher подхода), но мне переезжать надо :), сорри.
```bash
make app-tests-rewind <TEST_ID>
```
