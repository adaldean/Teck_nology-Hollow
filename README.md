# Teck_nology-Hollow
Teck_nology Hollow es una plataforma de comercio electrónico especializada en la venta de accesorios, teléfonos y computadoras, con una integración clave de un Sistema de Punto de Venta (PoS) 

Ejecuten estos comandos en su terminal linux para el restauramiento de la base de datos:
    -psql -U (su_usuario_admin) -c "DROP DATABASE IF EXISTS teck_nology_hollow;"  ---> borra la base de datos en caso      de tener una ya echa pero imcompleta
    -psql -U postgres -c "CREATE DATABASE teck_nology_hollow;" ---> Crear una nueva base vacía
    -pg_restore -U postgres -d teck_nology_hollow -v ~/Respaldo/teck_nology_hollow.backup ---> Restaura el respaldo
