<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

require __DIR__ . '/define.php';

final class CreateUserTable extends AbstractMigration
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
    public function up()
    {
        // UserSeeder table
        $user = $this->table('users', ['collation' => 'utf8mb4_persian_ci', 'engine' => 'InnoDB']);
        $user
            ->addColumn('username', STRING, [LIMIT => 20])
            ->addColumn('password', STRING, [LIMIT => 75])
            ->addColumn('email', STRING, [LIMIT => 100])
            ->addColumn('first_name', STRING, [LIMIT => 30])
            ->addColumn('last_name', STRING, [LIMIT => 30])
            ->addColumn('ip', STRING, [LIMIT => 50])
            ->addTimestamps()
            ->addIndex(['username', 'email'], [UNIQUE => true])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('users')->drop()->save();
    }

}
