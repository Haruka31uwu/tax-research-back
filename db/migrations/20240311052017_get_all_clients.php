<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class GetAllClients extends AbstractMigration
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
        $sp = <<<SQL
        CREATE PROCEDURE sp_get_all_clients(
            IN `p_offset` INT,
            IN `p_pageSize` INT
            )
        BEGIN
            SELECT *
            FROM clients
            LIMIT `p_offset`, `p_pageSize`;
        END;
        SQL;
        $this->execute($sp);
    }
}
