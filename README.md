# Prueba técnica para isEazy

## Requisitos y objetivo de la prueba

Se entiende que la prueba pretende verificar los conocimientos del propio
framework como manejo de Eloquent, comandos de artisan y herramientas
internas.

## Suposiciones

En un principio se valoró desarrollar la aplicación bajo arquitectura hexagonal
con un dominio definido, esto aportará mayor mantenibilidad y ofrecerá un
desacople del framework sin perder la ayuda que este brinda con sus librerías.

Se iniciará el desarrollo usando eloquent y los controladores de Laravel con el 
acoplamiento que esto aporta, se realizarán los test de feature para tener cubierta
la api mediante aceptación. 

Una vez tengamos una cobertura minima correcta y el proyecto tenga los casos de 
uso correctos aislaremos lógica como servicios para su posible reutilización como
por ejemplo en commandos o como sea necesario

Si es posible y el tiempo nos lo permite podríamos realizar un refactor con una
cobertura de test apropiada hacia una arquitectura hexagonal, esto último se evaluará
una vez terminadas las features solicitadas.

Dado el tamaño del proyecto y su lógica no ve aplicable el uso de observers ni de ni 
eventos, pero se evaluarán posibles usos. 

## Puesta en marcha

Para la puesta en marcha del proyecto en desarrollo podemos usar sail, como no 
tenemos experiencia con esta herramienta usaremos docker-compose para despliegue
con docker.

## Testing

Utilizar el comando make para el uso de las diferentes acciones

Lazar test con detalle sobre cobertura:
```shell
make tests
```

## Base de datos

Dado el modelo de los requisitos, vamos a crear una realización de muchos a 
muchos con una tabla intermedia donde almacenaremos el stock de los productos

Crearemos los modelos junto a sus migraciones de este modo:
```shell
make artisan ARGS="make:model Shop -m" 
make artisan ARGS="make:model Product -m" 
make artisan ARGS="make:model Stock -m" 
```

## Servidor web

Mediante makefile podemos lanzar el servidor nginx local para realizar pruebas
manuales e interactuar con la api
```shell
make run
```

Nota: Esta prueba ha sido realizada con una máquina apple silicon por lo que 
la imagen de mysql es exclusiva para arm64v8, cambiar la imagen para arquitectura
x86 en docker-composer.yml

Abrir el terminar y escribir `http://localhost/api/shops`

## Lógica de dominio en capa de servicio

Se ha dividido la lógica de la aplicación en:

 - HTTP: Controlador
 - Lógica de dominio: Servicios 

Nota: La parte de DB sigue acoplada a eloquent, no debería ser un problema pero se
podría encapsular en repositorios, se descarta debido a o extenso que se está 
haciendo la prueba

## Cobertura de test

Se ha mejorado la cubertura en un 98%
