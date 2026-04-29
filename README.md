<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).





/*---------------------------------------POSTER FINAL CSS y JS ------------------------*/
Se agrega los cambios de CSS y SCSS para la pantalla de poster final
EMBED se agregan lineas que eliminan los elementos de edicion 
Step 4 -> se modifica el JS para que la imagen se agregue en porcentanjes y no en pixeles
de meten algunas clases en el archivo CSS del embed 

/*---------------------------------------POSTER FINAL CTA Refresh page ----------------*/
SE agrega en embed la fuction de refresh video-Iframe


/*--------------------- CORRECCION ERROR EN AJAX EMBEBED PARA IFRAME ------------------*/
Se ha modificado el VerifyCsrfToken.php para añadir la excepción en la ruta 'ajax-register-interaction'
para evitar la validación de seguridad csrftoken de Laravel


/*--------------------- DROPDOWN LANG ------------------*/
Se introduce el dropdown de las banderas para escoger el idioma en nav_bar.php
Se actualiza y se crean nuevas clases en _base.scss
Se introduce el dropdown de las banderas para escoger el idioma en nav_bar_project.php pero no esta ejecutando el script *****REVISAR***


/*--------------------- DROPDOWN LANG -> LOG IN Y PROJECTS ------------------*/
Se introduce el dropdown de las banderas para escoger el idioma en login y se corrige en projects

/*--------------------- LANG: ADD VIDEO ------------------*/
Se añade la traducción para el blade "add-video"

/*--------------------- LANG: STEP 2 ------------------*/
Se añade la traducción para el blade "step2"

/*--------------------- LANG: STEP 3 ------------------*/
Se añade la traducción para el blade "step3"

/*--------------------- LANG: STEP 4 ------------------*/
Se añade la traducción para el blade "step4"

/*--------------------- LANG: PROFILE ------------------*/
Se añade la traducción para el blade "profile"

/*--------------------- FORM NO INTERACTIONS ------------------*/
Se añade el campo de form pero aun no hay interacciones

/*--------------------- FORM NO INTERACTIONS v2 ------------------*/
Se corrige la parte de que al cargar un cue tipo form abra form

/*--------------------- LANG: ACCOUNT ------------------*/
Se añade la traducción para el blade "account"

/*--------------------- LANG: LIBRARY ------------------*/
Se añade la traducción para el blade "library"

/*--------------------- CRM ------------------*/
Se añade la página de CRM

/*--------------------- LANG: STEP 4 ------------------*/
Fix en el blade "step4"

/*--------------------- FIRST STEP INTERACTING FORM -------------------*/
Se sube la primera parte de forms donde se puede ver los campos e interactuar con ellos desde los paneles y cambiar el form

/*--------------------- SECOND STEP INTERACTING FORM -------------------*/
Se sube la segunda parte de interactions donde al abrir los editores estos se modifican segun los valores que esten el el form
se corrige el css para mobile 


/*------------------------- TEST UPLOAD VIDEO */
test upload video android 

/*----------------------------------------Correciones de step 3 --------------*/
Se le quita el d-none del AF al seleccionar o descargar un type Form


/* ----------------------------- GUARDADO DE INTERACTIONS FORM -------------------------*/
Se agrega la linea (updateTypeForm();) en cada una de las interacciones del paso 3 Form

/*--------------------- LANG: STEP 1 Y LIBRARY ------------------*/
Corrección de errores en traducción

/*--------------------- DASHBOARD ------------------*/
Corrección de errores al filtrar proyecto, que desaparecía una columna de email

/*--------------------- PASSWORD ------------------*/
Se añade traducción al español de los textos relacionados con reestablecer la contraseña


/*--------------------- Ajuste de milisegundo ------------------*/
Se cambia en el paso 2 los milisegundos y se ajusta la BD en la tabla cue para cambiar el tipo de dato
ALTER TABLE `cuepoint` CHANGE `time` `time` DECIMAL(11,4) NOT NULL;

/*--------------------- Email se pasa de login a recuperar clave ------------------*/

/*--------------------- Ajuste de idioma en register ------------------*/

/*--------------------- Puesta en funcionamiento del reseteo de contraseña y traducción  ------------------*/

/*--------------------- Traduccióno del fichero validation.php ------------------*/

/*--------------------- SE corrige visualización del Form ------------------*/
Se trabajo en en css y en java scriot para detectar los cambios realizados y guardar, 

/*--------------------- Se implementa guardado de filtros seleccionados en el dashboard ------------------*/

/*--------------------- Se implementa una demo de envío de email https://app.playfunnel.net/mail/send ------------------*/

/*--------------------- Fix mail controller call at web.php ------------------*/

/*--------------------- Se quita la opción OTROS de las pestañas de la sección de Perfil/Profile ------------------*/

/*--------------------- Se corrige error en la página de registro (Acceso -> Registro) ------------------*/

/*--------------------- Se quita password y se pone contraseña en la versión en español del registro ------------------*/

/*--------------------- Se corrigen traducciones que faltaban de la página de registro ------------------*/

/*--------------------- Se quita el enlace para la página actual en nel menú de la izquierda. Se añade icono para el menú de la izquierda en Dashboard ------------------*/

/*--------------------- Quitar la confirmación por correo a la hora de crear la cuenta, mientras se resuelve el error del mail ------------------*/

/*--------------------- Corregido error al intentar acceder a la url de Dashboard sin estar autenticado ------------------*/

/*--------------------- Cambios en algunos textos de "register" y preparación para el modal de mensajes de alerta ------------------*/

/*--------------------- En "Proyectos" cambiar el texto del botón "Confirmar" que estaba mal ------------------*/

/*--------------------- En "Dashboard" se ha puesto un modal para avisar cuando no existan interacciones registradas ------------------*/

/*--------------------- Se corrige el error de la x en los close de los popups ------------------*/

/*--------------------- En "Dashboard" se corrigen los indicadores (big number) de la derecha que estaban enseñándo mal el valor ------------------*/



=======
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).





/*---------------------------------------POSTER FINAL CSS y JS ------------------------*/
Se agrega los cambios de CSS y SCSS para la pantalla de poster final
EMBED se agregan lineas que eliminan los elementos de edicion 
Step 4 -> se modifica el JS para que la imagen se agregue en porcentanjes y no en pixeles
de meten algunas clases en el archivo CSS del embed 

/*---------------------------------------POSTER FINAL CTA Refresh page ----------------*/
SE agrega en embed la fuction de refresh video-Iframe


/*--------------------- CORRECCION ERROR EN AJAX EMBEBED PARA IFRAME ------------------*/
Se ha modificado el VerifyCsrfToken.php para añadir la excepción en la ruta 'ajax-register-interaction'
para evitar la validación de seguridad csrftoken de Laravel


/*--------------------- DROPDOWN LANG ------------------*/
Se introduce el dropdown de las banderas para escoger el idioma en nav_bar.php
Se actualiza y se crean nuevas clases en _base.scss
Se introduce el dropdown de las banderas para escoger el idioma en nav_bar_project.php pero no esta ejecutando el script *****REVISAR***


/*--------------------- DROPDOWN LANG -> LOG IN Y PROJECTS ------------------*/
Se introduce el dropdown de las banderas para escoger el idioma en login y se corrige en projects

/*--------------------- LANG: ADD VIDEO ------------------*/
Se añade la traducción para el blade "add-video"

/*--------------------- LANG: STEP 2 ------------------*/
Se añade la traducción para el blade "step2"

/*--------------------- LANG: STEP 3 ------------------*/
Se añade la traducción para el blade "step3"

/*--------------------- LANG: STEP 4 ------------------*/
Se añade la traducción para el blade "step4"

/*--------------------- LANG: PROFILE ------------------*/
Se añade la traducción para el blade "profile"

/*--------------------- FORM NO INTERACTIONS ------------------*/
Se añade el campo de form pero aun no hay interacciones

/*--------------------- FORM NO INTERACTIONS v2 ------------------*/
Se corrige la parte de que al cargar un cue tipo form abra form

/*--------------------- LANG: ACCOUNT ------------------*/
Se añade la traducción para el blade "account"

/*--------------------- LANG: LIBRARY ------------------*/
Se añade la traducción para el blade "library"

/*--------------------- CRM ------------------*/
Se añade la página de CRM

/*--------------------- LANG: STEP 4 ------------------*/
Fix en el blade "step4"

/*--------------------- FIRST STEP INTERACTING FORM -------------------*/
Se sube la primera parte de forms donde se puede ver los campos e interactuar con ellos desde los paneles y cambiar el form

/*--------------------- SECOND STEP INTERACTING FORM -------------------*/
Se sube la segunda parte de interactions donde al abrir los editores estos se modifican segun los valores que esten el el form
se corrige el css para mobile 


/*------------------------- TEST UPLOAD VIDEO */
test upload video android 

/*----------------------------------------Correciones de step 3 --------------*/
Se le quita el d-none del AF al seleccionar o descargar un type Form


/* ----------------------------- GUARDADO DE INTERACTIONS FORM -------------------------*/
Se agrega la linea (updateTypeForm();) en cada una de las interacciones del paso 3 Form

/*--------------------- LANG: STEP 1 Y LIBRARY ------------------*/
Corrección de errores en traducción

/*--------------------- DASHBOARD ------------------*/
Corrección de errores al filtrar proyecto, que desaparecía una columna de email

/*--------------------- PASSWORD ------------------*/
Se añade traducción al español de los textos relacionados con reestablecer la contraseña


/*--------------------- Ajuste de milisegundo ------------------*/
Se cambia en el paso 2 los milisegundos y se ajusta la BD en la tabla cue para cambiar el tipo de dato
ALTER TABLE `cuepoint` CHANGE `time` `time` DECIMAL(11,4) NOT NULL;

/*--------------------- Email se pasa de login a recuperar clave ------------------*/

/*--------------------- Ajuste de idioma en register ------------------*/

/*--------------------- Puesta en funcionamiento del reseteo de contraseña y traducción  ------------------*/

/*--------------------- Traduccióno del fichero validation.php ------------------*/

/*--------------------- SE corrige visualización del Form ------------------*/
Se trabajo en en css y en java scriot para detectar los cambios realizados y guardar, 

/*--------------------- Se implementa guardado de filtros seleccionados en el dashboard ------------------*/

/*--------------------- Se implementa una demo de envío de email https://app.playfunnel.net/mail/send ------------------*/

/*--------------------- Fix mail controller call at web.php ------------------*/

/*--------------------- Se quita la opción OTROS de las pestañas de la sección de Perfil/Profile ------------------*/

/*--------------------- Se corrige error en la página de registro (Acceso -> Registro) ------------------*/

/*--------------------- Se quita password y se pone contraseña en la versión en español del registro ------------------*/

/*--------------------- Se corrigen traducciones que faltaban de la página de registro ------------------*/

/*--------------------- Se quita el enlace para la página actual en nel menú de la izquierda. Se añade icono para el menú de la izquierda en Dashboard ------------------*/

/*--------------------- Quitar la confirmación por correo a la hora de crear la cuenta, mientras se resuelve el error del mail ------------------*/

/*--------------------- Corregido error al intentar acceder a la url de Dashboard sin estar autenticado ------------------*/

/*--------------------- Cambios en algunos textos de "register" y preparación para el modal de mensajes de alerta ------------------*/

/*--------------------- En "Proyectos" cambiar el texto del botón "Confirmar" que estaba mal ------------------*/

/*--------------------- En "Dashboard" se ha puesto un modal para avisar cuando no existan interacciones registradas ------------------*/

/*--------------------- Se corrige el error de la x en los close de los popups ------------------*/

/*--------------------- En "Dashboard" se corrigen los indicadores (big number) de la derecha que estaban enseñándo mal el valor ------------------*/



>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
