Weedy - Sistema de Gestion y Ventas de Cannabis Medicinal

Un sistema web desarrollado bajo la arquitectura MVC para vender productos, realizar consultas medicas, gestionar eficientemente el inventario, pedidos, pacientes y personal de un dispensario/clínica. Este proyecto fue construido como parte de la evaluación de la cátedra de Sistemas III, aplicando principios de diseño de bases de datos relacionales y desarrollo de APIs REST.
Realizado por: Miguel Luna, José Mora y José Sanchez.
## 🚀 Características Principales

*   **Dashboard Administrativo:** Panel de control centralizado con métricas clave.
*   **Gestión de Inventario:** Control de stock, ingresos y salidas de productos médicos.
*   **Control de Pedidos:** Seguimiento del estado de las solicitudes.
*   **Módulo de Pacientes:** Registro y control del historial de los pacientes.
*   **Módulo de Empleados:** Administración del personal con control de acceso basado en roles (Administrador, Gestor, Doctor).
*   **Interfaz Responsiva:** Diseño moderno y accesible estructurado con Tailwind CSS.
*   **Interfaz para el cliente**
*   **Interfaz para los doctores**

## 🛠️ Tecnologías Utilizadas

*   **Backend:** PHP, Laravel (Arquitectura MVC)
*   **Frontend:** Blade Templates, HTML5, Tailwind CSS
*   **Base de Datos:** MySQL (Bases de datos relacionales)
*   **Iconografía:** FontAwesome 6

## 📋 Requisitos Previos

Asegúrate de tener instalado en tu entorno local:
*   [PHP](https://www.php.net/) (v8.1 o superior)
*   [Composer](https://getcomposer.org/)
*   [Node.js y npm](https://nodejs.org/) (opcional, para compilar assets)
*   Servidor MySQL (XAMPP, Laragon, o MySQL Server)

## ⚙️ Instalación y Despliegue Local

Sigue estos pasos para levantar el entorno de desarrollo en tu máquina local:

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/TU_USUARIO/weedy.git](https://github.com/TU_USUARIO/weedy.git)
   cd weedy


   ## 📡 Documentación de la API REST

El sistema expone una serie de endpoints estructurados bajo el estándar REST para permitir la futura integración con aplicaciones móviles u otros servicios externos. Todas las respuestas se emiten en formato `JSON`.

### Endpoints Principales (Módulo Empleados)

| Método | Endpoint | Descripción | Parámetros Requeridos |
| :--- | :--- | :--- | :--- |
| **GET** | `/api/empleados` | Obtiene la lista completa de empleados. | Ninguno |
| **POST** | `/api/empleados` | Registra un nuevo empleado en el sistema. | `nombreCompleto`, `cedulaIdentidad`, `correoElectronico`, `rol` |
| **GET** | `/api/empleados/{id}` | Retorna los detalles de un empleado específico. | `id` (en la URL) |
| **PUT** | `/api/empleados/{id}` | Actualiza los datos de un empleado existente. | `id` (URL), datos a actualizar en el body |
| **DELETE**| `/api/empleados/{id}` | Elimina los registros del empleado. | `id` (en la URL) |

> **Nota de Autenticación:** Dependiendo de la configuración de seguridad, algunas de estas rutas pueden requerir un token de acceso enviado en los headers (`Authorization: Bearer <token>`).

---

## 💻 Comandos Útiles (CLI)

Listado de comandos de Artisan utilizados frecuentemente para la gestión, mantenimiento y depuración del proyecto durante su desarrollo:

```bash
# Limpiar toda la caché del sistema (útil cuando las vistas o rutas no se actualizan)
php artisan optimize:clear

# Listar todas las rutas registradas en el sistema (Web y API)
php artisan route:list

# Crear un controlador nuevo con los métodos del CRUD predefinidos
php artisan make:controller NombreController --resource

# Revertir y volver a ejecutar todas las migraciones (¡Cuidado: borra los datos actuales!)
php artisan migrate:fresh

# Ejecutar los seeders para poblar la base de datos con datos de prueba
php artisan db:seed
