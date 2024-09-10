<?php

namespace App\Http\Controllers;

use App\Models\Prestart;
use Illuminate\Http\Request;
use App\Models\PrestartSigned;

class PrestartSignedController extends Controller
{
    public function save(Request $request)
    {
        // Validate the incoming data, including the PDF file
        $validated = $request->validate([
            'signatures' => 'required|array',
            'prestart_id' => 'required|integer|exists:prestarts,id',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240', // Optional PDF upload, max size 10MB
        ]);
        $message = "Signatures uploaded successfully.";
        // Save the PDF file if it exists
        if ($request->hasFile('pdf_file')) {
            $prestart = Prestart::findOrFail($validated['prestart_id']);
            
            // Save the file to storage
            $path = $request->file('pdf_file')->store('prestart_pdfs', 'public');
            
            // Update the `pdf_path` field in the Prestart model
            $prestart->pdf_path = $path;
            $prestart->save();
            $message = "Signatures and PDF uploaded successfully.";
        }

        // Save the signatures
        foreach ($validated['signatures'] as $userId => $status) {
            PrestartSigned::updateOrCreate(
                [
                    'user_id' => $userId,
                    'prestart_id' => $validated['prestart_id'],
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return redirect()->route('daily-prestarts.index')->with('success', $message);
    }
}
