<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BulkTextMessage extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_pid',
        'category_id',
        'content',
        'contacts',
        '_status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'contacts' => 'collection'
    ];

    /**
     * It creates a rule for the bulk text message.
     * 
     * @return The rules for the bulk text message.
     */
    public static function createRules()
    {
        return [
            '_pid' => 'required|string|unique:bulk_text_messages',
            'category_id' => 'required|integer',
            'content' => 'required|string',
            'contacts' => 'required|string'
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
            '_pid' => 'nullable|string|'.Rule::unique('bulk_text_messages', '_pid')->ignore($id),
            'category_id' => 'nullable|integer',
            'content' => 'nullable|string',
            'contacts' => 'nullable|string'
        ];
    }
}
