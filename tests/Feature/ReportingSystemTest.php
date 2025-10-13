<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportingSystemTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'role' => 'Principal'
        ]);
    }

    /** @test */
    public function it_can_display_reports_page()
    {
        $response = $this->actingAs($this->user)
                         ->get('/reports');

        $response->assertStatus(200)
                 ->assertViewIs('reports.index')
                 ->assertViewHas('reportType')
                 ->assertViewHas('reportData')
                 ->assertViewHas('totalRecords');
    }

    /** @test */
    public function it_can_generate_enrollment_reports()
    {
        $student = Student::factory()->create();
        Enrollment::factory()->create([
            'student_id' => $student->student_id,
            'school_year' => '2025-2026',
            'grade_level' => '7'
        ]);

        $response = $this->actingAs($this->user)
                         ->get('/reports?report_type=enrollment&school_year=2025-2026&grade_level=7');

        $response->assertStatus(200)
                 ->assertViewHas('reportData')
                 ->assertViewHas('totalRecords', 1);
    }

    /** @test */
    public function it_can_generate_student_reports()
    {
        Student::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
                         ->get('/reports?report_type=students&school_year=2025-2026');

        $response->assertStatus(200)
                 ->assertViewHas('totalRecords', 3);
    }

    /** @test */
    public function it_can_generate_teacher_reports()
    {
        Teacher::factory()->count(2)->create();

        $response = $this->actingAs($this->user)
                         ->get('/reports?report_type=teachers');

        $response->assertStatus(200)
                 ->assertViewHas('totalRecords', 2);
    }

    /** @test */
    public function it_can_generate_section_reports()
    {
        Section::factory()->create(['grade_level' => '7']);
        Section::factory()->create(['grade_level' => '8']);

        $response = $this->actingAs($this->user)
                         ->get('/reports?report_type=sections&grade_level=7');

        $response->assertStatus(200)
                 ->assertViewHas('totalRecords', 1);
    }

    /** @test */
    public function it_can_export_reports_to_excel()
    {
        Student::factory()->create();
        
        $response = $this->actingAs($this->user)
                         ->get('/reports/export?report_type=students&format=excel');

        $response->assertStatus(200)
                 ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function it_can_get_sections_by_grade_level()
    {
        Section::factory()->create(['grade_level' => '7', 'name' => 'Section A']);
        Section::factory()->create(['grade_level' => '7', 'name' => 'Section B']);

        $response = $this->actingAs($this->user)
                         ->get('/reports/sections-by-grade?grade_level=7');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }
}