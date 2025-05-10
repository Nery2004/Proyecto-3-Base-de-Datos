# 📚 Proyecto 3 - Gestión de Biblioteca

Este proyecto es una aplicación web para la gestión de una biblioteca, desarrollada como parte del curso de Bases de Datos. Utiliza Laravel como framework backend y PostgreSQL como sistema de gestión de bases de datos.

## 🚀 Tecnologías utilizadas

* [Laravel](https://laravel.com/)
* [PostgreSQL](https://www.postgresql.org/)
* [Docker](https://www.docker.com/) (opcional)
* [Bootstrap](https://getbootstrap.com/)
* [Vite](https://vitejs.dev/)

## 📁 Estructura del proyecto

El proyecto sigue la estructura estándar de Laravel, con carpetas como:

* `app/`: Contiene la lógica de la aplicación.
* `database/`: Incluye las migraciones y seeds.
* `resources/`: Archivos de vistas y assets.
* `routes/`: Definición de rutas web y API.
* `public/`: Archivos públicos accesibles desde el navegador.

## ⚙️ Requisitos

* PHP >= 8.1
* Composer
* Node.js y npm
* PostgreSQL
* Opcional: Docker y Docker Compose

---

## 🛠️ Instrucciones para ejecutar el proyecto

1. **Clona el repositorio:**

   ```bash
   git clone https://github.com/Nery2004/Proyecto-3-Base-de-Datos.git
   cd Proyecto-3-Base-de-Datos
   ```

2. **Conéctate a tu base de datos PostgreSQL** (puedes usar `psql`, PgAdmin u otra herramienta).

3. **Ejecuta el archivo de DDL para crear las tablas:**

   ```sql
   \i path/al/archivo/ddl.sql
   ```

4. **Ejecuta el archivo de triggers:**

   ```sql
   \i path/al/archivo/triggers.sql
   ```

5. **Ejecuta el archivo de inserción de datos (data.sql):**

   ```sql
   \i path/al/archivo/data.sql
   ```

> 🔁 Asegúrate de reemplazar `path/al/archivo/` con la ruta correcta donde están ubicados los archivos `.sql` dentro del repositorio.

## 🛠️ Instalación y ejecución

### Opción 1: Instalación manual

1. Clona el repositorio:

   ```bash
   git clone https://github.com/Nery2004/Proyecto-3-Base-de-Datos.git
   cd Proyecto-3-Base-de-Datos
   ```



2. Copia el archivo de entorno y configura las variables:

   ```bash
   cp .env.example .env
   ```


Edita el archivo `.env` para configurar la conexión a la base de datos PostgreSQL.

3. Instala las dependencias de PHP y JavaScript:

   ```bash
   composer install
   npm install
   ```



4. Genera la clave de la aplicación:

   ```bash
   php artisan key:generate
   ```



5. Ejecuta las migraciones y, si es necesario, los seeders:

   ```bash
   php artisan migrate --seed
   ```



6. Compila los assets con Vite:

   ```bash
   npm run dev
   ```



7. Inicia el servidor de desarrollo:

   ```bash
   php artisan serve
   ```



### Opción 2: Usando Docker

1. Copia el archivo de entorno y configura las variables:

   ```bash
   cp .env.example .env
   ```


Asegúrate de que las variables de entorno estén correctamente configuradas.

2. Construye y levanta los contenedores:

   ```bash
   docker-compose up --build
   ```



3. Accede a la aplicación en [http://localhost:8000](http://localhost:8000).

## 🧪 Pruebas

Para ejecutar las pruebas, utiliza el siguiente comando:

```bash
php artisan test
```



## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más información.

## 👤 Autor

Desarrollado por [Nery2004](https://github.com/Nery2004), [Albu231311](https://github.com/Albu231311) ,[Dernait](https://github.com/Dernait).