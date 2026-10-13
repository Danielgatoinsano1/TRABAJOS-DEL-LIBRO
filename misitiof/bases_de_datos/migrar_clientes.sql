-- Copia clientes de sistema_fares a la base que usa la aplicación.
-- Puede volver a ejecutarse sin duplicar clientes con el mismo nombre y correo.
START TRANSACTION;

-- Conserva el id original cuando todavía está disponible.
INSERT INTO sistem_fares.clientes
    (idcli, nomcli, direccli, telres_cli, telcel_cli, email_cli)
SELECT origen.idcli, origen.nomcli, origen.direccli,
       origen.telres_cli, origen.telcel_cli, origen.email_cli
FROM sistema_fares.clientes AS origen
WHERE NOT EXISTS (
    SELECT 1
    FROM sistem_fares.clientes AS destino
    WHERE destino.idcli = origen.idcli
)
AND NOT EXISTS (
    SELECT 1
    FROM sistem_fares.clientes AS destino
    WHERE destino.nomcli = origen.nomcli
      AND destino.email_cli <=> origen.email_cli
);

-- Si el id ya existe para otra persona, deja que la base asigne uno nuevo.
INSERT INTO sistem_fares.clientes
    (nomcli, direccli, telres_cli, telcel_cli, email_cli)
SELECT origen.nomcli, origen.direccli,
       origen.telres_cli, origen.telcel_cli, origen.email_cli
FROM sistema_fares.clientes AS origen
WHERE EXISTS (
    SELECT 1
    FROM sistem_fares.clientes AS destino
    WHERE destino.idcli = origen.idcli
)
AND NOT EXISTS (
    SELECT 1
    FROM sistem_fares.clientes AS destino
    WHERE destino.nomcli = origen.nomcli
      AND destino.email_cli <=> origen.email_cli
);

COMMIT;
