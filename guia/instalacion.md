# Instrucciones de instalación y despliegue

## En local

Para la instalación en local es imprescindible:

- PHP >= 7.0.0
- Composer
- Postgresql >= 9.6
- Apache 2

Con el apache ya habilitado, en nuestra carpeta web ejecutameos:

```
git clone https://github.com/danigove/phergeon.git
cd phergeon
composer install
composer run-script post-create-project-cmd
cd ../db
sh ./create.sh
sh ./load.sh
```

Dentro del projecto necesitaremos un archivo que se llame ".env" donde guardaremos las siguientes claves:
- SMTP_PASS:  Con la contraseña del correo que usaremos de administrador (en este caso, el mío del Doñana)
- DROPBOX_TOKEN: Con el valor de la API de Dropbox de la cuenta que queramos usar para el almacenamiento de las fotos de los animales.
- GOOGLE_MAPS: Con el valor de la API de Google Maps (con la API de Distance Matrix habilitada) para realizar el calculo de distancias.



## En la nube

Necesitamos el heroku cli instalado en nuestro equipo.

1. - Clonamos el repositorio 
2. - Creamos una aplicación en heroku con nuestras credenciales.
3. - Vamos a la carpeta donde hemos copiado el proyecto y hacemos un heroku login y el git:remote -a "nombre_app" y finalmente un git push heroku master.
4. - Añadimos las variables de entorno que configuramos en la instalación en local.
5. - Añadir una variable de entorno adicional, YII_ENV=prod.
6. - Añadir el add-on heroku-postgresql y  meter el archivo .sql de la carpeta db para que tenga la base de datos.
7. - A disfrutar.
