# Laravel Small Business Template

A reusable Laravel 10 starter template for small business websites. Includes an admin panel with CMS capabilities and a dynamic public frontend.

---

## Modules included

**Admin panel**
- Login / logout with session authentication
- Change password (`/admin/password`)
- Forgot/reset password via email (`/admin/forgot-password`)
- Dashboard with live counts
- Services CRUD (create, edit, toggle active, delete, sort order, pagination)
- Gallery CRUD (image upload + video URL, toggle active, delete, sort order, pagination)
- Page Sections editor (per-page content blocks editable from admin)
- Site Settings (name, tagline, contact info, social links, Google Maps URL)
- Inquiries (list, detail, resend on mail failure)
- Rate limiting on login, password reset, and contact form submission

**Public frontend**
- Home page with dynamic sections (hero, services preview, about, gallery preview, contacts)
- About, Services, Gallery, Contacts pages — all content managed from admin
- Gallery page renders active image and video items from database
- Inquiry / contact form on Contacts page (validates, persists to DB, attempts mail to `contact_email`; admin Inquiries list/show/resend)
- Business action buttons partial (call, email, directions — driven by settings)
- Header and footer driven by settings
- Full SEO head: `<title>`, `meta description`, `og:title`, `og:description`, `og:image`, `canonical`
- Dynamic `sitemap.xml` at `/sitemap.xml`
- `robots.txt` at `/robots.txt` (disallows `/admin`, links to sitemap)
- Cookie consent banner (stores consent in browser cookie, 365 days)
- 404 error page

**Developer conveniences**
- `setting('key', $default)` — global site settings helper
- `page_section('page', 'section')` — CMS content helper
- Both helpers use static request-level caching
- Demo seeders for all content (idempotent — safe to re-run)

---

## Operational documentation (source of truth)

| Doc | Purpose |
|-----|---------|
| [docs/00_PROJECT_CONTEXT.md](docs/00_PROJECT_CONTEXT.md) | Master: stack, entities, rules, definition of done |
| [docs/01_CURSOR_RULES.md](docs/01_CURSOR_RULES.md) | Executor (Cursor) rules |
| [docs/02_TASK_TEMPLATE.md](docs/02_TASK_TEMPLATE.md) | Task template |
| [docs/03_ADMIN_STRUCTURE.md](docs/03_ADMIN_STRUCTURE.md) | Admin modules and responsibilities |
| [docs/04_CORE_SYSTEM.md](docs/04_CORE_SYSTEM.md) | Public system model and content flow |
| [docs/05_DB_ARCHITECTURE.md](docs/05_DB_ARCHITECTURE.md) | Tables and data ownership |

---

## Requirements

- PHP 8.1+
- Laravel 10
- MySQL 5.7+ / MariaDB 10.3+
- Node.js 18+
- Composer 2

---

## Installation

```bash
git clone <repo-url> my-project
cd my-project

cp .env.example .env

composer install

php artisan key:generate
```

Edit `.env` and set at minimum:

```
APP_URL=http://localhost:8000

DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

> **`APP_URL` must be correct.** It is used to generate sitemap URLs, canonical meta tags, and OG URLs.
> On production, set it to your actual domain (`https://yourdomain.com`).

Then:

```bash
php artisan migrate --seed

php artisan storage:link

npm install
npm run build

php artisan serve
```

Site is available at `http://localhost:8000`.

> **`storage:link` is required.** Gallery images are stored in `storage/app/public/gallery/`
> and served via the `public/storage` symlink. Without this command, uploaded images will not display.

---

## Admin credentials (demo)

| | |
|---|---|
| Admin URL | `/admin` |
| Email | `admin@demo.com` |
| Password | `password` |

> **Change both before deploying to production.**
> `AdminUserSeeder` uses `updateOrCreate`, so re-running it will reset the password if the email already exists.

---

## После инсталация — първи стъпки

В правилния ред след `php artisan migrate --seed`:

1. **Влез в admin** на `/admin` с `admin@demo.com` / `password`
2. **Смени admin паролата** преди каквото и да е друго
3. **Admin → Настройки** — обнови `site_name`, `site_tagline`, `contact_phone`, `contact_email`, `address`
4. **Конфигурирай SMTP** в `.env` — задължително, за да работи контактната форма (виж секцията по-долу)
5. **Admin → Услуги** — замени или редактирай 3-те примерни услуги с реални
6. **Admin → Секции** — редактирай текстовете на hero, about, contact и другите секции за конкретния бизнес
7. **Admin → Галерия** *(по желание)* — добави снимки или видео URL-и; gallery секцията на home страницата се появява автоматично щом има поне един активен запис
8. **Admin → Настройки** *(по желание)* — добави `google_maps_url` и URL-и за социалните мрежи

---

## Admin панел — ориентация

| Раздел | Управлява |
|---|---|
| **Настройки** | Глобални данни за сайта: телефон, имейл, адрес, Google Maps, социални мрежи, слоган |
| **Секции** | Текстово съдържание по страница: заглавия, описания, бутони на hero/about/contact и др. |
| **Услуги** | Списъкът с услуги, показван на Services страницата и в preview на home |
| **Галерия** | Снимки (upload) и видео URL-и; показват се на Gallery страницата и в preview на home |

**Настройки ≠ Секции.** Настройките са глобален контакт/идентичност. Секциите са per-page текстово CMS съдържание.

---

## Поведение, което е добре да се знае

**Home gallery preview** се показва само когато има поне един активен gallery елемент. При празна галерия секцията е напълно скрита.

**Action buttons** (Обади се / Изпрати имейл / Намери ни) се рендерират само когато съответната настройка е попълнена (`contact_phone`, `contact_email`, `google_maps_url`). При липсващи и трите настройки бутоните изчезват от CTA блоковете на Services и Gallery страниците.

**Services preview на home** показва максимум 3 активни услуги. Пълният списък е достъпен на Services страницата чрез "Виж всички услуги".

---

## Изисквания за контактната форма

За да работи inquiry формата на Contacts страницата са нужни **и двете** едновременно:

**1. Коректен mail driver в `.env`:**

```
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

**2. Попълнен `contact_email` в Admin → Настройки.**

Запитването се записва в базата; при липсващ получател или грешка при mail статусът остава `received` / `mail_failed` — UI съобщава само, че запитването е **получено**, не че имейлът е доставен.

---

## Преди пускане на живо

**Environment**
- [ ] `APP_ENV=production` и `APP_DEBUG=false` в `.env`
- [ ] `APP_URL` е реалният production URL с `https://` (влияе на sitemap, canonical, OG tags)
- [ ] SSL сертификат е активен

**Build**
- [ ] `php artisan storage:link` е изпълнен на production сървъра
- [ ] `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- [ ] `npm run build` е изпълнен и compiled assets се сервират

**Admin / Settings**
- [ ] Admin паролата е сменена (`/admin/password`) — не е `password`
- [ ] `site_name` и `site_tagline` са обновени
- [ ] `contact_email` е обновен с реален адрес
- [ ] `contact_phone` и `address` са попълнени

**Mail**
- [ ] SMTP е конфигуриран и тестван в `.env`
- [ ] Тест: изпратено реално запитване от Contacts страницата

**Content**
- [ ] Поне една реална услуга е активна
- [ ] Hero секцията е редактирана в Admin → Секции
- [ ] Demo данните са заменени или премахнати

**SEO / Indexing**
- [ ] `/sitemap.xml` е достъпен и съдържа правилните URL-и
- [ ] `/robots.txt` е достъпен и `Sitemap:` реда сочи към коректния домейн
- [ ] Sitemap е submitнат в Google Search Console

---

## Project structure

```
app/
  Http/Controllers/
    Admin/              — AuthController, DashboardController,
                          GalleryController, ServiceController,
                          PageSectionController, SettingController,
                          InquiryController, PasswordController,
                          ForgotPasswordController, ResetPasswordController
    PageController      — home, about, services, gallery, contacts
    InquiryController   — public contact form submission
    SitemapController   — generates /sitemap.xml
  Http/Requests/
    InquiryRequest      — contact form validation rules
    Admin/              — StoreGalleryItemRequest, UpdateGalleryItemRequest
  Mail/
    InquiryMail         — mailable sent to contact_email on inquiry
  Models/               — GalleryItem, Service, PageSection, SiteSetting,
                          Inquiry, User
  Exceptions/Handler    — ThrottleRequestsException → redirect-back with error
  helpers.php           — setting(), page_section(), section_url()
  Support/              — GalleryImageProcessor (admin gallery → WebP)

database/
  migrations/           — page_sections, services, site_settings,
                          gallery_items, inquiries tables
  seeders/              — AdminUserSeeder, ServiceSeeder,
                          PageSectionSeeder, SiteSettingSeeder

resources/views/
  layouts/              — app.blade.php, admin.blade.php
  pages/                — home, about, services, gallery, contacts
  sections/home/        — hero, services-preview, about-preview,
                          gallery-preview, contact-preview
  partials/             — action-buttons (call / email / directions)
  admin/                — dashboard, gallery, services, sections,
                          settings, inquiries, auth (login,
                          forgot-password, reset-password), password
  mail/                 — inquiry.blade.php (plain HTML email)
  components/           — header, footer, cookie-consent
  errors/               — 404.blade.php
  sitemap.blade.php     — XML template for /sitemap.xml
```

---

## Notes for customization

**Rename the site**
Update `site_name` and `site_tagline` in Admin → Settings, or directly in `SiteSettingSeeder`.

**Add a new page section**
1. Add a row to `page_sections` (via seeder or admin)
2. Call `page_section('page', 'section')` in the relevant Blade view

**Add a new setting key**
1. Add the key to `SiteSetting::KEYS` in `app/Models/SiteSetting.php`
2. Add the validation rule in `SettingController::update()`
3. Add the input field in `resources/views/admin/settings/edit.blade.php`

**Gallery images**
Uploaded images are stored at `storage/app/public/gallery/` and served via `public/storage/`.
Run `php artisan storage:link` once after installation (or after re-cloning).
On update or delete, the old file is automatically removed from disk.
