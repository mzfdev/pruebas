# Ejercicio

La Unidad de Registro Académico requiere una aplicación web que le permita generar un **reporte de constancia de notas** de cualquier alumno de la universidad.

La constancia de notas puede ser enviada al estudiante a través de correo electrónico y puede ser impresa desde la herramienta.

---

# Requerimientos

Se requiere que se use la combinación adecuada de cualquiera de las siguientes tecnologías:

- Laravel  
- Vue (Preferible) o React  
- Bootstrap o Tailwind (Preferible)  
- PostgreSQL (Preferible) o MariaDB  
- Docker  

---

# Arquitectura

Se debe crear una aplicación **Client-Side Rendered (CSR)** con un **API RESTful**, ambas preparadas para ejecutarse en entornos contenerizados.

---

# Criterios de evaluación 

- Estrategia de solución utilizada  
- Calidad de código  
- Arquitectura  
- Implementación  
- Base de datos  
- Reportes  
- Interfaz y experiencia de usuario  
- Interpretación de requerimientos  
- Documentación  

---

# Preguntas

- ¿Qué es una petición HTTP?

Es una forma de comunicacion que existe entre el servidor y una aplicacion cliente (web, app movil, desktop app, etc.), el objetivo es que el cliente
pueda enviar informacion al servidor o recibirla por parte de este, segun la intencion que tengamos al momento de establecer la comunicacion, tenemos que usar diferentes metodos
por ejemplo GET en caso de querer consultar o POST en caso de querer enviar.

- ¿Qué es API RestFul?

Application programming Interface, es una interfaz que permite el intercambio de informacion entre sistemas, ya sea entre cliente y servidor o incluso entre un servidor y otro,
por ejemplo si queremos integrar un sistema de pagos de terceros a nuestros sistemas, esta conexion se estableceria por medio de API, el sistema de terceros nos provee su API (por medio de 
documentacion por ejemplo) y nosotros consumimos dicha API para utilizar sus servicios de pagos, por supuesto podemos procesar o almacenar la informacion por medio de nuestro servidor, por ejemplo,
podemos guardar internamente la informacion de cada transaccion segun las respuestas que nos devuelve la API de terceros.

- ¿Mencione una herramienta que permita Documento en servicio Rest?

Swagger: permite la documentacion de la API rest mientras se va desarrollando y vive dentro del mismo proyecto, lo cual hace mas facil
de compartir con el resto del equipo para que tambien puedan hacer uso de dicha AI.

- ¿Qué es un Modelo?

Son estructuras que se definen en base a las entidades en la base de datos, el objetivo es ser un paso intermedio entre la logica de negocio y la base de datos, de esta forma no interactuamos
directamente con las entidades de la base de datos, si no con los modelos, lo cual luego se traduce a modificaciones en la base de datos, hay configuraciones que permiten que los modelos dentro de 
nuestro backend se traduzcan automanticamente a entidades en la DB, pero normalmente esta configuracion suele ser desactivada en entornos productivos, para que la db obedezca a un sistema de migraciones y no sea tan susceptible a los cambios dentro de los modelos.

- ¿Qué es un Controller?

Es el encargado de recibir y procesar las peticiones y sus respuestas, en algunos casos se escribe la logica de negocio dentro de ellos, pero lo mas recomendable es el
uso de inyeccion de dependencias y delegar la logica de negocio a los services, de esta forma el controller no sabe como funciona la logica de negocio y simplemente
se limita a recibir una peticion, procesar lo necesario y devolver la respuesta que le provee el service.

- ¿Qué es un componente?

Es codigo con un proposito bien definido, cuyo objetivo es que pueda ser reutilizable, para resolver un problema una sola vez y respetar el principio DRY.

- ¿Qué es una migración?

Es codigo que al ejecutarse se traduce a instrucciones para la base de datos, por ejemplo si se necesita hacer modificaciones a un conjunto de tablas y a la vez crear nuevas, se condifican
estos cambios en una migracion paso a paso y esto permite que para que el resto del equipo tenga estos cambios, solo necesiten ejecutar dicha migracion o migraciones, con esto
evitaremos inconsistencias entre bases de datos, entre entornos de prueba, desarrollo o produccion y entre miembros del equipo.

- ¿Qué es Docker?

Es una tecnologia que permite que las dependencias de un proyecto se respeten independientemente del entorno en el cual estan siendo ejecutados, normalmente se ve como
si los proyectos fueran colocados dentro de depositos junto a todas sus configuraciones y dependencias para evitar problemas de compatibilidad entre entornos y sistemas.

- ¿Mencione algunos patrones de diseño?

- Singleton: cuando necesitamos una sola instancia de algo (por ejemplo una conexion a base de datos o un servicio de traduccion de texto)
- Estrategia: cuando necesitamos diferentes implementaciones para un mismo objetivo (por ejemplo un servicio de pagos que puede realizarse con tarjeta, efectivo, paypal, etc)
- Cadena de responsabilidad: muy usando en middlwares, su objetivo es que ejecutar una resposabilidad despues de otra (por ejemplo: validar existencia de usuario, luego validar que este activo, luego
validar que su tarjeta tenga fondos y asi hasta completar el objetivo)

- Explique que hace el siguiente código y como podría mejorarlo

```
txtUserId = getRequestString("UserId");
txtSQL = "SELECT * FROM Users WHERE UserId = " + txtUserId;
```
En la variable txtUserId se obtiene el identificador que se usara en la consulta SQL de la segunda linea, para obtener toda la informacion
del usuario que corresponde a dicho identificador.

Para mejorarlo, en lugar de colocar la consulta sql "cruda", haria uso de un ORM para evitar colocar codigo SQL en forma de texto 
en medio del codigo, ahora bien, si por A o B motivo fuera necesario mantener la consulta cruda, haria al menos uso de una estrategia posicional 

algo como esto: "txtSQL = "SELECT * FROM Users WHERE UserId = $1";" donde $1 representa la posicion de un parametro que podria contener el txtUserId y de esta forma mitigar un poco 
de riesgo como el de SQL Inyection.

# Notas

El propósito de la prueba no es completar la totalidad de las funcionalidades, sino demostrar la capacidad de seleccionar de manera adecuada una estrategia de desarrollo y una estructura de código que permitan avanzar hacia una solución con estándares de calidad propios del ámbito empresarial.

---

# Instrucciones de Ejecución

## Backend (Laravel)

### Prerrequisitos
- PHP >= 8.0
- Composer
- Base de datos (PostgreSQL)
- Node.js (para assets de Laravel)

### Configuración
1. Copiar el archivo de entorno:
   ```bash
   cp .env.example .env
   ```

2. Configurar la base de datos en el archivo `.env`:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=nombre_base_de_datos
   DB_USERNAME=usuario
   DB_PASSWORD=contraseña
   ```

### Instalación y Ejecución
1. Instalar dependencias de PHP:
   ```bash
   composer install
   ```

2. Generar clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

3. Ejecutar migraciones:
   ```bash
   php artisan migrate
   ```

4. Ejecutar seeders (datos iniciales):
   ```bash
   php artisan db:seed
   ```

5. Iniciar servidor de desarrollo:
   ```bash
   php artisan serve
   ```
   
   El backend se ejecutará por defecto en el puerto `http://localhost:8000`

### Docker (Opcional)
Si prefiere usar Docker:
```bash
docker-compose up -d
```

## Frontend (React)

### Prerrequisitos
- Node.js >= 14
- npm

### Instalación y Ejecución
1. Navegar al directorio del frontend:
   ```bash
   cd FrontEnd
   ```

2. Instalar dependencias:
   ```bash
   npm install
   ```

3. Iniciar servidor de desarrollo:
   ```bash
   npm start
   ```
   
   El frontend se ejecutará por defecto en el puerto `http://localhost:3000`

### Dockerización del Frontend
Para dockerizar el frontend:

1. Construir la imagen de Docker:
   ```bash
   cd FrontEnd
   docker build -t frontend-app .
   ```

2. Ejecutar el contenedor:
   ```bash
   docker run -p 80:80 frontend-app
   ```
   
   El frontend dockerizado se ejecutará en el puerto `http://localhost:80`

### Nota
Asegúrate de que el backend esté corriendo antes de iniciar el frontend, ya que este último consume la API del backend.
