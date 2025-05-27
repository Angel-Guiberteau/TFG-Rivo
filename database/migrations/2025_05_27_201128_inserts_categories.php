<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $now = now();

        $categories = [
            [1, 'Salario', 23],
            [2, 'Ayuda familiar', 4],
            [3, 'Ayuda del estado', 5],
            [4, 'Gastos de la casa', 6],
            [5, 'Luz, agua, gas....', 7],
            [6, 'Alimentación', 8],
            [7, 'Transporte', 30],
            [8, 'Salud', 31],
            [9, 'Telefonía', 11],
            [10, 'Educacion', 32],
            [11, 'otros gastos', 28],
            [12, 'Ahorro general', 22],
            [13, 'ocio', 16],
            [14, 'Imprevistos', 13],
            [15, 'Cuidado personal', 18],
            [16, 'compras (Ropa, tecnología...)', 19],
            [17, 'Viaje', 20],
            [18, 'Mascota', 21],
            [19, 'Deudas', 40],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->insert([
                'id' => $cat[0],
                'name' => $cat[1],
                'icon_id' => $cat[2],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $relations = [
            [1, 1, 1], [2, 1, 2], [3, 1, 3],
            [4, 2, 4], [5, 2, 5], [6, 2, 6], [7, 2, 7], [8, 2, 8],
            [9, 2, 9], [10, 2, 10], [11, 2, 11], [12, 3, 12],
            [13, 2, 13], [14, 2, 14], [15, 2, 15], [16, 2, 16],
            [17, 2, 17], [18, 2, 18], [19, 2, 19], [20, 3, 19],
        ];

        foreach ($relations as $rel) {
            DB::table('movements_types_categories')->insert([
                'id' => $rel[0],
                'movement_type_id' => $rel[1],
                'category_id' => $rel[2],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach (range(1, 19) as $id) {
            DB::table('base_categories')->insert([
                'id' => $id,
                'categories_id' => $id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down()
    {
        DB::table('base_categories')->whereIn('id', range(1, 19))->delete();
        DB::table('movements_types_categories')->whereIn('id', range(1, 20))->delete();
        DB::table('categories')->whereIn('id', range(1, 19))->delete();
    }
};
