# Deployment Checklist

---

## 1. SERVER SETUP

- [ ] Confirm PHP >= 8.1 (`php -v`)
- [ ] Clone or upload project to server
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] `cp .env.example .env`
- [ ] Set `APP_URL`, `APP_NAME`, `DB_*` in `.env`
- [ ] `php artisan key:generate`
- [ ] Confirm `.env` is not web-accessible (must be outside `public/`)

---

## 2. DATABASE

- [ ] `php artisan migrate`
- [ ] `php artisan db:seed`

---

## 3. STORAGE & BUILD

- [ ] `php artisan storage:link`
- [ ] Set write permissions: `chmod -R 775 storage/ bootstrap/cache/`
- [ ] Run `npm install && npm run build` OR upload pre-built `public/build/` assets
- [ ] Confirm compiled assets exist in `public/build/`

---

## 4. ADMIN SETUP

- [ ] Log in at `/admin/login` with `admin@demo.com` / `password`
- [ ] Change password immediately at `/admin/password`
- [ ] Admin → Settings: fill `site_name`, `site_tagline`, `contact_email`, `contact_phone`, `address`
- [ ] Admin → Settings: fill `google_maps_url` and social URLs if needed

---

## 5. CONTENT SETUP

- [ ] Admin → Sections: update all hero/content blocks for each page
- [ ] Admin → Services: replace demo services with real ones
- [ ] Admin → Gallery: add real images or video URLs (or leave empty)

---

## 6. MAIL TEST

- [ ] Set `MAIL_*` values in `.env`
- [ ] Submit a test inquiry from `/contacts` and confirm email arrives
- [ ] Check spam folder if email not received

---

## 7. FINAL CHECK

- [ ] Upload one gallery image and confirm it loads in the browser
- [ ] `/sitemap.xml` loads and lists correct URLs
- [ ] `/robots.txt` loads and `Sitemap:` line shows correct domain
- [ ] Contact form submits successfully and email is received
- [ ] SSL active, site loads on `https://`

---

## 8. GO-LIVE SWITCH

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
- [ ] Set `APP_URL=https://yourdomain.com` in `.env`
- [ ] `php artisan config:clear && php artisan cache:clear`
- [ ] `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- [ ] Confirm site loads correctly after caching

## STORAGE

- [ ] php artisan storage:link
- [ ] Verify public/storage exists
- [ ] Verify images are accessible via /storage/...

⚠️ IMPORTANT

After installation run:

php artisan storage:link

Otherwise uploaded images will not be accessible.


