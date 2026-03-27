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

## 📸 Galería del Sistema

1. **Login:** Inicio de sesión que valida el nombre de usuario y contraseña en la base de datos.
![Login](/PetHero/blob/main/docs/login.webp)

2. **Pantalla de Inicio:** Landing page al ingresar como usuario registrado.
![Inicio](/PetHero/blob/main/docs/inicio.webp)

3. **Registro de Keeper:** Activación de perfil como cuidador, definiendo paga diaria, tamaño de animal aceptado y descripción.
![Registro Keeper](/PetHero/blob/main/docs/registro-keeper.webp)

4. **Historial de Reservas (Booking History):** Panel para ver el estado de las reservas (en espera, aceptadas, rechazadas, etc).
![Historial Reservas](/PetHero/blob/main/docs/booking-history.webp)

5. **Disponibilidad del Keeper:** Calendario para configurar los días en los que el Keeper va a trabajar.
![Disponibilidad Keeper](/PetHero/blob/main/docs/disponibilidad-keeper.webp)

6. **Lista de Mascotas:** Sección de un usuario Dueño (Owner) para ver a sus mascotas activas.
![Mascotas de Usuario](/PetHero/blob/main/docs/agregar-animal.webp)

7. **Registro de Mascota:** Formulario para agregar un animal indicando nombre, tamaño, raza y observaciones.
![Registro Mascota](/PetHero/blob/main/docs/registro-animal.webp)

8. **Detalle de Mascota:** Vista en detalle de los datos y documentos (foto, vacunación) de un animal registrado.
![Detalle Mascota](/PetHero/blob/main/docs/detalle-animal.webp)

9. **Detalle de la Reserva:** Vista resumen de una solicitud de cuidado mostrando información sobre el Keeper, la mascota, las fechas y el precio total.
![Detalle Reserva](/PetHero/blob/main/docs/detalle-reserva.webp)

10. **Keepers Disponibles:** Listado de búsqueda que muestra a todos los cuidadores disponibles para unas fechas y tipo de mascota determinados por el usuario.
![Keepers Disponibles](/PetHero/blob/main/docs/keepers-disponibles.webp)

---
*Proyecto académico para la Tecnicatura Superior en Programación (UTN) - 2022.*
