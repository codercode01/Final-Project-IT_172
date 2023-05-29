<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Visitor;
use Illuminate\Support\Facades\Storage;
use App\Models\Inmate;
use Illuminate\Support\Facades\View;

use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;





class QRCodeController extends Controller
{
    
    public function showForm()
    {
        $inmates = Inmate::all();
        return view('register_visitor', compact('inmates'));
    }

    public function save_visitor(Request $request)
    {
        
        $new_visit = new Visitor;
        $new_visit->visitor = $request->visitor;
        $new_visit->inmate = $request->inmate;
        $new_visit->contact = $request->contact;
        $new_visit->address = $request->address;
        $new_visit->relationship = $request->relationship;
        $new_visit->status = $request->status;
        $new_visit->Save();
        return redirect('/visitor-info');
    }

    public function View_visitors(Request $request)
    {
        $search = $request ['search'] ?? "";
        if ($search != ""){
            //where
            $visitors = Visitor::where('visitor','LIKE', "%$search%")->paginate(10);
        }else {
            $visitors = Visitor::orderBy("created_at", "asc")->get();
        }
         $visitor= compact('visitors','search');
        return view('visitor')->with($visitor);
    }

    public function generateQRCode($id)
    {
        // Retrieve data from the database
        $visitor = Visitor::findOrFail($id);
    
        // Generate QR code with user data
        $qrCode = QrCode::format('png')->size(200)->generate($visitor->visitor);
    
        // Pass the data to the view for rendering
        $data = [
            'name' => $visitor->visitor,
            'qrCode' => base64_encode($qrCode),
        ];
    
        // Generate the view with the data
        $view = View::make('qr_code_card', $data);
    
        // Convert the view to HTML string
        $html = $view->render();

        
    
        // Use the snappy package to convert HTML to PDF
        $pdf = PDF::loadHTML($html);
        // Set the paper size and orientation
        $pdf->setPaper('letter', 'portrait');
    
        // Generate the PDF file
        //$pdfFile = '/public/pdfDownloads' . time() . '.pdf';
        $pdfFile = storage_path('app/public/pdfDownloads/') . time() . '.pdf';
        $pdf->save($pdfFile);
    
        $pdfContent = $pdf->output();

        // Generate the response with the PDF content
    return response($pdfContent)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'inline; filename="qr_code.pdf"');
    
    }

    public function delete_visitor(Request $request)
    {
        $response = Visitor::find($request->id)->delete();
        return $response;
    }
    
    public function update_visitor($id)
    {
        $update_visitor = Visitor::find($id);
        $inmates = Inmate::all();
        return view('update-visitor', compact('update_visitor','inmates'));
    }
    public function save_update_visitor(Request $request, $id)
    {
        
        $save_visitor = Visitor::find($id);
        $save_visitor->visitor = $request->visitor;
        $save_visitor->inmate = $request->inmate;
        $save_visitor->contact = $request->contact;
        $save_visitor->address = $request->address;
        $save_visitor->relationship = $request->relationship;
        $save_visitor->status = $request->status;
        $save_visitor->Save();
        return redirect('/visitor-info');
    }
    
}
