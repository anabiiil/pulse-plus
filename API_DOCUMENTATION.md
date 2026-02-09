# Website API Documentation

## Overview

This document describes all backend API endpoints created for the website frontend.

## Base URL

```
/api/website
```

All endpoints are prefixed with `/api/website` and return JSON responses.

## Response Format

### Success Response

```json
{
    "data": {
        // Response data here
    }
}
```

### Paginated Response

```json
{
    "data": [
        // Array of items
    ],
    "meta": {
        "current_page": 1,
        "per_page": 12,
        "total": 50,
        "last_page": 5
    },
    "links": {
        "first": "...",
        "last": "...",
        "prev": null,
        "next": "..."
    }
}
```

### Error Response

```json
{
    "errors": {
        "field_name": ["Error message"]
    }
}
```

## Endpoints

### Services

#### Get All Services

```
GET /api/website/services
```

**Query Parameters:**
- `per_page` (optional, default: 12) - Number of items per page
- `search` (optional) - Search by service name
- `limit` (optional) - Return limited number of services (overrides pagination)

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Medical Consultation",
            "description": "Professional medical consultation...",
            "image_url": "https://example.com/storage/services/1.jpg",
            "status": "active",
            "created_at": "2024-01-15 10:30:00",
            "updated_at": "2024-01-15 10:30:00"
        }
    ]
}
```

**Example Usage:**
```javascript
// Get all services (paginated)
const response = await axios.get('/api/website/services');

// Get services with search
const response = await axios.get('/api/website/services?search=medical');

// Get limited number of services (for homepage)
const response = await axios.get('/api/website/services?limit=3');
```

#### Get Single Service

```
GET /api/website/services/{id}
```

**Parameters:**
- `id` (required) - Service ID

**Response:**
```json
{
    "data": {
        "id": 1,
        "name": "Medical Consultation",
        "description": "Detailed description...",
        "image_url": "https://example.com/storage/services/1.jpg",
        "status": "active",
        "created_at": "2024-01-15 10:30:00",
        "updated_at": "2024-01-15 10:30:00"
    }
}
```

**Status Codes:**
- `200` - Success
- `404` - Service not found

---

### Products

#### Get All Products

```
GET /api/website/products
```

**Query Parameters:**
- `per_page` (optional, default: 12) - Number of items per page
- `search` (optional) - Search by product name
- `limit` (optional) - Return limited number of products (overrides pagination)

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Medical Device X",
            "description": "High-quality medical device...",
            "image_url": "https://example.com/storage/products/1.jpg",
            "status": "active",
            "created_at": "2024-01-15 10:30:00",
            "updated_at": "2024-01-15 10:30:00"
        }
    ]
}
```

**Example Usage:**
```javascript
// Get all products (paginated)
const response = await axios.get('/api/website/products');

// Get products with search
const response = await axios.get('/api/website/products?search=device');

// Get 10 products per page
const response = await axios.get('/api/website/products?per_page=10');
```

#### Get Single Product

```
GET /api/website/products/{id}
```

**Parameters:**
- `id` (required) - Product ID

**Response:**
```json
{
    "data": {
        "id": 1,
        "name": "Medical Device X",
        "description": "Detailed description...",
        "image_url": "https://example.com/storage/products/1.jpg",
        "status": "active",
        "created_at": "2024-01-15 10:30:00",
        "updated_at": "2024-01-15 10:30:00"
    }
}
```

**Status Codes:**
- `200` - Success
- `404` - Product not found

---

### Sliders

#### Get All Sliders

```
GET /api/website/sliders
```

**Query Parameters:** None

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Welcome to Pulse",
            "description": "Your health is our priority",
            "image_url": "https://example.com/storage/sliders/1.jpg",
            "link": "/services",
            "status": "active",
            "created_at": "2024-01-15 10:30:00"
        }
    ]
}
```

**Example Usage:**
```javascript
const response = await axios.get('/api/website/sliders');
```

#### Get Single Slider

```
GET /api/website/sliders/{id}
```

**Parameters:**
- `id` (required) - Slider ID

**Response:**
```json
{
    "data": {
        "id": 1,
        "title": "Welcome to Pulse",
        "description": "Your health is our priority",
        "image_url": "https://example.com/storage/sliders/1.jpg",
        "link": "/services",
        "status": "active",
        "created_at": "2024-01-15 10:30:00"
    }
}
```

**Status Codes:**
- `200` - Success
- `404` - Slider not found

---

### Contact Form

#### Submit Contact Form

```
POST /api/website/contact
```

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "message": "I would like to inquire about..."
}
```

**Validation Rules:**
- `name` - Required, string, max 255 characters
- `email` - Required, valid email, max 255 characters
- `phone` - Optional, string, max 20 characters
- `message` - Required, string, max 1000 characters

**Success Response (201):**
```json
{
    "data": {
        "message": "Thank you for contacting us! We will get back to you soon."
    }
}
```

**Error Response (422):**
```json
{
    "errors": {
        "email": ["The email field is required."],
        "message": ["The message field is required."]
    }
}
```

**Example Usage:**
```javascript
const formData = {
    name: 'John Doe',
    email: 'john@example.com',
    phone: '+1234567890',
    message: 'I would like to inquire about your services'
};

const response = await axios.post('/api/website/contact', formData);
```

**Status Codes:**
- `201` - Contact form submitted successfully
- `422` - Validation error

---

## File Structure

### Controllers

```
app/Http/Controllers/Api/Website/
├── ServiceController.php
├── ProductController.php
├── SliderController.php
└── ContactController.php
```

### Resources (API Transformers)

```
app/Http/Resources/Website/
├── ServiceResource.php
├── ProductResource.php
└── SliderResource.php
```

### Routes

```
routes/api.php
```

---

## Features

### Implemented Features

✅ **Services API**
- List all active services with pagination
- Search services by name
- Get single service details
- Limit results for homepage

✅ **Products API**
- List all active products with pagination
- Search products by name
- Get single product details
- Limit results for homepage

✅ **Sliders API**
- List all active sliders
- Get single slider details

✅ **Contact Form API**
- Submit contact form with validation
- Email validation
- Error handling

### Security Features

✅ **Only Active Items** - API only returns items with `status = active`
✅ **Input Validation** - All inputs validated before processing
✅ **CSRF Protection** - Protected by Laravel's CSRF middleware
✅ **SQL Injection Prevention** - Eloquent ORM prevents SQL injection
✅ **XSS Protection** - Output escaped in resources

---

## Common Query Parameters

### Pagination

```
GET /api/website/services?per_page=20
```

Default: 12 items per page

### Search

```
GET /api/website/services?search=medical
```

Searches in the `name` field (case-insensitive)

### Limit (No Pagination)

```
GET /api/website/services?limit=5
```

Returns specified number of items without pagination

---

## Error Handling

### 404 Not Found

```json
{
    "message": "No query results for model..."
}
```

### 422 Validation Error

```json
{
    "errors": {
        "field_name": ["Error message"]
    }
}
```

### 500 Server Error

```json
{
    "message": "Server Error"
}
```

---

## Testing the API

### Using cURL

```bash
# Get all services
curl -X GET http://localhost:8000/api/website/services

# Get single service
curl -X GET http://localhost:8000/api/website/services/1

# Submit contact form
curl -X POST http://localhost:8000/api/website/contact \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "message": "Test message"
  }'
```

### Using Postman

1. Import the collection or create new requests
2. Set base URL: `http://localhost:8000/api/website`
3. Test each endpoint with different parameters

### Using Browser

Navigate to:
- `http://localhost:8000/api/website/services`
- `http://localhost:8000/api/website/products`
- `http://localhost:8000/api/website/sliders`

---

## Next Steps / Enhancements

### Recommended Additions

- [ ] **Rate Limiting** - Prevent API abuse
- [ ] **Caching** - Cache service/product listings
- [ ] **API Versioning** - Add version prefix (v1, v2)
- [ ] **Filtering** - Add more filter options (category, price, etc.)
- [ ] **Sorting** - Add sorting by different fields
- [ ] **Search Enhancement** - Full-text search in description
- [ ] **Email Notifications** - Send emails on contact form submission
- [ ] **Database Storage** - Store contact form submissions in database
- [ ] **Analytics** - Track API usage and popular items
- [ ] **Related Items** - Add related products/services endpoints

### Contact Form Enhancements

1. **Store in Database**
```php
// Create Contact model and migration
Contact::create($data);
```

2. **Send Email Notification**
```php
Mail::to(config('mail.from.address'))
    ->send(new ContactFormMail($data));
```

3. **Add reCAPTCHA**
```php
// Validate reCAPTCHA token
'g-recaptcha-response' => 'required|recaptcha'
```

---

## Performance Tips

1. **Enable Caching**
```php
Cache::remember('active_services', 3600, function () {
    return Service::where('status', StatusEnum::ACTIVE)->get();
});
```

2. **Eager Loading**
```php
Service::with('category')->where('status', StatusEnum::ACTIVE)->get();
```

3. **Database Indexing**
```sql
ALTER TABLE services ADD INDEX idx_status (status);
ALTER TABLE services ADD INDEX idx_name (name);
```

---

## Support

For questions or issues with the API:
- Check Laravel logs: `storage/logs/laravel.log`
- Enable debug mode in `.env`: `APP_DEBUG=true`
- Use `php artisan route:list` to see all routes
- Clear cache: `php artisan optimize:clear`
