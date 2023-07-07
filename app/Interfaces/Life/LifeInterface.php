<?php
namespace App\Interfaces\Life;

interface LifeInterface
{

    public function index();

    public function delete();

    public function buy($request);

    public function pack_index();
    public function pack_store($request);
    public function pack_update($request,$item);
    public function pack_delete($item);

    public function pack_user_index();
    public function pack_user_by($item);

    public function change($request);

}
