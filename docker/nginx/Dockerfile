FROM nginx:alpine

RUN apk update \
    && apk add curl vim wget bash acl

COPY nginx.conf /etc/nginx/

# remove the default domain conf
RUN rm /etc/nginx/conf.d/default.conf