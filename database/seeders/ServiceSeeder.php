<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Консултация',
                'short_description' => 'Безплатна първоначална консултация за вашия проект.',
                'full_description' => 'Провеждаме подробна консултация, за да разберем нуждите ви и да предложим най-подходящото решение.',
                'icon' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Изпълнение',
                'short_description' => 'Качествено изпълнение в договорен срок.',
                'full_description' => 'Нашият екип изпълнява всеки проект с внимание към детайла и спазване на уговорените срокове.',
                'icon' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Поддръжка',
                'short_description' => 'Следпродажбена поддръжка и гаранция.',
                'full_description' => 'Предлагаме пълна поддръжка след изпълнението на проекта, включително гаранционно обслужване.',
                'icon' => null,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($services as $service) {
            $slug = Str::slug($service['title']);

            Service::updateOrCreate(
                [
                    'slug' => $slug,
                ],
                [
                    'title' => $service['title'],
                    'short_description' => $service['short_description'],
                    'full_description' => $service['full_description'],
                    'icon' => $service['icon'],
                    'is_active' => $service['is_active'],
                    'sort_order' => $service['sort_order'],
                ]
            );
        }
    }
}
