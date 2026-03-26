# Pet Hero 🐾

**Pet Hero** es una plataforma web desarrollada para la **Universidad Tecnológica Nacional (UTN)**. El sistema facilita la conexión entre dueños de mascotas y cuidadores (Keepers) para servicios de estadía corta remunerada.

## 🛠️ Stack Tecnológico
* **Backend:** PHP (POO).
* **Base de Datos:** MySQL.
* **Frontend:** HTML5, CSS3 y **Tailwind CSS**.
* **Arquitectura:** Diseño en **3 capas lógicas** (Entidades/Controladoras, Vistas y Acceso a Datos).

## 📋 Funcionalidades Principales

### Gestión de Usuarios y Mascotas
* **Perfiles de Usuario:** Registro diferenciado para Owners y Keepers.
* **Mascotas:** Registro de perros y gatos con carga de fotos, raza, tamaño, plan de vacunación y video.

### Lógica de Negocio
* **Disponibilidad:** Los Keepers gestionan sus días disponibles, precios y tamaños de mascotas permitidos.
* **Reservas:** Sistema de solicitudes con fechas específicas y validación de seguridad (un Keeper solo cuida una mascota por estadía).
* **Regla de Convivencia:** Se permite cuidar múltiples mascotas simultáneamente solo si son de la misma raza.
* **Pagos:** Confirmación de reserva mediante cupón de pago del 50% enviado por email.

### Comunicación y Feedback
* **Chat Real-time:** Comunicación directa entre el dueño y el cuidador.
* **Reputación:** Sistema de reviews para calificar el servicio del Keeper una vez finalizada la estadía.

---
*Proyecto académico para la Tecnicatura Superior en Programación (UTN) - 2022.*