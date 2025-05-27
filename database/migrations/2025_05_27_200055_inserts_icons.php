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
        $icons = [
            'fas fa-user',
            'fas fa-calendar-alt',
            'fas fa-money-bill-wave',
            'fas fa-users',
            'fas fa-university',
            'fas fa-home',
            'fas fa-bolt',
            'fas fa-utensils',
            'fas fa-bus-alt',
            'fas fa-heartbeat',
            'fas fa-wifi',
            'fas fa-graduation-cap',
            'fas fa-coins',
            'fas fa-percent',
            'fas fa-flag-checkered',
            'fas fa-gamepad',
            'fas fa-tools',
            'fas fa-spa',
            'fas fa-shopping-bag',
            'fas fa-plane-departure',
            'fas fa-paw',
            'fas fa-file-invoice-dollar',
            'fas fa-piggy-bank',
            'fas fa-briefcase',
            'fas fa-laptop-code',
            'fas fa-gift',
            'fas fa-trophy',
            'fas fa-tags',
            'fas fa-ellipsis-h',
            'fas fa-plus',
            'fas fa-car',
            'fas fa-stethoscope',
            'fas fa-book',
            'fas fa-gas-pump',
            'fas fa-lightbulb',
            'fas fa-tree',
            'fas fa-child',
            'fas fa-globe',
            'fas fa-lock',
            'fas fa-hand-holding-usd',
            'fas fa-exchange-alt',
            'fas fa-shield-alt',
        ];

        $now = now();

        foreach ($icons as $icon) {
            DB::table('icons')->insert([
                'icon' => '<i class="' . $icon . '"></i>',
                'enabled' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down()
    {
        $icons = [
            'fas fa-user',
            'fas fa-calendar-alt',
            'fas fa-money-bill-wave',
            'fas fa-users',
            'fas fa-university',
            'fas fa-home',
            'fas fa-bolt',
            'fas fa-utensils',
            'fas fa-bus-alt',
            'fas fa-heartbeat',
            'fas fa-wifi',
            'fas fa-graduation-cap',
            'fas fa-coins',
            'fas fa-percent',
            'fas fa-flag-checkered',
            'fas fa-gamepad',
            'fas fa-tools',
            'fas fa-spa',
            'fas fa-shopping-bag',
            'fas fa-plane-departure',
            'fas fa-paw',
            'fas fa-file-invoice-dollar',
            'fas fa-piggy-bank',
            'fas fa-briefcase',
            'fas fa-laptop-code',
            'fas fa-gift',
            'fas fa-trophy',
            'fas fa-tags',
            'fas fa-ellipsis-h',
            'fas fa-plus',
            'fas fa-car',
            'fas fa-stethoscope',
            'fas fa-book',
            'fas fa-gas-pump',
            'fas fa-lightbulb',
            'fas fa-tree',
            'fas fa-child',
            'fas fa-globe',
            'fas fa-lock',
            'fas fa-hand-holding-usd',
            'fas fa-exchange-alt',
            'fas fa-shield-alt',
        ];

        foreach ($icons as $icon) {
            DB::table('icons')->where('icon', '<i class="' . $icon . '"></i>')->delete();
        }
    }

};
