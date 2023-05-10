<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LightOfGuidance extends Model
{
    use HasFactory, SoftDeletes;

    // status
    const PENDING = 0;
    const OPEN = 1;
    const CLOSED = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_class',
        'description',
        '_status'
    ];

    /**
     * It creates a rule for the class and description.
     * 
     * @return An array of rules for the create method.
     */
    public static function createRules()
    {
        return [
            '_class' => 'required|string',
            'description' => 'required|string'
        ];
    }

    /**
     * A function that is used to validate the data that is being sent to the server.
     * 
     * @return An array of rules for the update method.
     */
    public static function updateRules()
    {
        return [
            '_class' => 'required|string',
            'description' => 'nullable|string'
        ];
    }
}
