Conjunto de declaraciones acerca de seguridad informatica
Desde el punto de vista de la ingenieria de software se puede garantizar seguridad si:
1. Se comprende la importancia del ciclo de vida del software como herramienta para la seguridad de las aplicaciones y el software.
2. Que desde el punto de vista agil, el manifiesto agil es una declaracion de valores y principios que no solo aportan calidad en los procesos de software, sino que tambien aportan seguridad al entender que la calidad está determinada por la seguridad.
3. Que la seguridad en el software es un atributo de calidad

Considerando esto planteamos que:
1.  Crearemos hash para colaborar con algoritmos de encriptacion tanto en passwords como en validacion de formularios (validando metodo de envio: POST, GET, PUT y DELETE)
2. Validaremos el tiempo de conexion inactiva de los usuarios (10 segundos preterminados).
3. Crearemos un repositorio local y global para controlar las versiones del software y evitar el uso malicioso de archivos de configuracion. Para ello, utilizaremos gitignore e incluiremos los archivos que tienen información sensible:
	3.1 git init crea repositorio local (antes hay que eliminar la carpeta .git de axiomaframe para crear uno nuevo)
	3.2 git status para verificar los archivos nuevos o modificados
	3.3 git add . sube al stage los archivos modificados o creados
	3.4 git commit -m "" confirma los cambios realizados en el repositorio local
	3.5 Crear repositorio nuevo en github.com
	3.6 Realizar los comandos sugeridos exceptuando los que se realizaron desde el punto 3.1 al 3.4
	3.7 Con ello tendremos una copia exacta de nuestro repositorio local en la nube (origin)
	3.8 Creamos modelo de datos para garantizar escalabilidad y mantenibilidad del software
	3.9 Actualizamos las dependencias del software a traves de composer
4. Acciones de desarrollo seguro:
	4.1 Creamos las tablas
	4.2 Creamos los modelos (logica de datos)
	4.3 Creamos controladores (logica de negocio)
	4.4 Creamos las vistas (consumo de usuarios)
	4.5 Definimos a MVC como arquitectura de software
5. Funcion de seguridad del controlador padre:
	5.1
6. La aplicación posee dos clases para sanitizar las urls de las peticiones de recursos. Estas son Bootstrap y Request
