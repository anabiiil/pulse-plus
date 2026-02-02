# Website Vue Application Setup

This document explains the setup of a separate Vue.js application for the website frontend, alongside the existing dashboard application.

## Architecture Overview

The project now has **two separate Vue applications**:

1. **Dashboard Application** (`/dash/*` routes)
   - Entry: `resources/js/app.js`
   - Router: `resources/js/main/router.ts`
   - Components: `resources/js/components/dashboard/`
   - View: `resources/views/dash/pages/index.blade.php`

2. **Website Application** (all other routes)
   - Entry: `resources/js/website.js`
   - Router: `resources/js/website/router.ts`
   - Components: `resources/js/components/website/`
   - View: `resources/views/website/index.blade.php`

## File Structure

```
resources/
├── js/
│   ├── app.js                    # Dashboard entry point
│   ├── website.js                # Website entry point (NEW)
│   ├── main/
│   │   └── router.ts            # Dashboard router
│   ├── website/                  # Website application (NEW)
│   │   └── router.ts            # Website router
│   └── components/
│       ├── dashboard/           # Dashboard components
│       └── website/             # Website components (NEW)
│           ├── Layout.vue       # Website layout with navbar & footer
│           └── pages/
│               ├── Home.vue
│               ├── About.vue
│               ├── Services.vue
│               ├── ServiceDetail.vue
│               ├── Products.vue
│               ├── ProductDetail.vue
│               ├── Contact.vue
│               └── NotFound.vue
└── views/
    ├── dash/                    # Dashboard views
    └── website/                 # Website views (NEW)
        └── index.blade.php
```

## Routes Configuration

### Web Routes (`routes/web.php`)

```php
// Dashboard routes (protected)
Route::group(['prefix' => 'dash', 'middleware' => 'checkAdmin'], function () {
    Route::get('/{any?}', function () {
        return view('dash.pages.index');
    })->where('any', '.*');
});

// Website routes (all other routes)
Route::get('/{any?}', function () {
    return view('website.index');
})->where('any', '^(?!dash).*$');
```

### Website Vue Routes

- `/` - Home page
- `/about` - About page
- `/services` - Services listing
- `/services/:id` - Service detail
- `/products` - Products listing
- `/products/:id` - Product detail
- `/contact` - Contact form
- `*` (404) - Not found page

## Vite Configuration

Updated `vite.config.js` to include both entry points:

```javascript
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',      // Dashboard
                'resources/js/website.js'    // Website (NEW)
            ],
            refresh: true,
        }),
        vue(),
    ],
    // ...
});
```

## Components

### Website Layout (`Layout.vue`)

Includes:
- Responsive navigation bar with mobile menu
- Router view for page content
- Footer with links and contact info

### Website Pages

All pages include:
- Vue Composition API (`<script setup>`)
- Vuetify components
- SEO meta tags with `useHead`
- Responsive design
- Loading states
- Error handling

## Development Workflow

### Starting Development Server

```bash
npm run dev
```

This will watch both `app.js` (dashboard) and `website.js` (website) for changes.

### Building for Production

```bash
npm run build
```

## API Integration

The website pages make API calls to fetch data:

- **Services**: `GET /api/services`
- **Service Detail**: `GET /api/services/{id}`
- **Products**: `GET /api/products`
- **Product Detail**: `GET /api/products/{id}`
- **Contact Form**: `POST /api/contact`

Make sure these API endpoints are configured in your `routes/api.php`.

## Styling

The website uses:
- **Vuetify 3** for UI components
- **Tailwind CSS** for utility classes (if needed)
- **Scoped styles** in Vue components

## Key Features

1. **Separate Vue Apps**: Dashboard and website are completely isolated
2. **Vue Router**: Client-side routing for SPA experience
3. **Vuetify**: Material Design UI components
4. **Pinia**: State management (ready to use)
5. **Vue Toastification**: Toast notifications
6. **@vueuse/head**: SEO meta tags management
7. **Responsive**: Mobile-friendly navigation
8. **Lazy Loading**: Components loaded on demand

## Customization

### Adding New Pages

1. Create component in `resources/js/components/website/pages/`
2. Add route in `resources/js/website/router.ts`
3. Add navigation link in `Layout.vue` if needed

### Modifying Layout

Edit `resources/js/components/website/Layout.vue` to:
- Change header/footer design
- Update navigation links
- Add/remove sections

### Changing Theme

Modify Vuetify theme in `resources/js/website.js`:

```javascript
const vuetify = createVuetify({
    theme: {
        defaultTheme: 'light',
        themes: {
            light: {
                colors: {
                    primary: '#1976D2',
                    secondary: '#424242',
                    // ...
                }
            }
        }
    }
});
```

## Next Steps

1. **Create API endpoints** for services, products, and contact form
2. **Add authentication** if needed (login, register)
3. **Implement search** functionality
4. **Add blog** or news section
5. **Configure SEO** meta tags per page
6. **Add analytics** tracking
7. **Optimize images** and assets
8. **Set up caching** for API responses

## Testing

Access the website at:
- **Website**: `http://your-domain.com/`
- **Dashboard**: `http://your-domain.com/dash`

Make sure to test:
- Navigation between pages
- Mobile responsiveness
- API data loading
- Form submissions
- 404 pages

## Troubleshooting

### White screen on load
- Check browser console for errors
- Verify Vite dev server is running
- Check `@vite` directive in blade files

### Routes not working
- Clear Laravel route cache: `php artisan route:clear`
- Check web.php route order

### Components not loading
- Verify file paths in router
- Check component file names match imports

### Styling issues
- Ensure Vuetify styles are imported
- Check for CSS conflicts
- Verify Tailwind config if using
