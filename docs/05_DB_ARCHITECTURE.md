# Database architecture

## Core tables

### `site_settings`

- **Owns:** global key/value pairs (`SiteSetting::KEYS`).  
- **Used for:** branding, contacts, social URLs, `google_maps_url`.  
- **CRUD:** update via admin Settings only (no arbitrary keys without code change).

### `page_sections`

- **Owns:** CMS blocks keyed by `page` + `section` (title, subtitle, content, button fields, etc.).  
- **CRUD:** read/update via admin Sections; rows typically seeded.  
- **Rule:** long page copy lives here, not in `site_settings`.

### `services`

- **Owns:** service list (title, slug, short/full description, optional `icon`, `sort_order`, `is_active`).  
- **CRUD:** full admin CRUD + toggle; public reads **active** only, ordered.

### `gallery_items`

- **Owns:** gallery entries (`type` image/video), `image_path`, `video_url`, title, `sort_order`, `is_active`.  
- **CRUD:** admin CRUD + toggle; public reads **active** only, ordered.  
- **Files:** image files on `public` disk; DB stores **relative** path (e.g. `gallery/{uuid}.webp`).

### `inquiries`

- **Owns:** contact form submissions (name, email, phone, message, `status`, `mail_error`, `notified_at`).  
- **Statuses:** `received`, `notified`, `mail_failed`.  
- **CRUD:** insert on public submit; admin **read** + **resend** only (no delete column/flow in current app).  
- **Rule:** record is created **before** mail attempt; failures update status/error without dropping the row.

### `users`

- **Owns:** admin login accounts (default seeder demo user).

### Other framework tables

- `password_reset_tokens`, `failed_jobs`, `personal_access_tokens` — Laravel defaults; not CMS content.

---

## Data ownership rules

- **One row type = one table.** Do not duplicate gallery paths in `page_sections`.  
- **`SiteSetting::KEYS`** is the single authority for setting keys in code.  
- **Inquiries** are the audit trail for contact form; mail is not the source of truth.

---

## CRUD expectations (summary)

| Table | Public write | Admin |
|-------|--------------|--------|
| site_settings | — | Update |
| page_sections | — | Update |
| services | — | Full |
| gallery_items | — | Full |
| inquiries | Insert (form) | List / show / resend |

---

## Rules for future tables

1. Migration + model + document here and in `03_ADMIN_STRUCTURE.md`.  
2. Prefer explicit status enums/strings as **constants** on the model.  
3. File-backed fields: store **disk + relative path**; document symlink requirement if under `public` disk.
