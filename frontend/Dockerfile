FROM node:9
WORKDIR /app
RUN npm i -g yarn
COPY package.json yarn.lock ./
RUN yarn
COPY . .
CMD [ "yarn", "run", "start" ]
EXPOSE 80
