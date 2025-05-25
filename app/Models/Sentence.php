<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Sentence extends Model
{
    protected $table = 'sentences';
    protected $fillable = [ 'text', 'enabled' ];

    public static function getAllSentencesEnabled(): Collection {
        $sentence = new self();
        
        return $sentence->select('id', 'text')
                        ->where('enabled', 1)
                        ->get();
    }

    public static function addSentence(string $text): bool {
        $sentence = new self();

        $sentence->text = $text;
        $sentence->enabled = 1;

        return $sentence->save();
    }

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

    public static function deleteSentence(int $id): bool {
        $sentence = self::find($id);

        if ($sentence) {
            $sentence->enabled = 0;
            return $sentence->save();
        }

        return false;
    }
}
