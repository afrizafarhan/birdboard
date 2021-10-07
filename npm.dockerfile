FROM node:14.18-alpine
WORKDIR /var/www
COPY . .
RUN npm install