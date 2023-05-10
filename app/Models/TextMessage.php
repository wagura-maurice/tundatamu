<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TextMessage extends Model
{
    use HasFactory, SoftDeletes;

    // STATUS
    const PENDING = 0;
    const PROCESSING = 1;
    const PROCESSED = 2;
    const DELIVERED = 3;
    const FAILED = 4;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_pid',
        'category_id',
        'bulk_text_message_id',
        'content',
        'telephone',
        'transaction_id',
        'transaction_amount',
        '_status'
    ];

    /**
     * It creates rules for the text message model.
     * 
     * @return The createRules() method returns an array of rules that are used to validate the data
     * that is being passed to the TextMessage model.
     */
    public static function createRules()
    {
        return [
            '_pid' => 'required|string|unique:text_messages',
            'category_id' => 'required|integer',
            'bulk_text_message_id' => 'nullable|integer',
            'content' => 'required|string',
            'telephone' => 'required|string',
            'transaction_id' => 'nullable|string|unique:text_messages',
            'transaction_amount' => 'nullable|numeric'
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
            '_pid' => 'nullable|string|'.Rule::unique('text_messages', '_pid')->ignore($id),
            'category_id' => 'nullable|integer',
            'bulk_text_message_id' => 'nullable|integer',
            'content' => 'nullable|string',
            'telephone' => 'nullable|string',
            'transaction_id' => 'nullable|string|'.Rule::unique('text_messages', 'transaction_id')->ignore($id),
            'transaction_amount' => 'nullable|numeric'
        ];
    }
}
