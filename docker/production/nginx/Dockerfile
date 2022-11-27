FROM nginx:1.21-alpine

COPY ./docker/production/nginx/nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/

COPY ./backend /var/www
