<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

class clanekPresenter extends Nette\Application\UI\Presenter
{
    private Nette\Database\Explorer $database;

	public function __construct(Nette\Database\Explorer $database)
{
    $this->database = $database;
}
public function renderDefault(int $postId): void
{
    $post=$this->database->table('posts')->get($postId);
    if(!$post) {
        $this->error('Stránka nebyla nalezena');
    }

    $this->template->post = $post;
}

protected function createComponentPostForm(): Form
{
    $form = new Form;
    $form->addText('title','nadpis');
    $form->addText('autor','autor');
    $form->addTextArea('content','obsah');
    $form->addSubmit('send','uložit');
    $form->onSuccess[]= [$this,'postFormSucceeded'];
    return $form;
}
public function postFormSucceeded(Form $form, array $values): void
{
    $postId = $this->getParameter('postId');
    if($postId){
        $post = $this->database->table('posts')->get($postId);
        $post->update($values);
    }
    else{
        $post = $this->database->table('posts')->insert($values);
    }
    $this->redirect('default',$post->id);
}
public function actionEdit (int $postId): void
{
    $post = $this->database->table('posts')->get($postId);
    if(!$post){
        $this->error('přispěvek neexistuje');
    }
    $this['postForm']->setDefaults($post->toArray());
}
public function actionDelete (int $postId):void
{
    $post = $this->database->table('posts')->get($postId);
    if(!$post){
       $this->error('přispěvek neexistuje');
    }
    $this->database->query('DELETE FROM posts WHERE id=?,$postId');
}
}
