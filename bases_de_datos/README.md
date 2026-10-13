# Bases de datos en XAMPP

La aplicación PHP se conecta a `sistem_fares` (sin la letra `a` después de `sistem`). Las páginas de clientes, inventario, movimientos y facturas usan esa base.

## Instalación o actualización local

1. Inicia Apache y MySQL desde el panel de XAMPP.
2. En phpMyAdmin, importa `basedatos.sql` para crear las tablas que usa el sitio y ajustar el inventario al formato de imágenes y precios actual.
3. Si necesitas recuperar los clientes del respaldo `sistema_fares.sql`, impórtalo primero en la base `sistema_fares` y luego ejecuta `migrar_clientes.sql`. El segundo paso copia sus clientes a `sistem_fares`; si un identificador ya está ocupado, asigna otro y conserva ambos registros.

Los archivos `sistem_fares.sql` y `sistema_fares.sql` de la carpeta principal son respaldos antiguos. Incluyen instrucciones para reemplazar tablas; no los importes encima de una base que ya tenga datos. Usa `basedatos.sql` para el esquema actual.

Los respaldos contienen datos personales de clientes. Manténlos en tu equipo y elimina o anonimiza esos datos antes de publicar un respaldo.
