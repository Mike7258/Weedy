<div align="center">

# 🌱 Weedy
### Sistema de Gestión y Arquitectura de Datos para Plataformas Digitales

[![Status](https://img.shields.io/badge/Status-En%20Desarrollo-brightgreen.svg)]()
[![MVC Pattern](https://img.shields.io/badge/Architecture-MVC-blue.svg)]()
[![REST API](https://img.shields.io/badge/API-RESTful-orange.svg)]()

*Plataforma digital desarrollada bajo el patrón de arquitectura Modelo-Vista-Controlador (MVC), integrando capas REST API y gestión eficiente de bases de datos relacionales.*

</div>

---

## 👥 Autores y Desarrolladores

Este proyecto ha sido desarrollado con dedicación por el siguiente equipo de ingeniería:

* **Miguel Luna** — *Desarrollo Backend & Arquitectura de Sistemas* ([@Mike7258](https://github.com/Mike7258))
* **José Mora** — *Desarrollo Full-Stack & Base de Datos*
* **José Sánchez** — *Diseño de Interfaces & Lógica de Negocio*

---

## 🚀 Sobre el Proyecto

**Weedy** es una solución digital diseñada para optimizar los procesos operativos y de control de datos a través de una arquitectura web modular. Este repositorio contiene el núcleo técnico, la lógica de negocio, las capas de servicios y la estructura de API REST documentada para su integración escalable.

---

## 🛠️ Tecnologías y Stack Tecnológico

El proyecto está construido utilizando tecnologías estándar de la industria para garantizar rendimiento, mantenibilidad y modularidad:

* **Arquitectura:** Patrón Modelo-Vista-Controlador (MVC).
* **Backend & Lógica:** Capa de servicios orientada a objetos y endpoints REST.
* **Base de Datos:** Arquitectura relacional optimizada con consultas estructuradas.
* **Control de Versiones:** Git & GitHub.

---

## 📂 Estructura del Repositorio

La organización de directorios sigue estrictas buenas prácticas de diseño de software para separar responsabilidades:

```text
Weedy/
│
├── api/            # Capa de controladores y Endpoints REST
├── config/         # Archivos de configuración y conexión a bases de datos
├── models/         # Lógica de datos y mapeo relacional (Modelo)
├── views/          # Interfaces de usuario y vistas del sistema
├── public/         # Recursos estáticos (CSS, JavaScript, imágenes)
└── README.md       # Documentación principal del proyecto
```

---

## ⚙️ Instrucciones de Instalación y Configuración Local

Sigue estos pasos para clonar y poner en marcha el entorno de desarrollo en tu equipo:

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/Mike7258/Weedy.git
   ```

2. **Configurar el entorno de base de datos:**
   * Importa la estructura de base de datos provista en tu gestor SQL local (compatible con MySQL/MariaDB).
   * Configura los parámetros de conexión (servidor, usuario, contraseña y base de datos) dentro del archivo correspondiente en la carpeta `config/`.

3. **Ejecutar el servidor local:**
   * Despliega el directorio del proyecto en tu entorno de pruebas preferido (por ejemplo, Apache mediante XAMPP/WAMP o un servidor interno).
   * Accede a la ruta local configurada en tu navegador web.

---

## 🔑 Credenciales de Acceso Predeterminadas (Admin)

Para facilitar las pruebas iniciales del sistema, puedes iniciar sesión con las siguientes cuentas de administrador precargadas en la base de datos:

| Rol | Usuario / Correo | Contraseña temporal |
| :--- | :--- | :--- |
| **Administrador Principal** | `nuevo_admin@weedy.com` / `admin` | `Admin123*` |


> ⚠️ *Nota de seguridad: Se recomienda encarecidamente cambiar estas credenciales o registrar un nuevo usuario con privilegios una vez desplegado el sistema en un entorno de producción.*

---

## 📌 Documentación de la API

La plataforma expone endpoints bajo el estándar RESTful para la interacción con los módulos de datos:

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| `GET` | `/api/v1/recurso` | Obtiene el listado general de registros |
| `POST` | `/api/v1/recurso` | Inyección y almacenamiento de un nuevo registro |
| `PUT` | `/api/v1/recurso/{id}` | Actualización de datos existentes |
| `DELETE` | `/api/v1/recurso/{id}` | Baja lógica o eliminación de un registro |
├── public/         # Recursos estáticos (CSS, JavaScript, imágenes)
└── README.md       # Documentación principal del proyecto
