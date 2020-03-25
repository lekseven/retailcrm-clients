FROM alpine

RUN apk add --update --no-cache nginx

COPY nginx.conf /etc/nginx/
COPY clients.retailcrm.conf /etc/nginx/conf.d/

RUN adduser -D -g '' -G www-data www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
