

## Name 
Evertec test
## Description

Esta plataforma corresponde a una prueba tecnica soliciptada para optar por e lpuesto de desarrollador backend php 
en la compañia Evertec. Este desarrollo tiene la funcionalidad de optimizar y agregar la integracion de un poral de pagos para lograr hacer compras de forma digital dentro del sitio.


## Technologies
***
Lista de tecnologias usadas en este proyecto:
* Framework Laravel: Version 8.83
* PHP: Version 7.3*
* composer: 2.4.1


## Installation
***
Una breve demostracion de como instalar y ejecutar elproyecto
```
$ se debe tener previamente instalado composer y un servidor local para myssql como por ejeplo xampp
$ git clone https://github.com/alvicas/evertec-test.git
$ cd ../path/to/the/file
$ composer install
$ se debe crear el archivo .env a partir del archivo env.example
$ se debe configurar el acceso a la bd en abiente local 
$ en caso de que no este configurada la key se debe ejecutar el conado "php artisan key:generate"
$ ejecutar los comando "php artisan cache:clear", "php artisan config:clear"
$ejecutar el comando "php artisan serve" para levantar el proyecto y poder aceder de manera local.

```
