# Admin structure

## Purpose

Admin is the **content operator UI**: edit site-wide settings, page copy, services, gallery, and review inquiries **without** deploying Blade changes for routine text/list updates.

**Access:** `/admin/login` (session auth). Password change, forgot/reset flows live under `/admin/…`.

---

## Current modules

### Dashboard

- Entry point; links/summary to other modules.

### Settings (`SiteSetting`)

- Edit keys in `SiteSetting::KEYS` (site name, tagline, contacts, social URLs, `google_maps_url`, etc.).  
- **Not** long-form page copy (that is Sections).

### Sections (`PageSection`)

- List by page; **edit/update only** (no create/destroy via resource — rows come from seeders/migrations).  
- Controls hero/preview-style blocks per `page` + `section`.

### Services

- Full list CRUD (no `show` route): create, edit, delete, **sort_order**, **is_active** toggle, pagination.

### Gallery

- List with type filter; create/edit image (WebP pipeline) or video URL; **toggle** active; **delete**; sort order; pagination.  
- File storage: `public` disk, `gallery/` prefix; symlink required for public URLs.

### Inquiries

- Paginated **list** with status filter (`all` / `received` / `notified` / `mail_failed`).  
- **Show** full record (message, mail error, `notified_at`).  
- **Resend** mail only when status is `mail_failed` (sync mail).  
- **No** admin delete/archive in current implementation.

### Account / security (supporting)

- Logout; change password; forgot/reset password (email).  
- Rate limits on login, password reset, and public contact POST (see app config/routes).

---

## Allowed actions (by area)

| Module | Create | Read list | Read one | Update | Delete | Sort | Toggle active |
|--------|--------|-----------|----------|--------|--------|------|---------------|
| Settings | — | — | — | ✓ | — | — | — |
| Sections | — | ✓ | — | ✓ | — | — | — |
| Services | ✓ | ✓ | — | ✓ | ✓ | ✓ | ✓ |
| Gallery | ✓ | ✓ | — | ✓ | ✓ | ✓ | ✓ |
| Inquiries | — | ✓ | ✓ | — (resend only) | — | — | — |

---

## Admin UX principles

- One module = one responsibility.  
- **Settings ≠ Sections** (global identity/contact vs per-page CMS text).  
- Prefer **obvious labels** and **flash feedback** (success/error) over silent state.

---

## Rules for new admin modules

1. Add routes under `admin` + `auth` middleware unless explicitly public.  
2. Use Form Requests for non-trivial validation.  
3. Document the module in **this file** and **`05_DB_ARCHITECTURE.md`** if new tables appear.  
4. Avoid duplicating keys already in `SiteSetting::KEYS` unless justified.
