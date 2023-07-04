<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BlockChainController extends Controller
{
    public function generateQR(Request $request)
    {
        // dd($requesyt->all());

        // Start output buffering
        ob_start();

        $data = $request->all();
        foreach ($data as $index => $record) {
            echo "#" . $record[0] . " - " . ucwords($record[1]) . "\n";
            echo ucwords($record[2]) . "\n";
            echo Carbon::parse($record[3])->toDateString() . "\n";

            // Double line break after each record, except the last one
            if ($index < count($request->all()) - 1) {
                echo "\n";
            }
        }

        // Store the output in a variable
        $output = ob_get_clean();

        $image = QrCode::format('png')
            // ->merge(public_path('images/out.png'), 0.1, true)
            ->backgroundColor(247, 195, 95)
            ->size(700)
            ->errorCorrection('H')
            ->generate($output);
  
        return response($image)->header('Content-type','image/png');
    }
}

