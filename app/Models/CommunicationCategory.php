<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommunicationCategory extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'template'
    ];

    /**
     * It creates a rule for the invoice category.
     * 
     * @return The rules for creating a new invoice category.
     */
    public static function createRules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:communication_categories',
            'description' => 'nullable|string',
            'template' => 'required|integer'
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
            'name' => 'nullable|string',
            'slug' => 'nullable|string|'.Rule::unique('communication_categories', 'slug')->ignore($id),
            'description' => 'nullable|string',
            'template' => 'nullable|integer'
        ];
    }
}
