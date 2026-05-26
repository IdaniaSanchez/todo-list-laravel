# To-Do List Pro

Aplicación web para la gestión de tareas diarias desarrollada con Laravel, Livewire y Tailwind CSS. El proyecto implementa una arquitectura reactiva que permite actualizar la interfaz de usuario en tiempo real sin necesidad de recargar la página.

<p align="center">
  <video src="https://github.com/user-attachments/assets/bc6b450f-9e4d-4552-9cd0-8734ad38f77f" width="100%" style="max-width: 800px;" controls></video>
</p>

## Características

* **Gestión reactiva:** Creación, actualización de estado (completado/pendiente) y eliminación de tareas de forma asíncrona mediante componentes de Livewire.
* **Categorización personalizada:** Sistema de gestión de categorías con asignación de colores para la organización visual de las tareas.
* **Filtros y búsqueda integrada:** Motor de búsqueda en tiempo real que permite filtrar el listado por el estado de las actividades (Todas, Pendientes, Completadas).
* **Control de prioridades:** Clasificación de tareas por niveles de urgencia (Baja, Media, Alta) y control de fechas de vencimiento con alertas para tareas retrasadas.
* **Indicador de progreso:** Barra de porcentaje dinámica que calcula el nivel de cumplimiento actual del listado.

## Tecnologías utilizadas

* **Backend:** Laravel / PHP
* **Frontend:** Livewire 3 / Tailwind CSS
* **Base de datos:** MySQL / PostgreSQL (compatible con Eloquent ORM)

## Instalación y configuración local

Para clonar y ejecutar este proyecto en un entorno de desarrollo local, siga estos pasos:

1. Clonar el repositorio:
   ```bash
   git clone [https://github.com/IdaniaSanchez/todo-list-laravel.git](https://github.com/IdaniaSanchez/todo-list-laravel.git)

```

2. Instalar las dependencias de PHP:
```bash
composer install

```


3. Instalar y compilar los recursos de frontend:
```bash
npm install && npm run build

```


4. Configurar el entorno local:
* Copiar el archivo de ejemplo: `cp .env.example .env`
* Generar la clave de la aplicación:
```bash
php artisan key:generate

```




5. Configurar las credenciales de la base de datos en el archivo `.env` y ejecutar las migraciones:
```bash
php artisan migrate

```


6. Iniciar el servidor de desarrollo:
```bash
php artisan serve

```
