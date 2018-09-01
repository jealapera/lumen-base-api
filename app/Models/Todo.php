<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The rules for the validation of the given data.
     *
     * @var array
     */
    public $rules = [
        'user_id' => 'required', 
        'title' => 'required|max:64', 
        'description' => '', 
        'status' => ''
    ];

    /**
     * Retrieves all todos by user id
     * 
     * @param $userId
     * @return JSON|Mixed
     */
    public function getAllByUserId($userId)
    {
        return $this->select('todos.id', 
                        'users.id AS user_id', 
                        'users.name AS username', 
                        'todos.title',
                        'todos.description',
                        'todos.created_at',
                        'todos.updated_at')
                    ->join('users', 'todos.user_id', '=', 'users.id')
                    ->where('todos.user_id', $userId)
                    ->get();
    }
}