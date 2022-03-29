# Desarrollo de una API REST con Laravel

Una API es una
`
Interfaz de Programacion de Aplicaciones. Es un conjunto de subrutinas, funciones, metodos, y subprocedimientos que ofrece cierta biblioteca para ser utilizada por otro software
`
O bien Es un nucleo como una pieza de un rompecabezas que permite la conexion de otros sistemas como una app mobil o una app web estos subsistemas consumen o envian datos al `API` que si bien esta api puede realizar acciones de conexion a una base de datos por ejemplo.

---
## Conceptos

###  Factory en laravel
Los Model Factories nos permiten crear registros de prueba, ya sea para cargar nuestra base de datos con «información falsa» o «información de prueba» o para crear las condiciones necesarias para ejecutar pruebas automatizadas.

---
#### Como conecto una `API` con mi app?

Si bien para la conexion entre el sistema de la API y un subsistema como app web tenemos un `Vinculo` que bien puede ser visto como el siguiente ejemplo

```url
http://laravel-api.test/api/v2/posts
```
Este `Enlace` hace un listado de `posts` existentes dentro de la API mas sin en cambio en el siguiente `Enlace` vemos que tenemos un `/1`

```url
http://laravel-api.test/api/v2/posts/1
```
Lo que hara la `api` sera devolvernos los detalles de la publicacion numero `1` que si bien puede ser un numero o algun otro identificador alfanumerico, esto puede variar dependiendo del sistema.

## Construccion de un nuevo proyecto con Laravel
Dentro del terminal 
```bash
$ composer create-project laravel/laravel API
```


Completada la instalacion haremos una configuracion inicial.
Las banderas o parametros `cmf`
- c --> Controller
- m --> Migration
- f --> Factory
```bash
php artisan make:model Post -cmf
```
La configuracion inicial de la migracion sera en la ultima migracion creada
para ello modificaremos el archivo encontrado en `APP\database\migrations`

### Configuracion de PostFactory
Dentro del fichero factories dentro de la carpeta `database` encontraremos esta carpeta y particularmente editaremos el fichero Post agregando el siguiente codigo 

```php
  'user_id' => rand(1,999),
  'title' => $this.faker->sentence,
  'slug' => $this.faker->slug,
  'content' => $this.faker->text(1600)
```
En donde estamos definiendo la informacion que se generara aleatoriamente para generar esta informacion dentro de la base de datos.

### Configuracion de Seeders
Dentro de la carpeta `App\database\seeders` encontraremos un fichero dentro del cual agregaremos la siguiente config

```php
  \App\Models\User::factory(10)->create();
  \App\Models\Post::factory(120)->create();
```
### Configuracion de BD (MySql)
Crearemos una base de datos en nuestro `SGBD` tomando en cuenta que el nombre de la BD sera `api`

No olvidemos de agregar nuestras credenciales al `.env`

Completado los pasos anteriores ejecutaremos una migracion y adicionalmente pasaremos como parametro que se ejecuten los seeders

```bash
php artisan migrate --seed
```
Y debemos tener una salida similar 
```bash
└─$ php artisan migrate --seed  
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table (13.11ms)
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table (11.36ms)
Migrating: 2019_08_19_000000_create_failed_jobs_table
Migrated:  2019_08_19_000000_create_failed_jobs_table (13.40ms)
Migrating: 2019_12_14_000001_create_personal_access_tokens_table
Migrated:  2019_12_14_000001_create_personal_access_tokens_table (18.88ms)
Migrating: 2022_03_28_012905_create_posts_table
Migrated:  2022_03_28_012905_create_posts_table (27.97ms)
Database seeding completed successfully.
                                         
```
### Versionado --> Ver1.0

- Configuracion para retornar un recurso como un registro ejemplo un Post
- Recurso (Post)
- Coleccion de datos (Muchos datos)

`Una coleccion de datos son muchos recursos` y `un recurso es una peticion post`

Comenzando con este punto tenemos que crear un controller asociado a la version 1 y que este este dentro de un directorio el cual estara dentro de `App\Http\Controllers\Api\V1` y en esa ruta de directorio crearemos un controllador que se llamara `PostController` el cual si bien sera similar a un controlador como recurso el cual cuenta con operaciones para un `CRUD` pero en este caso `las funciones de CREAR y EDITAR (que son formularios) se encargara de proveerlos el software que se conecte a la api` por lo que lo unico que necesitamos en el api es las funciones de salvar, listar, etc, `(Codigo de accion)`

### Metodo Destroy en como controller
Dentro del metodo destroy usando la variable que recibimos como parametro en la url `$post` con la siguiente linea en uso del ORM borramos el post `$post->delete();` y seguido enviamos un response con json

```php
  return response()->json([
    'message:' => "Success"
  ], 204);
```
`El codigo 204 corresponde a sin contenido`


### Versionado --> Ver2.0

Se hace un analisis referente a peticiones del usuario que quiera mejoras en el API por lo que hay que empezar a definir
- Que tenemos?
- Que se necesita?
- Configuracion
- Recurso
- Coleccion