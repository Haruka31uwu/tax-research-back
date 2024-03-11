<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SpInsertUpdateClient extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {

        $procedure=<<<SQL
        CREATE PROCEDURE sp_insert_update_client(
            IN p_id INT,
            IN p_nombre VARCHAR(255),
            IN p_apellido VARCHAR(255),
            IN p_edad INT,
            IN p_fecnac DATE,
            IN p_dni VARCHAR(20)
        )
        BEGIN
            DECLARE client_count INT;
        
            -- Verificar si el cliente ya existe
            SELECT COUNT(*) INTO client_count FROM clients WHERE id = p_id;
        
            IF client_count = 0 THEN
                -- Si el cliente no existe, insertarlo
                INSERT INTO clients (id, nombre, apellido, edad, fecnac, dni,created_at)
                VALUES (p_id, p_nombre, p_apellido, p_edad, p_fecnac, p_dni,now());
            ELSE
                -- Si el cliente ya existe, actualizar sus datos
                UPDATE clients
                SET nombre = p_nombre,
                    apellido = p_apellido,
                    edad = p_edad,
                    fecnac = p_fecnac,
                    dni = p_dni,
                    updated_at=now()
                WHERE id = p_id;
            END IF;
        END
        SQL;
        $this->execute($procedure);
    }
}
