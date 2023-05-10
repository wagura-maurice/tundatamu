<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item',
        'default_value',
        'current_value'
    ];

    /**
     * It creates a rule for the item, default_value and current_value.
     * 
     * @return An array of rules for the create method.
     */
    public static function createRules()
    {
        return [
            'item' => 'required|string|unique:settings',
            'default_value' => 'required|string',
            'current_value' => 'nullable|string'
        ];
    }

    /**
     * A function that is used to validate the data that is being sent to the database.
     * 
     * @param int id The id of the record you want to update.
     * 
     * @return An array of rules for the update method.
     */
    public static function updateRules(int $id)
    {
        return [
            'item' => 'nullable|string|'.Rule::unique('settings', 'item')->ignore($id),
            'default_value' => 'nullable|string',
            'current_value' => 'nullable|string'
        ];
    }
}
