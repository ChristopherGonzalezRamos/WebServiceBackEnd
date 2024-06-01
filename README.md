# INSTALACIÓN DE WEB SERVICE DEL BACKEND

Este documento proporciona instrucciones detalladas para descargar e instalar XAMPP en el equipo de cómputo, además de como crear una base de datos con sus tablas para utilizarlos en el proyecto en un archivo sql y los PHPs necesarios para el manejo de los datos en React Expo.


Antes de continuar, se tendrá que descargar este repositorio para introducir los archivos que vienen dentro del 

* Así que primero debemos de ubicarnos en el repositorio, hay un botón de color verde que dice "<> Code", le damos click derecho, en el apartado de "Local" seleccionamos "Download ZIP" y nos descargará el repositorio.
* Una vez descargado, le damos click derecho y "Extraer archivos" y nos aparecerá la carpeta llamada "WebServiceBackEnd" en donde adentro viene otra carpeta de agenda y este archivo README.md.

Ahora si, empezamos con nuestra instalación de Web Service.

## DESCARGAR XAMPP

* Primero nos dirigiremos al sitio oficial de XAMPP (link abajo) en el cuál nos aparece la página principal.
* Luego le damos click al botón de "XAMPP PARA WINDOWS" el cual nos llevara a esta url "https://www.apachefriends.org/es/download_success.html" y aparecerá una ventana en donde se descargará el XAMPP para instalarlo.
* Seleccionamos en donde la vamos a descargar e iniciará el proceso, esperamos unos segundos y ya estará listo.

## INSTALAR XAMPP

* Nos dirijimos a donde hemos descargado XAMPP, ejecutamos el archivo de instalación dandole doble click, nos aparecerá una ventana de permisos de administrador, le damos que si.
* Primero nos aparecerá una ventana de Warning con respecto a una funciones que el XAMPP tiene restringido en el sistema si lo instalamos, le damos click en "Aceptar".
* Nos aparece una ventana de bienvenida al instalador de XAMPP, le damos en "Next>".
* Luego selccionamos los componentes que vamos a instalar los cuales son MYSQL y phpMyAdmin, para el manejo de bases de datos en la aplicación, le damos en "Next>".
* Después seleccionamos en donde vamos a instalar la carpeta de nuestro XAMPP y si le queremos cambiar el nombre, una vez ubicado el lugar y el nombre, le damos en "Next>".
* En el idioma, le dejamos en Inglés y le damos en "Next>".
* Por último nos menciona que esta listo para instalar XAMPP en el equipo, le damos a "Next>" e iniciará la instalación, esperamos unos minutos.
* Una vez instalado, nos aparecerá una ventana en donde tendremos marcado nuestro una casilla para abrir nuestro XAMPP Control, en este caso no lo dejaremos marcado y le daremos en "Finish".

## EJECUTAR XAMPP (ADMINISTRADOR)
  
* Una vez completada la instalación, nos dirigiremos a la carpeta donde hemos instalado XAMPP.
* Una vez dentro de la carpeta, seleccionamos la aplicación "xampp-control", le damos click derecho y seleccionamos propiedades.
* Nos mostrará una ventana en el apartado "General", pero nosotros nos iremos en "Compatibilidad" y marcamos la casilla de "Ejecutar este programa como administrador", le damos en el botón de "Aplicar" y en "Aceptar".

Se hace esto pasa solucionar la advertencia que nos marca al inicio de la instalación y no nos de problemas más adelante.

* Una vez hecho eso, le damos click derecho, seleccionamos "Enviar a" y creamos un acceso directo al escritorio.
* Finalmente, le damos dobles click a nuestro acceso directo del xampp en el escritorio, nos aparecerá los permisos de administrador, le damos que si e iniciará el programa.

## CONFIGURACIÓN DE XAMPP

Para comprobar que todo esta funcionando, le damos click a "Start" en Apache y MSYQL, una vez que estén en color verde ambos y se muestren sus puertos, le damos click en "ADMIN" en ambos y nos desplegarán pestañas del navegador, uno para el Apache (http://localhost/dashboard/) y otro para el MYSQL (http://localhost/phpmyadmin/).
 
Ahora, debemos de hacerle modificaciones en algunas carpetas para poder utilizar nuestro dispositivo móvil y que pueda conectarse con el "locahost" de nuestro servidor correctamente, ya que al momento de probarlo, posiblemente no nos ejecute la aplicación. Para estas modificaciones, me apoye de un video en YouTube (link abajo) ya que no me dejaba entrar a la base de datos y realizar los métodos GET y POST de mi proyecto en mi dispositivo móvil.

Este apartado es opcional, yo lo realice por mi situación de que no tenía acceso a mi base de datos y a mis tablas. Igual lo puede aplicar si desea por si presenta la misma situación o por curiosidad.

* En nuestro XAMPP, en la fila de Apache, le damos click al botón de "Config" y seleccionamos "Apache (httpd.config)".
* Se nos abrirá un bloc de notas, vamos a presionar Ctrl + B y se nos mostrará un ventana de busqueda, ingresamos la palabra "listen" y damos click en "Buscar siguiente".
* Nos mostrará un apartado como este:

# Listen: Allows you to bind Apache to specific IP addresses and/or
# ports, instead of the default. See also the <VirtualHost>
# directive.
#
# Change this to Listen on specific IP addresses as shown below to 
# prevent Apache from glomming onto all bound IP addresses.
#
#Listen 12.34.56.78:80
Listen 80

* Vamos a cambiar la penúltima línea por lo siguiente: #Listen 0.0.0.0:80, con esta configuración, abarcará más señales de red de las que antes se estaba limitando y no debemos que quitar el simbolo de #, ya que nos marcará error al momento de correr Apache en relación al puerto. Le damos Ctrl + G para guardar el cambio que hicimos.

* De nuevo presionamos Ctrl + B, ingresamos ahora la palabra "servername" y damos click en "Buscar siguiente".
* Nos mostrará lo siguiente:


#
# ServerName gives the name and port that the server uses to identify itself.
# This can often be determined automatically, but we recommend you specify
# it explicitly to prevent problems during startup.
#
# If your host doesn't have a registered DNS name, enter its IP address here.
#
ServerName localhost:80

Para este paso, si lo desea, puede cambiar el nombre del servidor localhost por la ip de su dirección IPv4 de su equipo, esto para comprobar más adelante en el navegador del dispositivo móvil el locahost del XAMPP pero utilizando una dirección ip. Ya que localhost como tal no lo detecta en el móvil, así que empleamos una dirección ip para que lo podamos llamar, esto no afecta en el XAMPP en el navegador de nuestra computador al acceder a Apache o MYSQL.

* En caso de que lo quiera cambiar, le ingresamos la ip de nuestro equipo, para mi caso ingrese: ServerName 192.168.0.15:80, lo guardamos con CTRL + G y cerramos el bloc de notas


* Ahora volvemos a presionar el botón de "Config" del Apache y seleccionamos "Apache (httpd-xampp.config) "
* Dentro del bloc de notas, presionamos Ctrl + B, ingresamos la palabra "phpmyadmin" y damos click en "Buscar siguiente".
* Nos mostrará lo siguiente:


 Alias /phpmyadmin "C:/XAMPP2/phpMyAdmin/"
    <Directory "C:/XAMPP2/phpMyAdmin">
        AllowOverride AuthConfig
        Require local
        ErrorDocument 403 /error/XAMPP_FORBIDDEN.html.var
    </Directory>


* Cambiaremos el "Require local" por "Require all granted", este último permite el acceso a todos los usuarios sin limitaciones o que soliciten el recurso phpMyAdmin podrán acceder a este.
* Guardamos los cambios con Ctrl + G y cerramos el bloc de notas.

* Vamos a reiniciar el XAMPP, asi que vamos a cerrar la aplicación, pero se seguirá ejecutando en segundo plano.
* Así que nos dirijimos al Aministrador de tareas pulsando las teclas Ctrl + Shift + ESC.
* En el apartado de "Procesos" buscamos "xampp-control", le damos click derecho, seleccionamos "Finalizar tarea" y cerramos el Adminitrador de tareas.


* Volvemos a abrir nuestro XAMPP y vamos a darle "Start" en Apache y MYSQL.
* Ahora vamos a ir a nuestra barra de busqueda (ubicado en la barra de tareas) y vamos a buscar "Panel de Control", una vez encontrado le damos click y se nos abrirá.
* Seleccionamos la categoría de "Sistema y Seguridad", seleccionamos "Windows Defender FireWall" y seleccionamos la opción de "Permitir a las aplicaciones comunicarse a través de Firewall de Windows Defender".
* Una vez dentro, seleccionamos el botón de "Cambiar configuración", buscamos el "Apache HTTP Server", vamos a marcar ambas casillas (privada y pública) y le damos en "Aceptar".

Esto lo hacemos para que no se nos presente ningún incoveniente con las redes de Wifi en las que nos podamos conectar y podamos trabajar con la aplicación.

Ahora para comprobar que tenemos acceso al localhost desde nuestro dispositivo móvil:

* Vamos a acceder al navegador de nuestro celular.
* Escribimos nuestra "ip" o tmbn nuestra "ip/dashboard" y se nos mostrará el Admin de Apache, de igual forma con "ip/phpmyadmin/" podemos acceder a la base de datos.

## CREACIÓN DE BASE DE DATOS Y TABLAS EN MYSQL

* Una vez configurado todo el XAMPP, le damos click a "Admin" del MYSQL y nos manda al phpMyAdmin.
* Seleccionamos la opción de SQL y nos muestra un cuadro de texto en donde debemos de introducir el código del archivo "database.sql" que viene en la carpeta "agenda" que extraimos anteriormente y colocamos el contenido en ese espacio, se puede abrir el archivo con Visual Studio Code para que se muestre el código para copiar el código y pegarlo en el espacio de SQL de phpMyAdmin.
* Le damos click en "Continuar" y si todo funciona perfectamente, nos deberá de aparecer la base de datos "agenda" con tres tablas: "auth", "notas" y "users".

## PASAR LA CARPETA DE AGENDA AL XAMPP

También vamos a pasar nuestra carpeta "agenda" en donde contiene todos los PHPs que vamos a utilizar para nuestra aplicación para la conexión con los datos de nuestras tablas.

* Le damos click derecho a la carpeta y selaccionamos copiar.
* Nos drigimos a esta ruta en donde instalamos XAMPP : "C:\XAMPP\htdocs". Esto dependerá de donde se ha instalado el software XAMPP.
* Una vez adentro, le damos click derecho y Pegar.

De esta manera, hemos pasado nuestros PHPs a nuestro XAMPP para que podamos utilizar nuestra aplicación con nuestro WEB SERVICE. Se debe de tener iniciado el Apache y el MYSQL durante la ejecución de la aplicación para que pueda funcionar. 

### PÁGINA OFICIAL DE XAMPP PARA LA DERCARGA DEL SOFTWARE
#### https://www.apachefriends.org/es/index.html

### VIDEOS PARA ACCEDER A LOCALHOST DESDE OTROS DISPOSITIVOS POR MEDIO DE DIRECCIÓN IP
#### https://www.youtube.com/watch?v=aZDAd3nT4jQ -> How To Access XAMPP Localhost From Mobile / Burka Tech
