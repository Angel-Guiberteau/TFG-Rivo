<?php

namespace App\Http\Controllers;

use App\Models\Sentence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controlador SentenceController
 *
 * Gestiona las frases motivacionales que se muestran en la aplicación.
 */
class SentenceController extends Controller
{
    /**
     * Muestra la vista con todas las frases habilitadas.
     *
     * @return View Vista con el listado de frases.
     */
    public static function listSentences(): View {
        $data = Sentence::getAllSentencesEnabled();
        return view('admin.sentences.sentences')->with('sentences', $data);
    }

    /**
     * Devuelve el número total de frases registradas.
     *
     * @return int Número de frases.
     */
    public static function numberOfSentences(): int {
        return Sentence::numberOfSentences();
    }

    /**
     * Añade una nueva frase al sistema si los datos son válidos.
     *
     * @param array $data Datos validados para la frase.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
    public static function addSentence(array $data): RedirectResponse {
        if (!$data['status']) {
            return redirect()
                ->back()
                ->with('error', $data['error']);
        }

        if (!Sentence::addSentence($data['data']['name'])) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
            ->back()
            ->with('success', 'Frase añadida correctamente.');
    }

    /**
     * Edita una frase existente si los datos son válidos.
     *
     * @param array $data Datos de la frase editada.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
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

    /**
     * Elimina una frase por su ID si los datos son válidos.
     *
     * @param array $data Datos que contienen el ID de la frase a eliminar.
     * @return RedirectResponse Redirección con mensaje de éxito o error.
     */
    public static function deleteSentence(array $data): RedirectResponse {
        if (!$data['status']) {
            return redirect()
                ->back()
                ->with('error', $data['error']);
        }

        if (!Sentence::deleteSentence($data['data']['id'])) {
            return redirect()
                ->back()
                ->with('error', 'Ha habido un error inesperado.');
        }

        return redirect()
            ->back()
            ->with('success', 'Frase borrada correctamente.');
    }
}
