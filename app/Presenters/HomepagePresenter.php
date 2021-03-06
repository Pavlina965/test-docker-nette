<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{

    private  $database;

    public function __construct(Nette\Database\Explorer $database)
    {
        $this->database = $database;
    }
    public function renderDefault(): void
    {
        $this->template->posts = $this->database->table('posts')
            ->order('created_at DESC');

    }

}
