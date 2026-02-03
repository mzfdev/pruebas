# Etapa de construcción
FROM node:18-alpine AS builder

# Establecer el directorio de trabajo
WORKDIR /app

# Copiar package.json y package-lock.json
COPY package*.json ./

# Instalar dependencias
RUN npm ci --only=production

# Copiar el código fuente
COPY . .

# Construir la aplicación
RUN npm run build

# Etapa de producción
FROM nginx:alpine

# Copiar el resultado de la construcción a nginx
COPY --from=builder /app/build /usr/share/nginx/html

# Copiar configuración de nginx personalizada si existe
COPY nginx.conf /etc/nginx/conf.d/default.conf 2>/dev/null || echo "No se encontró nginx.conf personalizado, usando configuración por defecto"

# Exponer el puerto 80
EXPOSE 80

# Iniciar nginx
CMD ["nginx", "-g", "daemon off;"]