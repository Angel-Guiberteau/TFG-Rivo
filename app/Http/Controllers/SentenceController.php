<?php

namespace App\Http\Controllers;

use App\Models\Sentence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SentenceController extends Controller
{

    public static function listSentences(): View {
        $data = Sentence::getAllSentencesEnabled();

        return view('admin.sentences.sentences')->with('sentences', $data);
    }

    public static function addSentence(array $data): RedirectResponse {
        if (!$data['status']) { 
            return redirect()
                ->back()
                ->with('error', $data['error']);
        }
        
        if (!Sentence::addSentence($data['data']['text'])) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
                ->back()
                ->with('success', 'Frase añadida correctamente.');
    }

    public static function editSentence(array $data): RedirectResponse {
        if (!$data['status']) {
            return redirect()
                ->back()
                ->with('error', $data['error']);
        }

        if (!Sentence::editSentence($data['data'])) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
                ->back()
                ->with('success', 'Frase editada correctamente.');
    }

    public static function deleteSentence(array $data): JsonResponse {
        if (!$data['status']) {
            return response()->json(['error' => $data['error']]);
        }

        if (!Sentence::deleteSentence($data['data']['id'])) {
            return response()->json(['error' => 'Ha habido un error inesperado.']);
        }

        return response()->json(['success' => 'Frase borrada correctamente.']);
    }
    
}
