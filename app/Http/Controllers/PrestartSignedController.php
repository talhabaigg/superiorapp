<?php

namespace App\Http\Controllers;

use App\Models\Prestart;
use Illuminate\Http\Request;
use App\Models\PrestartAbsent;
use App\Models\PrestartSigned;

class PrestartSignedController extends Controller
{
    public function save(Request $request)
{
    $validated = $this->validateRequest($request);

    $message = $this->handlePdfUpload($validated['prestart_id'], $request);

    $this->updateRecords($validated['prestart_id'], $validated['signatures']);

    return redirect()->route('daily-prestarts.index')->with('success', $message);
}

private function validateRequest(Request $request)
{
    return $request->validate([
        'signatures' => 'required|array',
        'prestart_id' => 'required|integer|exists:prestarts,id',
        'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
    ]);
}

private function handlePdfUpload($prestartId, Request $request)
{
    if ($request->hasFile('pdf_file')) {
        $prestart = Prestart::findOrFail($prestartId);
        $path = $request->file('pdf_file')->store('prestart_pdfs', 'public');
        $prestart->pdf_path = $path;
        $prestart->save();
        return "Signatures and PDF uploaded successfully.";
    }
    return "Signatures uploaded successfully.";
}

private function updateRecords($prestartId, array $signatures)
{
    $existingSigned = PrestartSigned::where('prestart_id', $prestartId)->get()->keyBy('user_id');
    $existingAbsent = PrestartAbsent::where('prestart_id', $prestartId)->get()->keyBy('user_id');

    foreach ($signatures as $userId => $status) {
        if ($status === 'sick' || $status === 'other') {
            PrestartAbsent::updateOrCreate(
                ['user_id' => $userId, 'prestart_id' => $prestartId],
                ['status' => $status]
            );
            $existingAbsent->forget($userId);
        } else {
            PrestartSigned::updateOrCreate(
                ['user_id' => $userId, 'prestart_id' => $prestartId],
                ['status' => $status]
            );
            $existingSigned->forget($userId);
        }
    }

    $this->deleteOldRecords($prestartId, $existingSigned, $existingAbsent);
}

private function deleteOldRecords($prestartId, $existingSigned, $existingAbsent)
{
    PrestartSigned::where('prestart_id', $prestartId)
        ->whereIn('user_id', $existingSigned->keys())
        ->delete();

    PrestartAbsent::where('prestart_id', $prestartId)
        ->whereIn('user_id', $existingAbsent->keys())
        ->delete();
}

}
