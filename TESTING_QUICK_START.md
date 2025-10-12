# Quick Start: Running Your First Tests 🚀

This guide will help you run your tests in **5 minutes or less**!

## Step 1: Verify PHPUnit Installation ✅

Check if PHPUnit is installed:

```bash
php artisan test --help
```

If you see the help menu, you're good to go! If not, install it:

```bash
composer require --dev phpunit/phpunit
```

## Step 2: Create the Test Files 📁

Create the following directories and files:

### Directory Structure

```bash
mkdir -p tests/Feature/Auth
mkdir -p tests/Unit
mkdir -p database/factories
```

### Create Test Files

1. **tests/Feature/Auth/AuthenticationTest.php** - Copy the Authentication test code
2. **tests/Feature/EnrollmentTest.php** - Copy the Enrollment test code
3. **tests/Unit/StudentModelTest.php** - Copy the Student model test code
4. **tests/Unit/EnrollmentModelTest.php** - Copy the Enrollment model test code

### Create Factory Files

1. **database/factories/StudentFactory.php** - Copy the Student factory code
2. **database/factories/AddressFactory.php** - Copy the Address factory code
3. **database/factories/EnrollmentFactory.php** - Copy the Enrollment factory code

## Step 3: Run Your First Test 🎯

### Run all tests:

```bash
php artisan test
```

Expected output:

```
   PASS  Tests\Feature\Auth\AuthenticationTest
  ✓ login screen can be rendered                0.15s
  ✓ users can authenticate using the login screen  0.08s
  ...

   PASS  Tests\Feature\EnrollmentTest
  ✓ enrollment index page can be accessed       0.12s
  ...

  Tests:    42 passed (98 assertions)
  Duration: 3.45s
```

### Run only Authentication tests:

```bash
php artisan test tests/Feature/Auth/AuthenticationTest.php
```

### Run only one specific test:

```bash
php artisan test --filter=test_users_can_authenticate_using_the_login_screen
```

## Step 4: Understand the Test Output 📊

### ✅ Green (PASS) - Test passed successfully

```
PASS  Tests\Feature\Auth\AuthenticationTest
✓ users can authenticate using the login screen
```

### ❌ Red (FAIL) - Test failed

```
FAIL  Tests\Feature\Auth\AuthenticationTest
✗ users can authenticate using the login screen

  Expected status code 200 but received 500.
```

### ⚠️ Yellow (WARNING) - Risky or incomplete test

```
WARN  Tests\Feature\Auth\AuthenticationTest
⚠ test has no assertions
```

## Step 5: Fix Common Issues 🔧

### Issue 1: "Class not found"

**Solution:**

```bash
composer dump-autoload
```

### Issue 2: "Database table doesn't exist"

**Solution:**

```bash
php artisan migrate:fresh --env=testing
```

### Issue 3: "Factory not found"

**Solution:**
Make sure your factory has the correct namespace:

```php
namespace Database\Factories;
```

### Issue 4: Tests are slow

**Solution:**
Use SQLite in-memory database (already configured in `phpunit.xml`)

## Step 6: Write Your First Test ✍️

Let's create a simple test for the dashboard:

**tests/Feature/DashboardTest.php:**

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_users_can_access_dashboard(): void
    {
        // Arrange: Create a user
        $user = User::factory()->create();

        // Act: Access the dashboard as that user
        $response = $this->actingAs($user)->get('/dashboard');

        // Assert: Check if successful
        $response->assertStatus(200);
        $response->assertSee('DASHBOARD');
    }

    /** @test */
    public function guests_cannot_access_dashboard(): void
    {
        // Act: Try to access dashboard without login
        $response = $this->get('/dashboard');

        // Assert: Should redirect to login
        $response->assertRedirect('/login');
    }
}
```

Run it:

```bash
php artisan test tests/Feature/DashboardTest.php
```

## Step 7: Understanding Test Anatomy 🔍

Every test follows the **AAA Pattern**:

```php
/** @test */
public function test_description(): void
{
    // ARRANGE: Set up test data
    $user = User::factory()->create();

    // ACT: Perform the action
    $response = $this->actingAs($user)->get('/dashboard');

    // ASSERT: Verify the result
    $response->assertStatus(200);
}
```

## Cheat Sheet: Most Common Commands 📝

```bash
# Run all tests
php artisan test

# Run tests with coverage
php artisan test --coverage

# Run specific test file
php artisan test tests/Feature/EnrollmentTest.php

# Run specific test method
php artisan test --filter=test_method_name

# Run tests in parallel (faster)
php artisan test --parallel

# Stop on first failure
php artisan test --stop-on-failure

# Show detailed output
php artisan test --verbose
```

## Cheat Sheet: Common Assertions 📋

```php
// Response Assertions
$response->assertStatus(200);           // Success
$response->assertRedirect('/dashboard'); // Redirects
$response->assertSee('Text');           // Contains text
$response->assertViewIs('view.name');   // Uses view

// Database Assertions
$this->assertDatabaseHas('students', ['lrn' => '123']);
$this->assertDatabaseCount('enrollments', 5);

// Authentication Assertions
$this->assertAuthenticated();
$this->assertGuest();

// Session Assertions
$response->assertSessionHas('success');
$response->assertSessionHasErrors(['email']);
```

## Next Steps 🎓

Now that you know the basics:

1. ✅ Run all the tests to see current coverage
2. ✅ Read through test examples to understand patterns
3. ✅ Try modifying a test and see it fail/pass
4. ✅ Write a simple test for a new feature
5. ✅ Read the full [TESTING_README.md](TESTING_README.md) for advanced topics

## Getting Help 💬

If you're stuck:

1. Read the error message carefully
2. Check if migrations are up to date
3. Verify factory files exist and are correct
4. Look at similar tests that work
5. Search Laravel documentation: https://laravel.com/docs/testing

---

**You're all set! Happy testing! 🎉**

Remember: **Good tests = Confident code!**
