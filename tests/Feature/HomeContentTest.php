<?php

namespace Tests\Feature;

use App\Filament\Pages\HeroContent;
use App\Models\HomeSection;
use App\Models\User;
use App\Support\HomeContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HomeContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_uses_saved_section_content(): void
    {
        $hero = HomeContent::section('hero');
        $hero['subtitle'] = 'عنوان تجريبي من لوحة الإدارة';
        HomeContent::save('hero', $hero);

        $this->get('/')
            ->assertOk()
            ->assertSee('عنوان تجريبي من لوحة الإدارة');

        $this->assertDatabaseHas(HomeSection::class, ['section' => 'hero']);
    }

    public function test_admin_content_pages_are_available_to_authenticated_users(): void
    {
        $this->actingAs(User::factory()->create());

        foreach ([
            '/admin/site-identity',
            '/admin/hero-content',
            '/admin/about-content',
            '/admin/tracks-content',
            '/admin/timeline-content',
            '/admin/prizes-rules-content',
            '/admin/faq-content',
            '/admin/registration-content',
            '/admin/footer-content',
        ] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_admin_can_save_a_homepage_section(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(HeroContent::class)
            ->set('data.subtitle', 'عنوان محفوظ من Filament')
            ->callAction('save')
            ->assertHasNoErrors();

        $this->assertSame('عنوان محفوظ من Filament', HomeContent::get('hero.subtitle'));
    }
}
