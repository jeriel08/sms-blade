<?php

namespace Tests\Unit;

use App\Models\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function setting_can_be_created(): void
    {
        $setting = Settings::create([
            'key' => 'school_year',
            'value' => '2024-2025',
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'school_year',
            'value' => '2024-2025',
        ]);
    }

    /** @test */
    public function setting_key_must_be_unique(): void
    {
        Settings::create([
            'key' => 'school_year',
            'value' => '2024-2025',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Settings::create([
            'key' => 'school_year',
            'value' => '2025-2026',
        ]);
    }

    /** @test */
    public function setting_can_be_updated(): void
    {
        $setting = Settings::create([
            'key' => 'school_year',
            'value' => '2024-2025',
        ]);

        $setting->update(['value' => '2025-2026']);

        $this->assertEquals('2025-2026', $setting->fresh()->value);
    }

    /** @test */
    public function setting_can_be_retrieved_by_key(): void
    {
        Settings::create([
            'key' => 'school_year',
            'value' => '2024-2025',
        ]);

        $value = Settings::where('key', 'school_year')->value('value');

        $this->assertEquals('2024-2025', $value);
    }

    /** @test */
    public function multiple_settings_can_exist(): void
    {
        Settings::create(['key' => 'school_year', 'value' => '2024-2025']);
        Settings::create(['key' => 'school_name', 'value' => 'Test School']);
        Settings::create(['key' => 'principal_name', 'value' => 'John Doe']);

        $this->assertEquals(3, Settings::count());
    }

    /** @test */
    public function setting_value_can_be_null(): void
    {
        $setting = Settings::create([
            'key' => 'optional_setting',
            'value' => null,
        ]);

        $this->assertNull($setting->value);
    }

    /** @test */
    public function setting_can_store_long_text(): void
    {
        $longText = str_repeat('This is a long text. ', 100);

        $setting = Settings::create([
            'key' => 'long_setting',
            'value' => $longText,
        ]);

        $this->assertEquals($longText, $setting->value);
    }

    /** @test */
    public function setting_can_be_deleted(): void
    {
        $setting = Settings::create([
            'key' => 'temp_setting',
            'value' => 'temporary',
        ]);

        $setting->delete();

        $this->assertDatabaseMissing('settings', [
            'key' => 'temp_setting',
        ]);
    }
}