<?php 

namespace App\Common\Resource\Services;

use App\Common\Resource\Events\ResourceWasCreated;
use App\Common\Resource\Events\ResourceWasDeleted;
use App\Common\Resource\Events\ResourceWasUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;

/**
 * Class for Basic CRUD
 * Class ResourceService
 */
class ResourceService
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
     * Constructor
     */
    public function __construct()
    {
        $this->db = app('db');
        $this->dispatcher = new Dispatcher(new Container());
    }

    /**
     * @return Model
     */
    public function model()
    {
        return new Model();
    }

    /**
     * Creates a new record of data
     *
     * @param $data
     * @return mixed
     * @throws Exception
     * @throws \Exception
     */
    public function create($data)
    {
        return $this->db->transaction(function() use($data) {
            try
            {
                $data = $this->model()->create($data);
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
     * @return mixed
     */
    public function paginate($perPage, $columns = array('*')) 
    {    
        return $this->model()->paginate($perPage, $columns);
    }

    /**
     * Retrieves all data
     *
     * @param array $columns
     * @return mixed
     */
    public function getAll($columns = array('*'))
    {   
        return $this->model()->all($columns);
    }

    /**
     * Retrieves a specific data by id
     * 
     * @param $id
     * @return object
     */
    public function getById($id)
    {   
        return $this->model()->find($id);
    }

    /**
     * Updates an existing record by id
     * 
     * @param $id
     * @param $data
     * @return 
     */
    public function update($id, $data)
    {   
        return $this->db->transaction(function() use($id, $data) {
            try
            {
                $data = $this->model()->find($id)->update($data);
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
     * @return 
     */
    public function delete($id)
    {
        return $this->db->transaction(function() use($id) {
            try
            {
                $data = $this->model()->find($id)->delete();
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