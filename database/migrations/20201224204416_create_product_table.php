<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductTable extends AbstractMigration
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
        $user = $this->table('products', ['collation' => 'utf8mb4_persian_ci', 'engine' => 'InnoDB']);
        $user
            ->addColumn('name', STRING, [LIMIT => 20])
            ->addColumn('count', STRING, [LIMIT => 75])
            ->addColumn('code', STRING, [LIMIT => 100])
            ->addColumn('buy_price', STRING, [LIMIT => 30])
            ->addColumn('sell_price', STRING, [LIMIT => 30])
            ->addColumn('aed_price', STRING, [LIMIT => 50])
            ->addTimestamps()
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('products')->drop()->save();
    }

}
