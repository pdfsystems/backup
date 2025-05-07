ARG PHP_VERSION=8.4
FROM 692057070962.dkr.ecr.us-east-1.amazonaws.com/sail:${PHP_VERSION}

ARG WWWGROUP

RUN groupadd --force -g $WWWGROUP sail
RUN useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail
