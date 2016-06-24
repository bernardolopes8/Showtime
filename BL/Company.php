<?php

require_once(dirname(__FILE__).'/../DAL/CompanyDAL.php');

class Company {
    public $id;
    public $name;
    
    public function copy($company){
        $this->id = $company->id_company;
        $this->name = $company->name;
    }

    public function create() {
        $res = false;
        if (!CompanyDAL::getById($this)) {
            $res = CompanyDAL::create($this);
        }
        return($res);
    }

    public function update() {
        $res = CompanyDAL::update($this);
        return($res);
    }

    public function delete() {
        $res = CompanyDAL::delete($this);
        return($res);
    }

    public function getById() {
        return(CompanyDAL::getById($this));
    }
    
    public function getByName() {
        return(CompanyDAL::getByName($this));
    }
    
    public function getAll() {
        return(CompanyDAL::getAll());
    }
}