<?php 

namespace App\Common;

use App\Common\Resource\Events\ResourceWasCreated;
use App\Common\Resource\Events\ResourceWasDeleted;
use App\Common\Resource\Events\ResourceWasUpdated;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;

/**
 * Class for Basic CRUD for Model
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
    private $dispatcher;

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
        $this->dispatcher = new Dispatcher(new Container());
        $this->model = $model;
    }

    /**
     * Creates a new record of data
     *
     * @param $data
     * @return Mixed
     * @throws Exception
     * @throws \Exception
     */
    public function create($data)
    {
        return $this->db->transaction(function() use($data) {
            try
            {
                $data = $this->model->create($data);
                $this->dispatcher->fire(new ResourceWasCreated($data));
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
     * @param array $columns
     * @return Mixed
     */
    public function paginate($perPage, $columns = array('*')) 
    {    
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Retrieves all data
     *
     * @param array $columns
     * @return Mixed
     */
    public function getAll($columns = array('*'))
    {   
        return $this->model->all($columns);
    }

    /**
     * Retrieves a specific data by id
     * 
     * @param $id
     * @return Object
     */
    public function getById($id)
    {   
        return $this->model->find($id);
    }

    /**
     * Retrieves a specific user by attribute
     * 
     * @param $attribute
     * @param $value
     * @return Object
     */
    public function getByAttribute($attribute, $value, $columns = array('*'))
    {   
        return $this->model->where($attribute, $value)->first($columns);
    }

    /**
     * Updates an existing record by id
     * 
     * @param $id
     * @param $data
     * @return Mixed
     */
    public function update($id, $data)
    {   
        return $this->db->transaction(function() use($id, $data) {
            try
            {
                $data = $this->model->find($id)->update($data);
                $this->dispatcher->fire(new ResourceWasUpdated($data));
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
     * @return Boolean
     */
    public function delete($id)
    {
        return $this->db->transaction(function() use($id) {
            try
            {
                $data = $this->model->find($id)->delete();
                $this->dispatcher->fire(new ResourceWasDeleted($data));
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