# P1-Restaurante
Nombre del grupo: **Spock.**

Miembros del grupo: **Jorge, Oscar y Julia.**

## Introducción
Este proyecto consiste en la creación de una pagina web que permita la gestión de las mesas en un restaurante.
Las funciones son las siguientes:
+ Ocupar/Desocupar mesas.
+ Historial de cuando se ha ocupado/desocupado una mesa con filtros de búsqueda.
+ Importar registros a un CSV.

## Gestión del proyecto
Este proyecto ha sido dividido en ramas en este mismo repositorio separandolo por funciones, una vez completado el desarrollo de cada función se hace una pull request a una rama de pruebas (como por ejemplo pruebaLogin) donde será testeado su correcto funcionamiento, una vez unido todo el proyecto se hará un merge en Beta para testear que la web funciona correctamente y finalmente será subido a main cuando el pryecto esté acabado.

Para la gestión de tareas se ha utilizado un diagrama de Gantt con la organización de las tareas, su asignación y el tiempo de desarrollo esperados.

https://docs.google.com/spreadsheets/d/1_BqkcSJMw_rBMzYi8YbrEuLfRM-HhyNw/edit?usp=sharing&ouid=118202135200459346775&rtpof=true&sd=true

También se han hecho reuniones diarias en el que se cuenta que cosas se han hecho y cuales están previstas de hacer, todo esto es registrado en el siguiente documento:

https://docs.google.com/spreadsheets/d/1EakzAVKiP3z-eqYxH2QneoxcqhERyfRC/edit?usp=sharing&ouid=118202135200459346775&rtpof=true&sd=true

## Usuarios

Esta pagina web está pensada para que solo los camareros puedan utilizarla, para eso se han creado usuarios para cada camarero, bajo ningún concepto un cliente debe manejar la pagina.
Los usuarios creados son los siguientes:
+ julia@gmail.com
+ jorge@gmail.com
+ oscar@gmail.com

*En todos los usuarios la contraseña es **qwe***

El login de usuarios se hará en la pagina principal (index.php) el cual tiene un formulario con los siguientes campos:

+ Email
+ Contraseña

![imagen](https://github.com/JorgeAlcaldeG/P1-Restaurante/assets/91189374/ae21affc-1337-44ee-9c6f-4623ccb8946b)

Este formulario es validado tanto con js como mediante php, de esta forma nos aseguramos que los datos tienen el formato correcto y que los datos son saneados para ahorranos problemas como por ejemplo la inyección SQL.

Un login incorrecto devolverá a la ventana de inicio y mostrará una alerta de sweetAlert2 notificando el error, en caso de un correcto login se enviará a la pagina principal.

![imagen](https://github.com/JorgeAlcaldeG/P1-Restaurante/assets/91189374/be88e755-c759-40a4-8c75-64fac6467eec)

## Permisos de los usuarios
Todos los usuarios tienen asignado un cargo que les permite tener acceso a solo las partes que son imprescindibles para el trabajador, los cargos y sus permisos son los siguientes:

### Camarero
Puede acceder al panel de mesas pero no puede acceder a la lista de recursos
### Admin
Tiene acceso total a la pagina
### Deshabilitado
El usuario al iniciar sesión devuelve un mensaje de error
### Gerente
Solo puede acceder al panel de recursos y al histórico
### Mantenimiento
Puede ver el panel de gestión de recursos pero solo puede modificar la sección de mesas

## Pagina principal

Desde aquí podremos gestionar el estado de las mesas de nuestro restaurante, veremos un plano con el restaurante y sus mesas, este restaurante está formado por las siguientes salas:


* 3 terrazas
  - Terraza principal
  - Terrraza secundaria
  - Terraza trasera
* 2 comedores
  - Comedor principal
  - Comedor secundario
* 4 salas privadas
  - Sala VIP 1
  - Sala VIP 2
  - Sala de eventos 1
  - Sala de eventos 2
    
![imagen](https://github.com/JorgeAlcaldeG/P1-Restaurante/assets/91189374/42a73f9a-0b09-4e36-ab3e-ef724cc1c988)

Este plano indica la cantidad de mesas que hay en cada sala y cada mesa indica el su estado mediante 2 colores, verde si está disponible y naranja si está ocupado.

![imagen](https://github.com/JorgeAlcaldeG/P1-Restaurante/assets/91189374/0d329298-0de8-40cd-b079-e02c004d811f)

Al hacer click en cualquier mesa cambiará su estado, al hacer esto quedará registrado este cambio, guardandose la información de cuando se ha producido el cambio y que camarero lo ha hecho. A demás si pasamos el ratón por encima de la mesa obtendremos mas información detallaada de la mesa.

![imagen](https://github.com/JorgeAlcaldeG/P1-Restaurante/assets/91189374/90459af4-61c7-4b6d-acdd-e198f878ff3b)

Desde esta pagina tambien podemos cerrar sesión o acceder al registro de las mesas.

## Histórico

En esta pagina se pueden ver los registros que se han mencionado anteriormente con la posibilidad de filtrar por ubicación de cada mesas y de cara a una futura ampliación pasar a ver el estado de cada silla.

![imagen](https://github.com/JorgeAlcaldeG/P1-Restaurante/assets/91189374/071b98bd-23ba-4318-ab03-638cab6f83b9)

En caso de querer guardarse la información se ha añadido un botón de crear CSV el cual guardará en un fichero el resultado que aparece en pantalla, a demás saldrá una alerta avisando de que la descarga se inciará en breves, esta alerta se desactiva automaticamente pasado unos segundos.

![imagen](https://github.com/JorgeAlcaldeG/P1-Restaurante/assets/91189374/6c272ac7-cd81-43be-93fe-1fb9a0a88923)

## Base de datos

Para el correcto funcionamiento de la pagina web se ha diseñado la siguiente base de datos:

![imagen](https://github.com/JorgeAlcaldeG/P1-Restaurante/assets/91189374/d1d358d8-740f-43ec-ad88-7c896fe03934)


La cual cuenta con las siguientes tablas:
+ tbl_salas
  - Contiene el nombre de cada sala.
+ tbl_mesas
  - Contiene el numero de mesa, su estado y en que sala se encuentra.
+ tbl_registros_mesas
  - Contiene registros de los cambios de estados que ha tenido la mesa, quien los ha efectuado y cuando han ocurrido.
+ tbl_camareros
  - Gestiona los usuarios con sus credenciales de inicio de sesión.



+ tbl_sillas
  - Gestiona el estado de la silla y a que mesa pertenecen.
+ tbl_registros_sillas
  - al igual que la tabla de registros de mesas esta tabla guarda el estado de las sillas, quien ha cambiado el estado y a que hora ha ocurrido.

