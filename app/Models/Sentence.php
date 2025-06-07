<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Modelo Sentence
 *
 * Representa una frase motivacional u oración utilizada en la aplicación.
 */
class Sentence extends Model
{
    /** @var string $table Nombre de la tabla asociada al modelo */
    protected $table = 'sentences';

    /** @var array $fillable Campos que se pueden asignar masivamente */
    protected $fillable = [ 'text', 'enabled' ];

    /**
     * Obtiene todas las frases habilitadas.
     *
     * @return Collection
     */
    public static function getAllSentencesEnabled(): Collection {
        $sentence = new self();

        return $sentence->select('id', 'text')
                        ->where('enabled', 1)
                        ->get();
    }

    /**
     * Cuenta el número de frases habilitadas.
     *
     * @return int
     */
    public static function numberOfSentences(): int {
        return self::where('enabled', 1)
                    ->count();
    }

    /**
     * Añade una nueva frase.
     *
     * @param string $text Texto de la frase.
     * @return bool
     */
    public static function addSentence(string $text): bool {
        $sentence = new self();

        $sentence->text = $text;
        $sentence->enabled = 1;

        return $sentence->save();
    }

    /**
     * Edita una frase existente.
     *
     * @param array $data Datos con 'id' y 'text'.
     * @return bool
     */
    public static function editSentence(array $data): bool {
        $sentence = self::find($data['id']);

        if ($sentence) {
            return $sentence->update(
                [
                    'text' => $data['text'],
                ]
            );
        }

        return false;
    }

    /**
     * Elimina lógicamente una frase (desactiva).
     *
     * @param int $id ID de la frase.
     * @return bool
     */
    public static function deleteSentence(int $id): bool {
        $sentence = self::find($id);

        if ($sentence) {
            $sentence->enabled = 0;
            return $sentence->save();
        }

        return false;
    }
}
