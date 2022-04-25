<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MyFirstMigration extends AbstractMigration
{
    public function up()
    {
        $this->execute(create table article
    (
        obsah text null,
	datum_vytvoreni datetime null,
	autor varchar null,
	nadpis varchar null,
	id int null,
	constraint article_pk
		primary key(id)
);)
    }
    public function down(){

    }
}
