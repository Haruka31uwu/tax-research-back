<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DeleteClient extends AbstractMigration
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
        $sql=<<<SQL
        CREATE PROCEDURE sp_delete_client(in p_id int)
        begin
            delete from clients where clients.id=p_id;
        END
        SQL;
        $this->execute($sql);
    }
}
