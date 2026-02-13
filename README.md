# BATConectadosHonduras Back-end

Stack utilizado:
- Laravel 9 (PHP 8.1+)
- Vue.js 2.6
- MySQL
- JWT – Autenticación con Bearer Token
- Docker

## 📌 Descripción del Proyecto

Se desarrolló una API RESTful para la gestión de publicaciones (Posts),
relacionadas con usuarios y categorías.

El sistema permite:

- Registro y login de usuarios
- Autenticación con token
- CRUD de publicaciones
- Filtros por usuario y categoría
- Paginación
- Validaciones backend
- Autorización (solo autor o admin puede editar/eliminar)

---

## Arquitectura

### Backend

Arquitectura basada en el patrón MVC:

- Models → Relaciones Eloquent
- Controllers → Lógica de negocio
- Requests → Validaciones
- Resources → Serialización de respuestas
- Middleware → Autenticación y autorización

Se utilizó Eager Loading para evitar N+1 queries.

---

## Instalación con Docker

El proyecto incluye configuración para ejecutarse en contenedores Docker.

-Docker
-Docker Compose

Verificación de instalación:

    docker --version
    docker compose version

### 1. Levantar el proyecto con Docker

Clonar el repositorio

    git clone <repo>
    cd backend

### 2. Copiar variables de entorno

    cp .env.example .env

Modificar las variables de base de datos en .env

### 3. Construir y levantar los contenedores

    docker compose up -d --build

### 4. Ejecutar los comandos dentro del contenedor

Entrar al contenedor

    docker compose exec app bash

Ejecutar dentro del contenedor

    composer install
    php artisan key:generate
    php artisan migrate
    php artisan jwt:secret

### 5. Levantar servidor

  php artisan serve

## Instalación Backend SIN Docker

### 1. Clonar repositorio

  git clone <repo>
  cd backend


### 2. Instalar dependencias

  composer install

### 3. Configurar variables de entorno

  cp .env.example .env

Configurar credenciales de base de datos en `.env`

### 4. Generar key

  php artisan key:generate

### 5. Ejecutar migraciones

  php artisan migrate

### 6. Instalar JWT

Instalar paquete:

  composer require tymon/jwt-auth

Publicar configuración:

  php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

Generar clave secreta JWT:

  php artisan jwt:secret

### 7. Levantar servidor

  php artisan serve

## 👤 Autor

**Santiago Joya**
---
