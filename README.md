# O Projeto

Criando um projeto Symfony 5.4, com docker, mariadb e phpmyadmin.

## Docker com Symfony

Instale o PHP 7.4 (que são instaladas e habilitadas por padrão na maioria das instalações do PHP 7.4): 
* Ctype, 
* iconv, 
* PCRE, 
* Session, 
* SimpleXML, e
* Tokenizer.

[Instale o Composer](https://getcomposer.org/download/) , que é usado para instalar pacotes PHP.

Opcionalmente, você também pode instalar o [Symfony CLI](https://symfony.com/download). 

Isso cria um binário chamado symfonyque fornece todas as ferramentas necessárias para desenvolver e executar seu aplicativo Symfony localmente.

**Verificação dos requisitos:**
```
symfony check:requirements
```
# Execução do Projeto

```
docker composer up -d
```

### Criar ``tópico`` no Kafka

```
docker compose exec -it kafka bash

kafka-topics --bootstrap-server localhost:9092 --create --topic pdde-emails --partitions 3 --replication-factor 1
```

### Administração do RabbitMQ

Administração: `http://localhost:15672/`

### Enviando requisições para filas

Ações configuradas na [DefaultController](app/src/Controller/DefaultController.php)

RabbitMQ: `http://localhost:8083/fila`

Kafka: `http://localhost:8083/kafka`

# Passos usados na criação do projeto

## 1. Estrutura de pastas


```
mkdir docker-symfony-6 && touch .env && touch .gitignore && touch docker-compose.yml && touch README.md
```


```
mkdir docker && cd docker && mkdir database && mkdir logs && mkdir nginx && mkdir php-fpm
```

```
cd database && mkdir data && touch Dockerfile && touch init.sql
```

```
cd ../logs && mkdir nginx && cd nginx && touch access.log && touch error.log && touch .gitignore && cd ../../nginx && touch Dockerfile
```

```
touch nginx.conf && mkdir conf.d && mkdir sites && cd  conf.d && touch default.conf && cd ../sites && touch default.conf
```

```
cd ../../php-fpm && touch wait-for-it.sh && touch Dockerfile && cd ../..
```


## 2. Criar projeto Symfony `app`

```shell
symfony new app --version="5.4.*" --webapp
```

### Dependências 

**RabbitMQ**
```shell
composer require symfony/amqp-messenger
```
*e configurações no arquivo `config/packages/messenger.yaml`*


**Apache Kafka**
```shell
composer req symfony/messenger enqueue/rdkafka enqueue/enqueue-bundle sroze/messenger-enqueue-transport enqueue/async-event-dispatcher
```
*e configurações no arquivo `config/packages/messenger.yaml` e `config/packages/enqueue.yaml`*

## Apache Kafka

Docker php alpine
```
RUN apk add librdkafka-dev && \
	mkdir -p /usr/src/php/ext/rdkafka && \
    curl -fsSL https://pecl.php.net/get/rdkafka | tar xvz -C "/usr/src/php/ext/rdkafka" --strip 1 && \
    docker-php-ext-install rdkafka
```


[StackoverFlow - Kafka no Symfony](https://stackoverflow.com/questions/58317692/symfony-messenger-with-apache-kafka-as-queue-transport)

``composer req symfony/messenger enqueue/rdkafka enqueue/enqueue-bundle sroze/messenger-enqueue-transport enqueue/async-event-dispatcher``

```
docker exec -it kafka_sisalfa /bin/bash
kafka-topics --bootstrap-server kafka:9092 --create --topic pdde-emails --partitions 3 --replication-factor 1
kafka-topics --bootstrap-server kafka:9092 --list
```

**Consumer**
`php bin/console messenger:consume kafka`

