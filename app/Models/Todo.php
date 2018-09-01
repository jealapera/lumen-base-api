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
     * Todo belongs to one and only one User
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Retrieves all todos by user id
     * 
     * @param $userId
     * @return JSON|Mixed
     */
    public function getAllByUserId($userId)
    {
        return collect($this->select('id', 'user_id', 'title', 'description', 'created_at', 'updated_at')
                    ->with(array('user' => function($query) {
                        $query->select('id', 'name', 'email');
                    }))
                    ->where('user_id', '=', $userId)
                    ->get());
    }
}