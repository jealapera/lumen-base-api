<?php 

namespace App\Common;

/**
 * Class for Basic CRUD using Eloquent ORM (Object-relational Mapping)
 * Class BaseModelResource
 */
class BaseModelResource
{
    /**
     * @var
     */
    private $db;

    /**
     * @var
     */
    private $model;

    /**
     * Constructor
     */
    public function __construct($model)
    {
        $this->db = app('db');
        $this->model = $model;
    }

    /**
     * Creates a new record of data
     *
     * @param $data
     * @return object(Model)
     */
    public function create($data)
    {
        return $this->db->transaction(function() use($data) {
            try 
            {
                $data = $this->model->create($data);
            } 
            catch(\Exception $e) 
            {
                $this->db->rollback();
                return $e;
            }

            $this->db->commit();

            return $data;
        });
    }

    /**
     * Retrieves all data with pagination
     *
     * @param int $perPage
     * @param $columns = array('*')
     * @return object(Illuminate\Pagination\LengthAwarePaginator)
     */
    public function paginate($perPage, $columns = array('*')) 
    {    
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Retrieves all data
     *
     * @param $columns = array('*')
     * @return object(Illuminate\Database\Eloquent\Collection)
     */
    public function getAll($columns = array('*'))
    {   
        return $this->model->all($columns);
    }

    /**
     * Retrieves all data by a specific attribute (Table Column)
     * 
     * @param $attribute
     * @param $value
     * @param $columns = array('*')
     * @return object(Illuminate\Database\Eloquent\Collection)
     */
    public function getAllByAttribute($attribute, $value, $columns = array('*'))
    {   
        return $this->model->where($attribute, $value)->get($columns);
    }

    /**
     * Retrieves a specific data by id
     * 
     * @param $id
     * @return object(Model)
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Retrieves a specific data by attribute
     * 
     * @param $attribute
     * @param $value
     * @param $columns = array('*')
     * @return object(Model)
     */
    public function getByAttribute($attribute, $value, $columns = array('*'))
    {   
        return $this->model->where($attribute, $value)->first($columns);
    }

    /**
     * Updates an existing record of data by id
     * 
     * @param $id
     * @param $data
     * @return object(Model)
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update($id, $data)
    {   
        return $this->db->transaction(function() use($id, $data) {
            try 
            {
                $data = $this->model->find($id)->update($data);
            } 
            catch(\Exception $e) 
            {
                $this->db->rollback();
                return $e;
            }

            $this->db->commit();

            return $this->getById($id);
        });
    }

    /**
     * Deletes a specific data by id
     * 
     * @param $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->db->transaction(function() use($id) {
            try 
            {
                $data = $this->model->find($id)->delete();
            } 
            catch(\Exception $e) 
            {
                $this->db->rollback();
                return $e;
            }
            
            $this->db->commit();

            return $data;
        });
    }
}