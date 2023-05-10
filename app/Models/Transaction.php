<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    // category
    const PURCHASE = 0;
    const SALE = 1;

    // type
    const DEBIT = 0;
    const CREDIT = 1;

    // channel
    const C2B = 0;
    const LNMO = 1;
    const B2C = 2;
    const B2B = 3;

    // mpesa daraja api transaction type
    const LIPA_NA_MPESA_ONLINE = 'LNMO';
    const CUSTOMER_PAY_BILL_ONLINE = 'CustomerPayBillOnline';
    const CUSTOMER_BUY_GOODS_ONLINE = 'CustomerBuyGoodsOnline';

    // aggregator
    const MPESA_KE = 0;
    const EQUITY_KE = 1;
    const KCB_KE = 2;
    const FLEXPAY_KE = 3;

    // status
    const PENDING = 0;
    const PROCESSING = 1;
    const PROCESSED = 2;
    const REJECTED = 3; // after transaction is processed.
    const ACCEPTED = 4; // after transaction is processed.

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_pid',
        'party_a',
        'party_b',
        'account_reference',
        'transaction_category',
        'transaction_type',
        'transaction_channel',
        'transaction_aggregator',
        'transaction_id',
        'transaction_amount',
        'transaction_code',
        'transaction_timestamp',
        'transaction_details',
        '_feedback',
        '_status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    /* protected $casts = [
        '_feedback' => 'collection'
    ]; */

    /**
     * It returns an array of rules that are to be used to validate the data that is to be stored in
     * the database
     * 
     * @return an array of rules that will be used to validate the data being passed to the create
     * method.
     */
    public static function createRules()
    {
        return [
            '_pid' => 'required|string|unique:transactions',
            'party_a' => 'required|string',
            'party_b' => 'required|string',
            'account_reference' => 'required|string',
            'transaction_category' => 'required|integer',
            'transaction_type' => 'required|integer',
            'transaction_channel' => 'required|integer',
            'transaction_aggregator' => 'required|integer',
            'transaction_id' => 'required|string',
            'transaction_amount' => 'required|numeric',
            'transaction_code' => 'nullable|string|unique:transactions',
            'transaction_timestamp' => 'required|timestamp',
            'transaction_details' => 'required|string',
            '_feedback' => 'required|string'
        ];
    }

    /**
     * > It returns an array of rules that can be used to validate a request to update a transaction
     * 
     * @param int id The id of the record to be updated.
     * 
     * @return An array of rules for updating a transaction.
     */
    public static function updateRules(int $id)
    {
        return [
            '_pid' => 'nullable|string|'.Rule::unique('transactions', '_pid')->ignore($id),
            'party_a' => 'nullable|string',
            'party_b' => 'nullable|string',
            'account_reference' => 'nullable|string',
            'transaction_category' => 'nullable|integer',
            'transaction_type' => 'nullable|integer',
            'transaction_channel' => 'nullable|integer',
            'transaction_aggregator' => 'nullable|integer|',
            'transaction_id' => 'required|string',
            'transaction_amount' => 'nullable|numeric',
            'transaction_code' => 'nullable|string|'.Rule::unique('transactions', 'transaction_code')->ignore($id),
            'transaction_timestamp' => 'nullable|timestamp',
            'transaction_details' => 'nullable|string',
            '_feedback' => 'nullable|string'
        ];
    }
}
