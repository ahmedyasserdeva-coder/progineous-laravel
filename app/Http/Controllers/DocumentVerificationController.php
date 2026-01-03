<?php

namespace App\Http\Controllers;

use App\Models\VerifiedDocument;
use Illuminate\Http\Request;

class DocumentVerificationController extends Controller
{
    /**
     * Show verification page for a document
     */
    public function show(string $documentId)
    {
        $document = VerifiedDocument::where('document_id', $documentId)->first();
        
        return view('verify.show', [
            'document' => $document,
            'documentId' => $documentId,
        ]);
    }

    /**
     * Verify document by uploading PDF (AJAX)
     */
    public function verifyByFile(Request $request, string $documentId)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf|max:10240',
        ]);

        try {
            $file = $request->file('document');
            $content = file_get_contents($file->getRealPath());
            $uploadedHash = hash('sha256', $content);

            $document = VerifiedDocument::where('document_id', $documentId)
                ->where('document_hash', $uploadedHash)
                ->first();

            if ($document) {
                return response()->json([
                    'success' => true,
                    'verified' => true,
                    'message' => __('crm.document_verified_success'),
                    'document' => [
                        'document_id' => $document->document_id,
                        'generated_at' => $document->generated_at->format('Y-m-d H:i:s'),
                        'client_name' => $document->metadata['client_name'] ?? null,
                        'total_invoiced' => $document->total_invoiced,
                        'balance' => $document->balance,
                    ]
                ]);
            } else {
                // Check if document ID exists but hash doesn't match
                $existingDoc = VerifiedDocument::where('document_id', $documentId)->first();
                
                if ($existingDoc) {
                    return response()->json([
                        'success' => true,
                        'verified' => false,
                        'message' => __('crm.document_hash_mismatch'),
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'verified' => false,
                    'message' => __('crm.document_not_verified'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
