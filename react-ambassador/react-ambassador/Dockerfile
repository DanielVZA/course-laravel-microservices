FROM node:15.4 as build

WORKDIR /app

COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

FROM nginx:1.19

WORKDIR /usr/share/nginx/html
RUN rm -rf ./*

COPY --from=build /app/build .