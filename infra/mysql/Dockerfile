FROM mysql:5.7

ENV MYSQL_DATABASE=laravel_local \
#   MYSQL_USER=phper \
  MYSQL_USER=root \
  MYSQL_PASSWORD=secret \
  MYSQL_ROOT_PASSWORD=secret \
  TZ=Asia/Tokyo

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
RUN chmod 644 /etc/mysql/conf.d/my.cnf