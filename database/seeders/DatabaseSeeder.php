<?php

namespace Database\Seeders;

use App\Models\Plano;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@imoveis.ao'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // ── Planos (preços em AOA) ─────────────────────────────────────────────
        $planos = [
            [
                'nome'           => 'Básico',
                'slug'           => 'basico',
                'descricao'      => 'Ideal para quem está a começar. Publique 1 imóvel.',
                'preco'          => 2500.00,
                'duracao_dias'   => 30,
                'limite_imoveis' => 1,
                'ativo'          => true,
                'ordem'          => 1,
            ],
            [
                'nome'           => 'Profissional',
                'slug'           => 'profissional',
                'descricao'      => 'Para agentes imobiliários. Publique até 10 imóveis.',
                'preco'          => 7500.00,
                'duracao_dias'   => 30,
                'limite_imoveis' => 10,
                'ativo'          => true,
                'ordem'          => 2,
            ],
            [
                'nome'           => 'Empresarial',
                'slug'           => 'empresarial',
                'descricao'      => 'Para imobiliárias. Imóveis ilimitados.',
                'preco'          => 20000.00,
                'duracao_dias'   => 30,
                'limite_imoveis' => 0, // 0 = ilimitado
                'ativo'          => true,
                'ordem'          => 3,
            ],
        ];

        foreach ($planos as $plano) {
            Plano::updateOrCreate(['slug' => $plano['slug']], $plano);
        }

        $this->command->info('✅ Admin e planos criados com sucesso!');
    }
}
