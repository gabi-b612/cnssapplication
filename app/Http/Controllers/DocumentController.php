<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    public function show(Demande $demande, int $index): Response
    {
        $this->authorizeAccess($demande);

        $documents = $demande->documents ?? [];

        if (!array_key_exists($index, $documents)) {
            abort(404);
        }

        $path = $documents[$index];

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $filename = basename($path);

        return Storage::disk('public')->response($path, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    private function authorizeAccess(Demande $demande): void
    {
        if (auth('administrateur')->check()) {
            return;
        }

        if (auth('apf')->check()) {
            return;
        }

        if (auth('entreprise')->check() && auth('entreprise')->id() === $demande->entreprise_id) {
            return;
        }

        if (auth('travailleur')->check() && auth('travailleur')->id() === $demande->travailleur_id) {
            return;
        }

        abort(403);
    }
}
