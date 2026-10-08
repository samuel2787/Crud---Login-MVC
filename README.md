# CRUD de Productos con Login (Laravel + Vue.js)

Aplicación web sencilla hecha con el patrón MVC. Tiene un sistema de login y un CRUD de productos que solo se puede usar si estás logueado. Si alguien intenta entrar a las URLs protegidas sin iniciar sesión, el servidor no lo deja pasar.

## Qué hace

- Registro de usuarios y login con correo y contraseña
- Las contraseñas se guardan encriptadas con bcrypt (nunca en texto normal)
- CRUD de productos: crear, ver, editar y eliminar
- Las rutas de productos están protegidas: sin sesión no se puede acceder
- Cerrar sesión

## Tecnologías

- **Backend:** Laravel (PHP)
- **Frontend:** Vue.js 3 con Vite
- **Base de datos:** MySQL
- **Peticiones al servidor:** axios
- **Entorno local:** Laragon

## Cómo se aplica el MVC

| Parte | Dónde está | Qué hace |
|-------|-----------|----------|
| Modelo | `app/Models/` | `User.php` y `Product.php`, representan los datos de las tablas |
| Vista | `resources/js/` | Componentes de Vue (`Login.vue`, `Productos.vue`) |
| Controlador | `app/Http/Controllers/` | `AuthController.php` (login) y `ProductController.php` (CRUD) |

Las rutas están en `routes/web.php` y conectan cada URL con su controlador.

## Estructura del proyecto

```
Crud + Login MVC/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   └── ProductController.php
│   └── Models/
│       ├── User.php
│       └── Product.php
├── database/migrations/
├── routes/web.php
└── resources/
    ├── views/app.blade.php
    ├── css/app.css
    └── js/
        ├── app.js
        ├── App.vue
        └── components/
            ├── Login.vue
            └── Productos.vue
```

## Cómo correrlo

Necesitas tener instalado PHP, Composer, Node.js y MySQL. La forma más fácil en Windows es instalar [Laragon](https://laragon.org/), que ya trae PHP, MySQL y Composer.

### 1. Clonar el repositorio

```bash
git clone URL-DE-TU-REPO
cd NOMBRE-DE-LA-CARPETA
```

### 2. Instalar las dependencias

```bash
composer install
npm install
```

### 3. Configurar el .env

Copia el archivo de ejemplo:

```bash
copy .env.example .env
```

(En Mac o Linux es `cp .env.example .env`).

Abre el `.env` y deja la parte de la base de datos así:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_login
DB_USERNAME=root
DB_PASSWORD=
```

Luego genera la clave de la aplicación:

```bash
php artisan key:generate
```

### 4. Crear la base de datos

Con MySQL corriendo, crea una base de datos vacía llamada `crud_login` (en Laragon se puede con HeidiSQL). Después crea las tablas:

```bash
php artisan migrate
```

### 5. Levantar el proyecto

Se necesitan dos terminales abiertas al mismo tiempo.

Terminal 1 (backend):

```bash
php artisan serve
```

Terminal 2 (frontend):

```bash
npm run dev
```

Abre `http://localhost:8000` en el navegador.

### 6. Probarlo

1. Como la base empieza vacía, primero llena nombre, correo y contraseña y dale a **Registrarme**.
2. Luego dale a **Entrar**.
3. Ya puedes crear, editar y eliminar productos.

## Rutas del backend

| Método | Ruta | Descripción | Protegida |
|--------|------|-------------|-----------|
| POST | `/auth/register` | Crear usuario | No |
| POST | `/auth/login` | Iniciar sesión | No |
| POST | `/auth/logout` | Cerrar sesión | No |
| GET | `/auth/me` | Ver si hay sesión activa | No |
| GET | `/api/products` | Listar productos | Sí |
| POST | `/api/products` | Crear producto | Sí |
| PUT | `/api/products/{id}` | Editar producto | Sí |
| DELETE | `/api/products/{id}` | Eliminar producto | Sí |

## Cómo funciona el login

1. El usuario manda su correo y contraseña a `/auth/login`.
2. Laravel busca el usuario y compara la contraseña con la encriptada que está en la base (`Auth::attempt`).
3. Si coincide, Laravel guarda la sesión del usuario.
4. Las rutas protegidas usan el middleware `auth`, que revisa esa sesión en cada petición. Si no hay sesión, responde `Unauthenticated` (o manda a `/login` si es una página).

## Sobre la encriptación

El enunciado menciona md5 como ejemplo, pero md5 es muy débil y ya no se usa para guardar contraseñas. Por eso usamos **bcrypt** con `Hash::make`, que es lo que trae Laravel. Bcrypt le agrega un "salt" a cada contraseña y es lento a propósito, así es más difícil de romper por fuerza bruta.

## Video de demostración

[Ver video](PEGA-AQUI-EL-LINK-DE-LOOM-O-YOUTUBE)

En el video se muestra el funcionamiento del login, que no se puede entrar a la zona protegida sin iniciar sesión y las contraseñas encriptadas en la base de datos.

## Autor

Samuel Chalá, estudiante de Ingeniería en Software en la UDLA.
