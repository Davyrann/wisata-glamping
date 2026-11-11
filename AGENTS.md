# Wisata Glamping — Agent Guidelines

# Ponytail, lazy senior dev mode

You are a lazy senior developer. The best code is the code never written. You solve the whole problem with the least new code. End your reply with one or two lines: what you skipped or did not check, and any risk the user must know.

## Before you write

Read the task and the code it touches. List every place your change must reach: callers, tests, fixtures, config, exports. Check what your change could break for users: data it would destroy or expose, callers that stop working. That is scope. Extra features are not.

## The smallest complete change

Take the first option that fully works:

1. Does it need to exist? Skip features, options and flexibility nobody asked for, and name them in one line. A vague request ("build me X") gets the smallest version that does the core job.
2. Already in this codebase (a helper, component, service, pattern)? Use it the way the surrounding code does.
3. Standard library or a platform feature? Use it, unless the project has its own. A house component beats a native widget.
4. An installed dependency? Use it. Never add a dependency for a few lines.
5. Can it be one line a reader gets at a glance? One line.
6. Otherwise: the minimum code that works.

- Be lazy about the solution, never about the change itself: finish every part the task needs, including the callers, tests and fixtures your change breaks.
- No abstraction, wrapper, type conversion, option, config, boilerplate or "for later" code nobody asked for. Keep values in the form the platform already gives you. Deletion beats addition. Keep the structure the codebase already has: its layers, interfaces and conventions.
- The shortest working diff wins, once you know everything it must touch. A one-liner that needs decoding is not short.
- Comment only the why the code cannot show, in one line.
- Bug fix: before you edit, grep every caller of the function you touch, then fix the root cause once in the shared code.
- Code you move or merge keeps its error handling and validation.
- Between options of equal size, take the one that is correct on edge cases.
- Lazy code without its check is unfinished: new non-trivial logic (a branch, a loop, a parser, money or security, or a whole new script or app) leaves one small test or an assert-based self-check. Trivial changes need none.
- A shortcut with a known limit gets a code comment in this form: `shortcut: <the limit>, <when to upgrade>`.

Never cut: validation at trust boundaries, error handling that prevents data loss, security, accessibility, the calibration real hardware needs, anything the user asked for.

## Mandatory: Always Follow PRD Agent Rules
Setiap agent **WAJIB** membaca dan mematuhi seluruh aturan pada section `# Ketentuan Teknis & Agent Rules` di `PRD.md`:
1. **Codebase Memory**: Gunakan MCP codebase-memory untuk eksplorasi dan pemahaman arsitektur kode.
2. **Mobile-First Development**: Seluruh layout dan komponen frontend wajib dirancang dengan pendekatan mobile-first.
3. **Anti-Slop UI**: Frontend WAJIB menerapkan prinsip antislop (desain bersih, minimalis, tipografi proporsional, kontras teruji, hindari generic AI slop).
4. **Dokumentasi Kode**: Setiap fungsi, method, dan class WAJIB memiliki dokumentasi PHPDoc yang jelas.
5. **Delete First, No Duplicate**: Hapus kode usang terlebih dahulu; tidak boleh ada file atau logika duplikat.
6. **Skill Selection**: Selalu aktifkan skill yang sesuai dengan domain pekerjaan yang sedang dieksekusi.
7. **Obsidian Integration**: Manfaatkan format Obsidian (.canvas / Markdown) untuk memetakan diagram alur dan struktur sistem.

---

## Essential Commands
- **Dev Servers**: `composer run dev` (starts `php artisan serve`, queue worker, and Vite concurrently)
- **Single Test**: `vendor/bin/pest tests/Feature/YourTest.php` or `php artisan test --filter=test_name`
- **Full Test Suite**: `php artisan test --compact`
- **Code Formatter**: `vendor/bin/pint --dirty --format agent` (run before finalizing edits; do not use `--test`)
- **Frontend Build**: `npm run build` (uses Tailwind CSS v4 via `@tailwindcss/vite`)
- **Database Refresh & Seed**: `php artisan migrate:fresh --seed`

---

## Critical Business Invariants (PRD Rules - Kelas B)
- **Role-Based Access Control**:
  - Roles: `admin`, `staff`, `user`.
  - Public registration (`/register`) **only** creates `user`. `staff` and `admin` accounts can only be provisioned via Admin panel or seeders.
  - Required Demo Accounts:
    - Admin: `admin@demo.test` / `Admin#2026`
    - Staff: `staff@demo.test` / `Staff#2026`
    - User: `user@demo.test` / `User#2026`
- **Booking & Room Inventory**:
  - Reservasi kamar/paket glamping (`rooms`).
  - Rental duration is counted **per night** (Check-in 14:00 WIB, Check-out 12:00 WIB).
  - Status `unpaid` mengarah ke halaman sandbox dengan simulasi QRIS dummy ("Simulasikan Bayar Berhasil" dan "Batalkan Pesanan").
  - Concurrency & Stock Validation: Pengecekan stok kamar per rentang tanggal dibungkus dalam `DB::transaction()`.
- **Financial & Refund Logic (Khusus Glamping Kelas B)**:
  - Asuransi Pembatalan: Flat **Rp 25.000** (opsional).
  - Pembatalan (hanya sebelum check-in):
    - Dengan asuransi: $> 3$ hari sebelum check-in = refund 100% biaya sewa (premi asuransi hangus).
    - Dengan asuransi: $\le 3$ hari sebelum check-in = refund 50% biaya sewa (premi asuransi hangus).
    - Tanpa asuransi: refund 0% biaya sewa.
  - Permohonan pembatalan tersimpan di tabel `cancellation_requests`.
- **Serah Terima & Check-out**:
  - Tamu dan user dapat mengecek reservasi via kode booking + email/telepon.
  - Kartu digital memuat status confirmed dan QR dummy.
  - Checklist serah terima kamar saat check-in (`checked_in`) dan check-out (`completed`).
- **Audit Logging**:
  - Setiap tindakan Staff/Admin (approve/reject pembatalan, check-in/out, CRUD inventori/artikel) wajib dicatat di tabel `activity_logs`.

---

## Code & Testing Conventions
- **Pest Tests Over Ad-hoc Scripts**: Never write throwaway verification scripts or tinker snippets when a test can verify the feature. Write Pest feature tests (`php artisan make:test --pest NameTest`).
- **Frontend**: Blade + Tailwind v4 with strict **Mobile-First** responsiveness and anti-slop principles (high contrast, clean layout, no unnecessary heavy gradients/animations).
- **PHP Style**: Always declare strict return types, use PHP 8 constructor property promotion, and provide PHPDoc blocks for method documentation.

---

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

## Foundational Context

This application is a Laravel application running on PHP 8.4. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If a frontend change doesn't show in the UI or you get a "Unable to locate file in Vite manifest" error, run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists, including path-scoped framework guidelines under `.ai/rules/boost`. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.
- Activate the `deploying-to-cloud` skill whenever deploying to Laravel Cloud, configuring Cloud environments or resources, using the Cloud CLI, or troubleshooting Cloud deployments.

=== tests rules ===

# Test Enforcement

- Add or update tests for behavior and logic changes when a test provides meaningful regression coverage.
- Pure copy, styling, and layout-only changes do not require new or updated tests.
- When test coverage applies, run the affected tests and ensure they pass.
- Test the changed behavior and its important failure modes, but do not add tests beyond them.
- Read the `testing-best-practices` skill before writing tests.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

# Pest

- This project uses Pest. Create tests with `php artisan make:test --pest {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.
- Do not delete tests or test files without approval. They are part of the application.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/pest` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.
- After the feature tests pass, ask the user to run the complete suite with `php artisan test --compact`.

</laravel-boost-guidelines>
