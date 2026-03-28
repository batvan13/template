# Core system

## System model

**Page → Sections (+ dynamic lists)**  

- **Pages** are fixed routes (`/`, `/about`, `/services`, `/gallery`, `/contacts`).  
- **Sections** are `PageSection` rows (`page` + `section` + content fields).  
- **Lists** are `Service` and `GalleryItem` collections (queried in controllers or previews).

---

## Static vs dynamic

| Kind | Source | Examples |
|------|--------|----------|
| **Static (CMS text)** | `PageSection` + `setting()` for globals | Hero copy, about body, contact hero, legal-ish blocks |
| **Dynamic lists** | DB models | Services grid, gallery items, home previews |

---

## Public pages

| Route (name) | Controller | Main data |
|----------------|------------|-----------|
| `/` `home` | `PageController@home` | Section partials + services/gallery previews |
| `/about` | `PageController@about` | Sections for about |
| `/services` | `PageController@services` | Sections + active `Service` |
| `/gallery` | `PageController@gallery` | Section hero + active `GalleryItem` |
| `/contacts` | `PageController@contacts` | Sections + settings-driven contact block + inquiry form |

**Cross-cutting:** `layouts.app` (SEO sections, header/footer from settings), cookie consent component, `POST /contact` → `InquiryController@submit`.

---

## Shared frontend logic

- **Header/footer:** `contact_email`, `contact_phone`, nav links.  
- **Action buttons partial:** shows call / email / directions only when matching settings exist.  
- **Home previews:** services preview caps at **3** active services; gallery preview shows only if there is **at least one** renderable gallery item (per current Blade rules).  
- **SEO:** per-page Blade sections + defaults from `site_name` / `site_tagline`; `sitemap.xml`, `robots.txt`.

---

## Page / section naming (operational)

- **Home composition (intent):** intro/CTA → services preview (link to full list) → about teaser → gallery teaser → contact teaser; **footer** global.  
- **Section keys (examples):** `home.hero`, `home.services_preview`, `home.about_preview`, `home.gallery_preview`, `home.contact_preview`; page-level `hero`/`content` on about, services, gallery, contacts.  
- **Naming rule:** `page` matches route purpose (`home`, `about`, `services`, `gallery`, `contacts`); `section` is lowercase snake or consistent with seeders.

---

## Admin → frontend flow

1. Operator edits **Settings** / **Sections** / **Services** / **Gallery** / sees **Inquiries**.  
2. Public pages read the same DB on next request (no static build step for content).  
3. **Inquiry** submissions always **persist**; mail is secondary (see `Inquiry` statuses).

---

## Rules for extending

- New **public page** → route + `PageController` method + Blade under `pages/`; document in task + update this section.  
- New **section** → migration/seeder or admin Sections editor + `page_section()` in view.  
- New **global field** → add to `SiteSetting::KEYS`, `SettingController` rules, settings Blade, then use `setting()`.
