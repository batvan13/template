# Template System Architecture

## View Structure

resources/views/

layouts/
app.blade.php
admin.blade.php

components/
header.blade.php
footer.blade.php
hero.blade.php
section-title.blade.php
contact-form.blade.php
google-map.blade.php

sections/
home/
hero.blade.php
services.blade.php
about-preview.blade.php
gallery-preview.blade.php
contact-preview.blade.php

pages/
home.blade.php
about.blade.php
services.blade.php
gallery.blade.php
contacts.blade.php

admin/
dashboard.blade.php

## Principles

layouts
Base page structure.

components
Reusable UI elements.

sections
Page-specific sections.

pages
Assemble sections into complete pages.

admin
Admin panel views.
