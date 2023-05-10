<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Sparors\Ussd\Facades\Ussd as SPARORS;
use App\Models\UnstructuredSupplementaryServiceData;

class UnstructuredSupplementaryServiceDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $LOG = new UnstructuredSupplementaryServiceData;

            $LOG->sessionId = $request->sessionId;
            $LOG->phoneNumber = phoneNumberPrefix($request->phoneNumber);
            $LOG->serviceCode = $request->serviceCode;
            $LOG->networkCode = $request->networkCode;
            $LOG->cost = isset($request->cost) && !empty($request->cost) ? getOnlyNumbers($request->cost) : NULL;

            $LOG->save();

            Cache::remember(phoneNumberPrefix($request->phoneNumber), 444, function () use ($request) {
                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://gizpassion.com/api/farmers?search=' . substr(phoneNumberPrefix($request->phoneNumber), -9),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET'
                ]);

                $error    = curl_error($curl);
                $response = json_decode(curl_exec($curl));

                curl_close($curl);

                if ($error) {
                    return false;
                }
                
                return optional($response)[0] ?? false;
            });

            $STATE = optional(optional(Cache::get(phoneNumberPrefix($request->phoneNumber)))->user)->username ? \App\Http\Ussd\States\Initialize::class : \App\Http\Ussd\States\Account\Create\Name::class;

            $USSD = SPARORS::machine()
                ->set([
                    'sessionId' => $request->sessionId,
                    'phoneNumber' => phoneNumberPrefix($request->phoneNumber),
                    'networkCode' => $request->networkCode,
                    'network' => $request->serviceCode
                ])
                ->setInput(strpos(request('text'), '*') !== false ? substr(request('text'), strrpos(request('text'), '*') + 1) : request('text'))
                // ->setInput(strpos($request->text, '*') !== false ? substr($request->text, strrpos($request->text, '*') + 1) : ($request->text ? $request->text : 0))
                ->setInitialState($STATE)
                ->setResponse(function (string $message, string $action) {
                    switch ($action) {
                        case 'prompt':
                            return "END $message";
                            break;
                            
                        default:
                            return "CON $message";
                            break;
                    }
                });

                return $USSD->run();
                
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnstructuredSupplementaryServiceData  $unstructuredSupplementaryServiceData
     * @return \Illuminate\Http\Response
     */
    public function show(UnstructuredSupplementaryServiceData $unstructuredSupplementaryServiceData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnstructuredSupplementaryServiceData  $unstructuredSupplementaryServiceData
     * @return \Illuminate\Http\Response
     */
    public function edit(UnstructuredSupplementaryServiceData $unstructuredSupplementaryServiceData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnstructuredSupplementaryServiceData  $unstructuredSupplementaryServiceData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UnstructuredSupplementaryServiceData $unstructuredSupplementaryServiceData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnstructuredSupplementaryServiceData  $unstructuredSupplementaryServiceData
     * @return \Illuminate\Http\Response
     */
    public function destroy(UnstructuredSupplementaryServiceData $unstructuredSupplementaryServiceData)
    {
        //
    }
}
