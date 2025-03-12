#frontend/Dockerfile
FROM node:18-alpine

WORKDIR /app

# Script de démarrage
COPY ./start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 3000

CMD ["/usr/local/bin/start.sh"]