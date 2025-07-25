# Etapa base
FROM node:18-alpine AS base
WORKDIR /api
COPY package*.json ./
RUN npm install
COPY . .

# Desenvolvimento
FROM base AS dev
EXPOSE 5173
CMD ["node", "server.js"]

# Build produção
FROM base AS build
RUN npm run build
