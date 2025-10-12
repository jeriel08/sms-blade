# Testing Guide for Student Management System

This guide covers all the tests created for the Student Management System, focusing on **Authentication** and **Enrollment** features.

## 📋 Test Coverage

### 1. Authentication Tests (`tests/Feature/Auth/AuthenticationTest.php`)

-   ✅ Login screen rendering
-   ✅ Successful authentication
-   ✅ Invalid password handling
-   ✅ Invalid email handling
-   ✅ Logout functionality
-   ✅ Redirect authenticated users from login
-   ✅ Validation requirements
-   ✅ Login throttling (rate limiting)
-   ✅ Different user roles login
-   ✅ Remember me functionality

### 2. Enrollment Feature Tests (`tests/Feature/EnrollmentTest.php`)

-   ✅ Access enrollment index and create pages
-   ✅ Multi-step form navigation
-   ✅ Learner information validation
-   ✅ LRN format and uniqueness validation
-   ✅ Address information validation
-   ✅ Guardian information validation
-   ✅ Complete enrollment flow
-   ✅ Transferee enrollment with school step
-   ✅ Assigning grade and section
-   ✅ Enrollment with disabilities
-   ✅ Search functionality
-   ✅ Authorization (settings page access)

### 3. Model Unit Tests

#### Student Model (`tests/Unit/StudentModelTest.php`)

-   ✅ Current address relationship
-   ✅ Permanent address relationship
-   ✅ Family contacts relationship
-   ✅ Enrollments relationship
-   ✅ Disabilities many-to-many relationship
-   ✅ Creating student with all fields
-   ✅ LRN uniqueness constraint
-   ✅ Indigenous people (IP) functionality

#### Enrollment Model (`tests/Unit/EnrollmentModelTest.php`)

-   ✅ Student relationship
-   ✅ Teacher relationship
-   ✅ Section relationship
-   ✅ Creating enrollment with all fields
-   ✅ Transferee additional fields
-   ✅ Default status (Registered)
-   ✅ Status updates

## 🚀 Running Tests

### Run All Tests

```bash
php artisan test
```

### Run Specific Test Suite

```bash
# Run only Feature tests
php artisan test --testsuite=Feature

# Run only Unit tests
php artisan test --testsuite=Unit
```

### Run Specific Test File

```bash
# Authentication tests
php artisan test tests/Feature/Auth/AuthenticationTest.php

# Enrollment tests
php artisan test tests/Feature/EnrollmentTest.php

# Student model tests
php artisan test tests/Unit/StudentModelTest.php

# Enrollment model tests
php artisan test tests/Unit/EnrollmentModelTest.php
```

### Run Specific Test Method

```bash
php artisan test --filter=test_users_can_authenticate_using_the_login_screen
```

### Run Tests with Coverage (requires Xdebug)

```bash
php artisan test --coverage
```

### Run Tests in Parallel (faster)

```bash
php artisan test --parallel
```

## 📁 File Structure

```
tests/
├── Feature/
│   ├── Auth/
│   │   └── AuthenticationTest.php       # Login/Logout tests
│   └── EnrollmentTest.php               # Enrollment flow tests
├── Unit/
│   ├── StudentModelTest.php             # Student model tests
│   └── EnrollmentModelTest.php          # Enrollment model tests
└── TestCase.php                          # Base test case

database/
└── factories/
    ├── StudentFactory.php                # Student test data factory
    ├── AddressFactory.php                # Address test data factory
    └── EnrollmentFactory.php             # Enrollment test data factory
```

## 🏭 Using Factories

Factories make it easy to create test data. Here are some examples:

### Create a Student

```php
$student = Student::factory()->create();
```

### Create a Student with Disability

```php
$student = Student::factory()->withDisability()->create();
```

### Create an Indigenous People Student

```php
$student = Student::factory()->indigenousPeople()->create();
```

### Create an Enrolled Student

```php
$enrollment = Enrollment::factory()->enrolled()->create();
```

### Create a Transferee Enrollment

```php
$enrollment = Enrollment::factory()->transferee()->create();
```

### Create a 4Ps Beneficiary Enrollment

```php
$enrollment = Enrollment::factory()->fourPs()->create();
```

### Create Multiple Records

```php
// Create 10 students
Student::factory()->count(10)->create();

// Create 5 enrollments
Enrollment::factory()->count(5)->create();
```

## 🔧 Test Database Configuration

Tests use SQLite in-memory database (configured in `phpunit.xml`):

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

This means:

-   ✅ Tests run fast (in-memory)
-   ✅ No need to set up a test database
-   ✅ Database is fresh for each test
-   ✅ No cleanup needed

## 📝 Writing New Tests

### Feature Test Example

```php
/** @test */
public function user_can_view_dashboard(): void
{
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get(route('dashboard'));

    $response->assertStatus(200);
    $response->assertViewIs('dashboard');
}
```

### Unit Test Example

```php
/** @test */
public function student_has_full_name_accessor(): void
{
    $student = Student::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
    ]);

    $this->assertEquals('John Doe', $student->full_name);
}
```

## 🐛 Debugging Tests

### Run tests with verbose output

```bash
php artisan test --verbose
```

### Run tests and stop on first failure

```bash
php artisan test --stop-on-failure
```

### Display test errors in detail

```bash
php artisan test --display-errors
```

## ✅ Best Practices

1. **Use Factories** - Create test data easily and consistently
2. **Use RefreshDatabase** - Ensures clean database state for each test
3. **One Assertion per Test** - Makes tests easier to understand and debug
4. **Descriptive Test Names** - Use clear, descriptive method names
5. **Test Edge Cases** - Don't just test the happy path
6. **Keep Tests Fast** - Use in-memory database and minimize external dependencies

## 📊 Test Results

When you run tests, you'll see output like:

```
   PASS  Tests\Feature\Auth\AuthenticationTest
  ✓ login screen can be rendered
  ✓ users can authenticate using the login screen
  ✓ users can not authenticate with invalid password
  ...

   PASS  Tests\Feature\EnrollmentTest
  ✓ enrollment index page can be accessed
  ✓ enrollment create page can be accessed
  ...

  Tests:    42 passed (98 assertions)
  Duration: 2.34s
```

## 🎯 Next Steps

To add more test coverage, consider testing:

-   **Advisory System** - Teacher advisory page and student management
-   **Student CRUD** - Create, Read, Update, Delete operations
-   **Section Management** - Section sync and management
-   **Search & Filtering** - Test search and sort functionality
-   **Authorization** - Role-based access control

## 🆘 Troubleshooting

### "Class not found" errors

```bash
composer dump-autoload
```

### Database migrations not running

Make sure migrations are up to date:

```bash
php artisan migrate:fresh
```

### Factory errors

Make sure factory files are in the correct namespace:

```php
namespace Database\Factories;
```

---

\*\*Happy
