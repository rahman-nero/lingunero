FROM nginx:1.21-alpine

COPY docker/production/nginx/conf.d/ /etc/nginx/conf.d/
COPY docker/production/nginx/nginx.conf /etc/nginx

WORKDIR /var/www/

COPY . .
