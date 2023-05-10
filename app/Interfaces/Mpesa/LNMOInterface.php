<?php

namespace App\Interfaces\Mpesa;

interface LNMOInterface
{    
    /**
     * LNMO request
     *
     * This method is used to initiate online payment on behalf of a customer.
     *
     * @param array $array from mpesa api
     * @return Json response for payment details i.e transaction code and timestamps e.t.c
     */
    public function transact(array $data);

    /**
     * LNMO query
     *
     * This method is used to check the status of a Lipa Na M-Pesa Online Payment.
     *
     * @param string $identifier from mpesa api
     * @return Json response for payment details i.e transaction code and timestamps e.t.c
     */
    public function query(string $identifier);

    /**
     * LNMO callback
     *
     * This method is used to confirm a LNMO Transaction that has passed various methods set by the developer during validation
     *
     * @param array $request from mpesa api
     * @return Json respond for payment details i.e transaction code and timestamps e.t.c
     */
    public function callback(array $data);
}