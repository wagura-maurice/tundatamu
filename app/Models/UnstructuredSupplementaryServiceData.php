<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnstructuredSupplementaryServiceData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sessionId',
        'phoneNumber',
        'serviceCode',
        'networkCode',
        'cost'
    ];

    /**
     * It creates rules for the fields in the form.
     * 
     * @return An array of rules
     */
    public static function createRules()
    {
        return [
            'sessionId' => 'required|string|unique:unstructured_supplementary_service_data',
            'phoneNumber' => 'required|string',
            'serviceCode' => 'required|string',
            'networkCode' => 'nullable|string',
            'cost' => 'nullable|string'
        ];
    }

    /**
     * A function that returns an array of rules for updating a record in the database.
     * 
     * @param int id The id of the record you want to update.
     * 
     * @return The updateRules function is returning an array of rules.
     */
    public static function updateRules(int $id)
    {
        return [
            'sessionId' => 'nullable|string|'.Rule::unique('unstructured_supplementary_service_data', 'sessionId')->ignore($id),
            'phoneNumber' => 'nullable|string',
            'serviceCode' => 'nullable|string',
            'networkCode' => 'nullable|string',
            'cost' => 'nullable|string'
        ];
    }
}
