<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qr_Code_Scan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Visitor;
use App\Models\Inmate;

use Illuminate\Support\Facades\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Barryvdh\Snappy\Facades\SnappyPdf;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;



class AttendanceControler extends Controller
{
    function scan(){
        return view('Attendance.scan');
     }
     public function store(Request $request)
     {
         // Validate the incoming request data
         $validatedData = $request->validate([
             'visitor' => 'required|string',
             'date' => 'required|date',
         ]);
     
         // Check if the visitor exists in the visitors table
         $visitor = Visitor::where('visitor', $validatedData['visitor'])->first();
     
         if (!$visitor) {
             // If the visitor is not registered, return an error response
             return response()->json(['message' => 'Visitor is not registered'], 400);
         }
     
         // Check if the visitor's status is active
         if ($visitor->status !== 'active') {
             // If the visitor's status is not active, return an error response
             return response()->json(['message' => 'Visitor is not active'], 400);
         }

            // Get the visitor's inmate data
        $visitorInmate = $visitor->inmate;

        // Check if the inmate exists and has an active status in the Inmate table
        $inmate = Inmate::where('inmate', $visitorInmate)->first();

        if (!$inmate) {
            // If the inmate is not found, return an error response
            return response()->json(['message' => 'Inmate not found'], 400);
        }

        if ($inmate->status !== 'active') {
            // If the inmate's status is not active, return an error response
            return response()->json(['message' => 'Inmate is not active'], 400);
        }


        
            // Check if an entry already exists for the visitor and date
            $existingScan = Qr_Code_Scan::where('visitor', $validatedData['visitor'])
                ->where('date', $validatedData['date'])
                ->orderBy('created_at','desc')
                ->first();
        
            if ($existingScan && !$existingScan->time_out) {
                // If an entry exists and there is no time_out, consider it a time_out
                $existingScan->time_out = DB::raw('CURTIME()');
                $existingScan->save();
        
                // Return a response indicating successful time_out
                return response()->json(['message' => 'QR code scan timed out successfully']);
            }
        
            // Create a new QRCodeScan instance and set the attributes
            $qrCodeScan = new Qr_Code_Scan();
            $qrCodeScan->visitor = $validatedData['visitor'];
            $qrCodeScan->inmate_att = $visitorInmate;
            $qrCodeScan->time_in = DB::raw('CURTIME()'); // Use CURTIME() to get the current time
            $qrCodeScan->time_out = null;
            $qrCodeScan->date = DB::raw('CURDATE()');
        
            // Save the QRCodeScan instance to the database
            $qrCodeScan->save();
        
            // Return a response indicating successful time_in
            return response()->json(['message' => 'QR code scan timed in successfully']);
        }
        public function View_Attendance(Request $request)
        {
            $search = $request ['search'] ?? "";
            if ($search != ""){
                //where
                $attendances = Qr_Code_Scan::where('visitor','LIKE', "%$search%")->orwhere('date','LIKE', "%$search%")->orwhere('inmate_att','LIKE', "%$search%")->paginate(10);
            }else {
                $attendances = Qr_Code_Scan::orderBy("created_at", "asc")->get();
            }
            $attendance= compact('attendances','search');
            //$inmates = Inmate::all();
            return view('Attendance.attendance')->with($attendance);
    }

    public function generateAttendancePDF(Request $request)
{
    $html = $request->input('html');
    $pdfFilename = time() . '.pdf';

    $pdf = SnappyPdf::loadHTML($html);
    $pdf->setOption('page-size', 'letter');
    $pdf->setOption('orientation', 'portrait');

    $content = $pdf->download();

    return Response::make($content)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="attendance.pdf"');
}

public function delete_attendance(Request $request)
{
    // Delete the attendance record based on the provided ID
    $response = Qr_Code_Scan::find($request->id)->delete();
    return $response;
}
}