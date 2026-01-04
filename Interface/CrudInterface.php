<?php
interface CrudInterface{
    public function Add(object $data):bool;
    public function selectAll():array;
    public function update(int $id,object $data):bool;
    public function delete(int $id):bool;
}