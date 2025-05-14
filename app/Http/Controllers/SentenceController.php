<?php

namespace App\Http\Controllers;

use App\Models\Sentence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SentenceController extends Controller
{

    public static function listSentences(): View {
        $data = Sentence::getSentence();

        return view('admin.sentences.sentences')->with('sentences', $data);
    }

    public static function addSentence(string $text): RedirectResponse {
        if (!Sentence::addSentence($text)) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
                ->back()
                ->with('success', 'Frase añadida correctamente.');
    }

    public static function editSentence(array $data): RedirectResponse {
        if (!Sentence::editSentence($data)) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
                ->back()
                ->with('success', 'Frase editada correctamente.');
    }

    public static function deleteSentence(array $data): JsonResponse {
        if (!Sentence::deleteSentence($data['id'])) {
            return response()->json(['error' => 'Ha habido un error inesperado.']);
        }

        return response()->json(['success' => 'Frase borrada correctamente.']);
    }
    
}
