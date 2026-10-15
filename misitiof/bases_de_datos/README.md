# Bases de datos en XAMPP

La aplicación PHP usa `sistem_fares` (sin la letra `a` después de `sistem`) para clientes, inventario, movimientos y facturas. La base antigua `sistema_fares` se puede abrir desde el mismo código cuando sea necesario importar o consultar sus clientes. `conexionf.php` y `conexionf2.php` comparten la configuración de `configuracion_bd.php`.

Todas las conexiones usan `localhost`, `root` y contraseña vacía por defecto para XAMPP. Para cambiar estos datos sin editar el código, define las variables de entorno `FARES_DB_HOST`, `FARES_DB_USER` y `FARES_DB_PASSWORD`.

Los módulos normales se conectan a `sistem_fares`. Para acceder explícitamente a la base antigua, usa `conect('sistema_fares')` o `new Conexion('sistema_fares')`.

## Instalación o actualización local

1. Inicia Apache y MySQL desde el panel de XAMPP.
2. En phpMyAdmin, importa `basedatos.sql` para crear las tablas que usa el sitio y ajustar el inventario al formato de imágenes y precios actual.
3. Para una instalación existente, ejecuta únicamente `bases_de_datos/sistem_fares/05_libros_comentarios.sql` para agregar la información y los comentarios de libros. No vuelvas a importar los respaldos de clientes o productos.
4. Si necesitas recuperar los clientes del respaldo `sistema_fares.sql`, impórtalo primero en la base `sistema_fares` y luego ejecuta `migrar_clientes.sql`. El segundo paso copia sus clientes a `sistem_fares`; si un identificador ya está ocupado, asigna otro y conserva ambos registros.

Los archivos `sistem_fares.sql` y `sistema_fares.sql` de la carpeta principal son respaldos antiguos. Incluyen instrucciones para reemplazar tablas; no los importes encima de una base que ya tenga datos. Usa `basedatos.sql` para el esquema actual.

Los respaldos contienen datos personales de clientes. Manténlos en tu equipo y elimina o anonimiza esos datos antes de publicar un respaldo.
