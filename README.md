# Sistema de Gestión para Clínica Veterinaria

## Descripción

Aplicación web desarrollada para la gestión integral de una clínica veterinaria.
Permite administrar pacientes, turnos y usuarios con diferentes roles.

El sistema está diseñado para optimizar la organización interna y mejorar la atención al cliente.
## Funcionalidades
- Autenticación de usuarios
- Gestión de roles (Administrador, Veterinario, Cliente)
- Gestión de turnos
- Registro y gestión de pacientes y propietarios (relación muchos a muchos entre dueños y mascotas)
- Gestión de historiales clínicos (enfermedades, recetas, vacunas)
- Operaciones CRUD completas
- Estadistica

## Tecnologías utilizadas
- Backend: Laravel (PHP)
- Base de datos: MySQL
- Frontend: Blade / HTML / CSS
- Arquitectura: MVC
  
 ## Instalación y ejecución
 1. Clonar el repositorio: https://github.com/TatianaNoskova/Veterinaria.git
 2. Instalar dependencias:composer install
 3. Configurar variables de entorno (.env)
 4. Ejecutar migraciones: php artisan migrate
 5. Iniciar servidor: php artisan serve

## Objetivo del proyecto

Este proyecto fue desarrollado como parte de la formación en Análisis de Sistemas, con foco en el desarrollo de aplicaciones web reales y funcionales.

## Autor:
Tatiana Noskova
