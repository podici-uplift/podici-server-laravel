<?php

namespace Database\Seeders;

use App\Objects\CategoryObject;
use Database\Seeders\Traits\WithCategorySeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithCategorySeeder;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedCategories([
            ...$this->automotive(),
            ...$this->babyKidsToys(),
            ...$this->beautyPersonalCare(),
            ...$this->booksStationery(),
            ...$this->businessServices(),
            ...$this->electronicsGadgets(),
            ...$this->fashion(),
            ...$this->foodDrinks(),
            ...$this->giftOccasions(),
            ...$this->handmadeCrafts(),
            ...$this->healthWellness(),
            ...$this->homeLiving(),
            ...$this->mediaPhotography(),
            ...$this->pets(),
            ...$this->phoneAccessories(),
            ...$this->spiritualReligious(),
        ]);
    }

    protected function automotive(): array
    {
        return [
            CategoryObject::make('Automotive', 'Automotive parts, accessories, and services'),

            CategoryObject::make('Car Accessories', 'Seat covers, mats, phone holders, and more', 'automotive'),
            CategoryObject::make('Car Parts', 'Engines, batteries, filters, and other components', 'automotive'),
            CategoryObject::make('Motorcycle Accessories', 'Helmets, gloves, and riding gear', 'automotive'),
            CategoryObject::make('Tyres & Wheels', 'Tyres, rims, and wheel accessories', 'automotive'),
            CategoryObject::make('Vehicle Electronics', 'Car stereos, GPS, dashcams, and alarms', 'automotive'),
            CategoryObject::make('Car Care', 'Cleaning supplies, wax, and detailing kits', 'automotive'),
            CategoryObject::make('Oils & Fluids', 'Engine oil, brake fluid, coolant, and more', 'automotive'),
            CategoryObject::make('Car Services', 'Repairs, maintenance, and installation services', 'automotive'),
            CategoryObject::make('Vehicles for Sale', 'Listings for cars, motorcycles, and more', 'automotive'),
        ];
    }

    protected function babyKidsToys(): array
    {
        return [
            CategoryObject::make('Baby, Kids & Toys', 'Everything for babies, children, and fun learning'),

            CategoryObject::make('Baby Clothing', 'Apparel for newborns and toddlers including onesies, mittens, caps', 'baby-kids-toys'),
            CategoryObject::make('Baby Gear', 'Strollers, carriers, baby seats, and other baby equipment', 'baby-kids-toys'),
            CategoryObject::make('Feeding', 'Feeding bottles, bibs, sterilizers, and breastfeeding items', 'baby-kids-toys'),
            CategoryObject::make('Diapering', 'Diapers, wipes, changing mats, and diaper bags', 'baby-kids-toys'),
            CategoryObject::make('Nursery', 'Cribs, bedding, furniture, and baby room décor', 'baby-kids-toys'),
            CategoryObject::make('Toys', 'Educational toys, puzzles, stuffed animals, and playsets', 'baby-kids-toys'),
            CategoryObject::make('Kids Clothing', 'Shirts, dresses, trousers, and seasonal wear for children', 'baby-kids-toys'),
            CategoryObject::make('School Supplies', 'Bags, lunchboxes, books, and writing materials', 'baby-kids-toys'),
            CategoryObject::make('Safety & Health', 'Baby monitors, thermometers, first aid, and childproofing', 'baby-kids-toys'),
        ];
    }

    protected function beautyPersonalCare(): array
    {
        return [
            CategoryObject::make('Beauty & Personal Care', 'Products and services that enhance appearance and hygiene'),

            CategoryObject::make('Skincare', 'Creams, oils, and products for healthy skin', 'beauty-personal-care'),
            CategoryObject::make('Makeup', 'Beauty products for enhancing facial features', 'beauty-personal-care'),
            CategoryObject::make('Haircare', 'Shampoos, wigs, weaves, and styling products', 'beauty-personal-care'),
            CategoryObject::make('Fragrances', 'Perfumes, body sprays, and colognes for men and women', 'beauty-personal-care'),
            CategoryObject::make('Bath & Body', 'Soaps, scrubs, body lotions, and wash essentials', 'beauty-personal-care'),
            CategoryObject::make('Oral Care', 'Toothpaste, mouthwash, and other dental hygiene products', 'beauty-personal-care'),
            CategoryObject::make("Men's Grooming", 'Shaving kits, beard oils, and male beauty products', 'beauty-personal-care'),
            CategoryObject::make('Feminine Care', 'Sanitary and hygiene products for women', 'beauty-personal-care'),
            CategoryObject::make('Beauty Tools & Accessories', 'Brushes, mirrors, and cosmetic tools', 'beauty-personal-care'),
            CategoryObject::make('Spa & Relaxation', 'Essential oils, massage tools, and self-care items', 'beauty-personal-care'),
        ];
    }

    protected function booksStationery(): array
    {
        return [
            CategoryObject::make('Books & Stationery', 'Educational materials, office supplies, and creative essentials'),

            CategoryObject::make('Educational Books', 'Textbooks, academic materials, and study guides', 'books-stationery'),
            CategoryObject::make('Fiction & Literature', 'Novels, poetry, short stories, and classic literature', 'books-stationery'),
            CategoryObject::make("Children's Books", 'Picture books, storybooks, and early learning materials', 'books-stationery'),
            CategoryObject::make('Religious Books', 'Holy books, devotionals, and faith-based literature', 'books-stationery'),
            CategoryObject::make('Professional & Self-help', 'Career guides, business, finance, and self-development books', 'books-stationery'),
            CategoryObject::make('Notebooks & Writing Pads', 'Journals, diaries, writing pads, and memo books', 'books-stationery'),
            CategoryObject::make('Pens & Pencils', 'Ballpoints, markers, highlighters, and drawing pencils', 'books-stationery'),
            CategoryObject::make('Art & Craft Supplies', 'Drawing paper, paint, brushes, glue, scissors, and tools', 'books-stationery'),
            CategoryObject::make('Office Supplies', 'Files, folders, staplers, calculators, and desk tools', 'books-stationery'),
            CategoryObject::make('Educational Aids', 'Charts, whiteboards, flashcards, and learning kits', 'books-stationery'),
        ];
    }

    protected function businessServices(): array
    {
        return [
            CategoryObject::make('Business Services', 'Professional services tailored to support individuals and small businesses'),

            CategoryObject::make('Printing Services', 'Business cards, flyers, banners, and more', 'business-services'),
            CategoryObject::make('Graphic Design', 'Logos, branding, promotional materials', 'business-services'),
            CategoryObject::make('Photography & Videography', 'Event coverage, product shoots, and more', 'business-services'),
            CategoryObject::make('Digital Marketing', 'Social media management, ad campaigns, SEO', 'business-services'),
            CategoryObject::make('Web Development', 'Website creation, landing pages, and e-commerce', 'business-services'),
            CategoryObject::make('Branding Services', 'Naming, strategy, tone, and visual identity', 'business-services'),
            CategoryObject::make('Event Planning', 'Coordinating and managing personal and corporate events', 'business-services'),
            CategoryObject::make('Business Consultancy', 'Advice on strategy, growth, and operations', 'business-services'),
        ];
    }

    protected function electronicsGadgets(): array
    {
        return [
            CategoryObject::make('Electronics & Gadgets', 'Consumer electronics, gadgets, and household devices'),

            CategoryObject::make('Televisions', 'Smart TVs, LED, LCD and Plasma screens', 'electronics-gadgets'),
            CategoryObject::make('Home Audio', 'Speakers, soundbars, and home theatre systems', 'electronics-gadgets'),
            CategoryObject::make('Cameras', 'Digital cameras, DSLRs, mirrorless, and action cams', 'electronics-gadgets'),
            CategoryObject::make('Drones', 'Consumer drones for photography, videography, and fun', 'electronics-gadgets'),
            CategoryObject::make('Gaming Consoles', 'PlayStation, Xbox, Nintendo and handhelds', 'electronics-gadgets'),
            CategoryObject::make('Gaming Accessories', 'Controllers, VR headsets, gamepads and other gear', 'electronics-gadgets'),
            CategoryObject::make('Computers & Laptops', 'Desktops, laptops, and related electronics', 'electronics-gadgets'),
            CategoryObject::make('Monitors & Projectors', 'Display monitors and portable or home projectors', 'electronics-gadgets'),
            CategoryObject::make('Batteries & Power Solutions', 'Rechargeable and disposable batteries, UPS and inverters', 'electronics-gadgets'),
            CategoryObject::make('Smart Home Devices', 'IoT gadgets like smart bulbs, plugs, and thermostats', 'electronics-gadgets'),
            CategoryObject::make('Calculators', 'Scientific, financial, and regular calculators', 'electronics-gadgets'),
        ];
    }

    protected function fashion(): array
    {
        return [
            CategoryObject::make('Fashion', 'Clothing and accessories for all genders and ages'),

            CategoryObject::make("Men's Wears", 'Stylish outfits for men, including native and casual', 'fashion'),
            CategoryObject::make("Women's Wears", 'Trendy outfits for ladies, from casual to traditional', 'fashion'),
            CategoryObject::make("Kids' Fashion", 'Clothing and accessories for children and toddlers', 'fashion'),
            CategoryObject::make('Footwear', 'Shoes, sandals, and slippers for all ages and genders', 'fashion'),
            CategoryObject::make('Native Wears', 'Traditional and cultural outfits made by local tailors', 'fashion'),
            CategoryObject::make('Streetwear', 'Urban clothing and trendy fashion pieces', 'fashion'),
            CategoryObject::make('Lingerie & Underwear', 'Intimates and undergarments for comfort and style', 'fashion'),
            CategoryObject::make('Maternity Fashion', 'Clothing designed specifically for pregnant women', 'fashion'),
            CategoryObject::make('Bags & Purses', 'Handbags, purses, and clutches for men and women', 'fashion'),
            CategoryObject::make('Fashion Accessories', 'Belts, scarves, and other clothing add-ons', 'fashion'),
            CategoryObject::make('Watches & Jewellery', 'Timepieces, bracelets, necklaces, and rings', 'fashion'),
            CategoryObject::make('Eyewear & Sunglasses', 'Sunglasses and prescription glasses with style', 'fashion'),
            CategoryObject::make('Caps & Headwear', 'Caps, hats, and fashion-forward headgear', 'fashion'),
        ];
    }

    protected function foodDrinks(): array
    {
        return [
            CategoryObject::make('Food & Drinks', 'Groceries, beverages, snacks, and everyday edibles'),

            CategoryObject::make('Packaged Food', 'Canned goods, ready-to-eat meals, noodles, and snacks', 'food-drinks'),
            CategoryObject::make('Fresh Produce', 'Fruits, vegetables, and other perishable goods', 'food-drinks'),
            CategoryObject::make('Frozen Food', 'Frozen meats, seafood, veggies, and snacks', 'food-drinks'),
            CategoryObject::make('Grains & Staples', 'Rice, beans, garri, pasta, flour, and other local staples', 'food-drinks'),
            CategoryObject::make('Spices & Seasoning', 'Curry, thyme, salt, bouillon, pepper and other flavouring agents', 'food-drinks'),
            CategoryObject::make('Drinks & Beverages', 'Soft drinks, bottled water, juices, and energy drinks', 'food-drinks'),
            CategoryObject::make('Alcoholic Drinks', 'Beer, wine, spirits, and traditional brews', 'food-drinks'),
            CategoryObject::make('Snacks & Confectionery', 'Biscuits, chocolates, sweets, and local snacks', 'food-drinks'),
            CategoryObject::make('Baby Food', 'Formula, cereals, and puree for infants and toddlers', 'food-drinks'),
            CategoryObject::make('Cooking Oils & Condiments', 'Vegetable oil, palm oil, ketchup, mayonnaise, etc.', 'food-drinks'),
        ];
    }

    protected function giftOccasions(): array
    {
        return [
            CategoryObject::make('Gifts & Occasions', 'Thoughtful presents and special celebration essentials'),

            CategoryObject::make('Gift Items', 'Unique gifts for birthdays, anniversaries, and other occasions', 'gifts-occasions'),
            CategoryObject::make('Greeting Cards', 'Cards for birthdays, weddings, sympathy, and more', 'gifts-occasions'),
            CategoryObject::make('Party Supplies', 'Balloons, banners, hats, and party favours', 'gifts-occasions'),
            CategoryObject::make('Event Decorations', 'Décor for weddings, birthdays, and ceremonies', 'gifts-occasions'),
            CategoryObject::make('Souvenirs', 'Custom items for events and special gatherings', 'gifts-occasions'),
            CategoryObject::make('Gift Wrapping', 'Wrapping paper, bags, ribbons, and boxes', 'gifts-occasions'),
            CategoryObject::make('Religious Items', 'Gifts and items for religious celebrations and holidays', 'gifts-occasions'),
        ];
    }

    protected function handmadeCrafts(): array
    {
        return [
            CategoryObject::make('Handmade & Crafts', 'Unique, artisanal items made with care and creativity'),

            CategoryObject::make('Beaded Items', 'Beaded jewellery, bags, accessories, and décor', 'handmade-crafts'),
            CategoryObject::make('Handmade Jewellery', 'Custom earrings, bracelets, rings, and necklaces', 'handmade-crafts'),
            CategoryObject::make('Craft Supplies', 'Materials for crafting: beads, glues, fabrics, threads', 'handmade-crafts'),
            CategoryObject::make('Home Décor', 'Handmade wall art, planters, vases, and decorative pieces', 'handmade-crafts'),
            CategoryObject::make('African Crafts', 'Locally-inspired arts, carvings, woven items and cultural crafts', 'handmade-crafts'),
            CategoryObject::make('Personalised Gifts', 'Customised name items, framed art, monogrammed keepsakes', 'handmade-crafts'),
            CategoryObject::make('Handmade Bags & Purses', 'Sewn or crocheted handbags, wallets, totes', 'handmade-crafts'),
            CategoryObject::make('Knitting & Crochet', 'Scarves, hats, blankets, and patterns from yarn', 'handmade-crafts'),
            CategoryObject::make('Art & Calligraphy', 'Original artwork, paintings, custom lettering', 'handmade-crafts'),
        ];
    }

    protected function healthWellness(): array
    {
        return [
            CategoryObject::make('Health & Wellness', 'Products for maintaining and improving overall health'),

            CategoryObject::make('Vitamins & Supplements', 'Multivitamins, herbal remedies, and immune boosters', 'health-wellness'),
            CategoryObject::make('Medical Supplies', 'Thermometers, test kits, first aid items, and health monitors', 'health-wellness'),
            CategoryObject::make('Fitness Equipment', 'Gym tools, resistance bands, yoga mats, and weights', 'health-wellness'),
            CategoryObject::make('Weight Management', 'Slimming teas, shakes, and nutrition plans', 'health-wellness'),
            CategoryObject::make('Men’s Health', 'Products specifically designed for men’s health and vitality', 'health-wellness'),
            CategoryObject::make('Women’s Health', 'Feminine care, fertility aids, and health supplements for women', 'health-wellness'),
            CategoryObject::make('Sexual Wellness', 'Contraceptives, lubricants, and intimacy products', 'health-wellness'),
            CategoryObject::make('Mental Wellness', 'Books, calming tools, stress relief products, and more', 'health-wellness'),
            CategoryObject::make('Essential Oils & Aromatherapy', 'Diffusers, oil blends, and relaxation tools', 'health-wellness'),
        ];
    }

    protected function homeLiving(): array
    {
        return [
            CategoryObject::make('Home & Living', 'Products for furnishing, decorating, and organising living spaces'),

            CategoryObject::make('Furniture', 'Beds, sofas, tables, and storage furniture', 'home-living'),
            CategoryObject::make('Home Decor', 'Wall art, vases, rugs, clocks, and other decorative items', 'home-living'),
            CategoryObject::make('Lighting', 'Indoor and outdoor lighting fixtures including lamps and bulbs', 'home-living'),
            CategoryObject::make('Kitchen & Dining', 'Cookware, utensils, dishes, and dining accessories', 'home-living'),
            CategoryObject::make('Bedding', 'Bedsheets, pillows, duvets, and mattress protectors', 'home-living'),
            CategoryObject::make('Bath', 'Towels, shower curtains, mats, and bathroom accessories', 'home-living'),
            CategoryObject::make('Storage & Organisation', 'Shelves, boxes, baskets, and organisers', 'home-living'),
            CategoryObject::make('Cleaning Supplies', 'Detergents, brooms, mops, and other cleaning tools', 'home-living'),
            CategoryObject::make('Home Improvement', 'Tools, fixtures, paints, and repair materials', 'home-living'),
            CategoryObject::make('Gardening', 'Pots, plants, soil, and gardening tools', 'home-living'),
        ];
    }

    protected function mediaPhotography(): array
    {
        return [
            CategoryObject::make('Media & Photography', 'Visual content creation, media equipment, and photography services'),

            CategoryObject::make('Photography Services', 'Event, studio, portrait, and commercial photography services', 'media-photography'),
            CategoryObject::make('Videography Services', 'Video coverage and editing for events, content creation, and branding', 'media-photography'),
            CategoryObject::make('Cameras & Accessories', 'DSLRs, mirrorless cameras, tripods, lenses, and related gear', 'media-photography'),
            CategoryObject::make('Lighting Equipment', 'Ring lights, softboxes, reflectors, and other lighting tools', 'media-photography'),
            CategoryObject::make('Media Editing', 'Photo and video editing services and software tools', 'media-photography'),
            CategoryObject::make('Studio Rentals', 'Rental of fully equipped photography and videography studios', 'media-photography'),
            CategoryObject::make('Media Production', 'Music videos, commercials, promotional clips, and more', 'media-photography'),
        ];
    }

    protected function pets(): array
    {
        return [
            CategoryObject::make('Pets', 'Everything for your furry, feathered, or scaly companions'),

            CategoryObject::make('Pet Food', 'Nutritious food for dogs, cats, birds, and more', 'pets'),
            CategoryObject::make('Pet Accessories', 'Collars, leashes, clothing, and pet beds', 'pets'),
            CategoryObject::make('Pet Grooming', 'Shampoos, brushes, and grooming tools', 'pets'),
            CategoryObject::make('Pet Health', 'Supplements, medications, and hygiene products', 'pets'),
            CategoryObject::make('Pet Toys', 'Interactive and fun toys for all kinds of pets', 'pets'),
            CategoryObject::make('Aquarium Supplies', 'Fish tanks, filters, décor, and food', 'pets'),
            CategoryObject::make('Pet Carriers & Crates', 'Transport and containment options for pets', 'pets'),
            CategoryObject::make('Pet Adoption & Sales', 'Listings for pet adoptions or sales', 'pets'),
        ];
    }

    protected function phoneAccessories(): array
    {
        return [
            CategoryObject::make('Phones & Accessories', 'Smartphones, basic phones, and mobile accessories'),

            CategoryObject::make('Smartphones', 'Latest Android and iOS devices from top brands', 'phones-accessories'),
            CategoryObject::make('Feature Phones', 'Basic phones with long battery life and essential features', 'phones-accessories'),
            CategoryObject::make('Phone Cases', 'Protective and stylish phone covers and pouches', 'phones-accessories'),
            CategoryObject::make('Screen Protectors', 'Tempered glass and film protectors for screens', 'phones-accessories'),
            CategoryObject::make('Chargers & Power Banks', 'Wall chargers, car chargers, and portable power banks', 'phones-accessories'),
            CategoryObject::make('Cables', 'USB cables, Type-C, Lightning cables, and OTG adapters', 'phones-accessories'),
            CategoryObject::make('Earphones & Headsets', 'Wired and wireless audio accessories for phones', 'phones-accessories'),
            CategoryObject::make('Smartwatches', 'Wearable smart devices compatible with phones', 'phones-accessories'),
            CategoryObject::make('Phone Holders & Stands', 'Mounts for cars, desks, and tripods for content creation', 'phones-accessories'),
            CategoryObject::make('SIM & Memory Cards', 'SIM-related accessories and memory storage cards', 'phones-accessories'),
        ];
    }

    protected function spiritualReligious(): array
    {
        return [
            CategoryObject::make('Spiritual & Religious', 'Products and services rooted in faith, spirituality, and religion'),

            CategoryObject::make('Anointing Oils & Incense', 'Spiritual oils, incense sticks, and scents for worship and meditation', 'spiritual-religious'),
            CategoryObject::make('Religious Books', 'Scriptures, devotionals, and spiritual guidance texts', 'spiritual-religious'),
            CategoryObject::make('Faith-Based Clothing', 'Apparel with religious messages or purpose', 'spiritual-religious'),
            CategoryObject::make('Worship Materials', 'Rosaries, prayer mats, chaplets, and other tools for worship', 'spiritual-religious'),
            CategoryObject::make('Church Supplies', 'Items for churches and religious gatherings', 'spiritual-religious'),
            CategoryObject::make('Spiritual Consultancy', 'Faith-based guidance, counselling, and prophetic services', 'spiritual-religious'),
            CategoryObject::make('Gospel Music & Media', 'Faith-inspired audio, video, and media content', 'spiritual-religious'),
        ];
    }
}
