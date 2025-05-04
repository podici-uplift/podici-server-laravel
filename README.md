# 💻 Podici Server

The laravel codebase for the reinvented Podici Server.

| ![Podici Logo](public/images/logos/dark-logo.png) | ![Podici Logo](public/images/logos/dark-secondary-logo.png) | ![Podici Logo](public/images/logos/original.png) | ![Podici Logo](public/images/logos/light-logo.png) | ![Podici Logo](public/images/logos/light-secondary-logo.png) |
| ------------------------------------------------- | ----------------------------------------------------------- | ------------------------------------------------ | -------------------------------------------------- | ------------------------------------------------------------ |

<!--
| Logos     |                                                             |                                                              |
| --------- | ----------------------------------------------------------- | ------------------------------------------------------------ |
| Primary   | ![Podici Logo](public/images/logos/dark-logo.png)           | ![Podici Logo](public/images/logos/light-logo.png)           |
| Secondary | ![Podici Logo](public/images/logos/dark-secondary-logo.png) | ![Podici Logo](public/images/logos/light-secondary-logo.png) |
-->


## Features

### Authentication & Authorisation
- User registration (email/phone, optional password)
- User login & logout
- Vendor registration (with role-based access)
- Email/phone verification
- JWT-based authentication
- Middleware for protected routes
- Age verification logic (for adult content)

### User Management
- View and edit profile (user/vendor)
- View public vendor profiles
- Account deletion/deactivation
- KYC submission for vendors
- Admin review of KYC (optional in MVP)

### Shop Management
- Create/Edit/Delete shop (one per vendor)
- View shop listings (public + filtered by status)
- Upload shop logo/cover
- Mark shop as adult-only (age-restricted)
- Assign KYC-verified badge

### Product Management
- Add/Edit/Delete product
- Upload product images
- Mark product as adult content
- Product listing (public)
- Tagging/Categorisation
- Visibility toggle (draft/published)

### Search & Discovery
- Full-text product search
- Shop/product filters (category, verified, adult)
- Sorting (recent, popular)
- Featured vendors/products (basic flag system)

### Reviews & Ratings
- Post one comment/review per product or shop
- Star rating (1–5)
- View average rating and comments
- Edit/delete own comment

### Reporting & Moderation
- Report shop or product (spam, scam, adult, etc.)
- Auto-flag after threshold
- Admin moderation dashboard (simple interface or endpoint for now)
- Suspend, flag or ban shop/user/product

### Analytics (for Vendors)
- Number of views per product
- Number of profile visits
- Basic engagement stats (likes, saves)

### Favourites & Interactions
- Add/remove product to favourites
- View favourited products
- Contact vendor via displayed contact methods

### Notification System (Optional for MVP)
- Email notifications (on review, report, ban, KYC result, etc.)
- Push/Realtime notifications (can be postponed)

### Admin Module (Internal Use)
- View all users/vendors
- View flagged content
- Suspend/ban/reactivate accounts
- Manage categories/tags
