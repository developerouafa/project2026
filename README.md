# 🛒 Multi-Vendor E-Commerce Platform
> **Full-stack multi-vendor e-commerce platform** built with Laravel, showcasing enterprise-level architecture, complex database relationships, and real-world payment integration.
---
## 🎯 **Project Highlights**
This is a **production-ready** multi-vendor marketplace demonstrating:
✅ **Advanced Laravel Architecture** – Eloquent relationships, query scopes, soft deletes, API resources  
✅ **Complex Business Logic** – Multi-role auth system, merchant order lifecycle, inventory management  
✅ **Reactive UI** – Laravel Livewire for dynamic checkout & cart management  
✅ **Payment Integration** – Stripe Checkout + Webhooks for secure payment processing  
✅ **Scalable Codebase** – Clean separation of concerns, extendable structure  
✅ **Multilingual Support** – Full Arabic & English localization  
**Built for:** Portfolio demonstration, technical hiring assessments, and real-world deployment.
---
## 🏗️ **Architecture Overview**
### **Multi-Role System**
The platform supports three distinct user types with isolated authentication flows:
| Role | Responsibilities | Authentication |
|------|-----------------|----------------|
| **Admin/User** | System management, moderation, analytics | `users` table |
| **Merchant** | Product management, order fulfillment | `merchants` table + dedicated routes |
| **Client** | Shopping, payments, order tracking | `clients` table + dedicated auth |
### **Core Technical Features**
#### **Advanced Product Catalog**
```php
Product → ProductColors → ColorVariants → Sizes → SKU + Stock
         → PackageProducts (bundles)
         → Sections (categories/subcategories)
```
- **Variant-based inventory** with color + size combinations
- **Package products** (bundled items)
- **Multi-image support** per product
- **Promotions & discounts** system
#### **Order & Payment Flow**
```
Client adds to Cart → Livewire Checkout → Create Order + Payment Record
  ↓
Stripe Checkout Session (with metadata)
  ↓
Redirect to Stripe → Payment Success/Failure
  ↓
Stripe Webhook → Update Payment Status → Split Merchant Orders
  ↓
Merchant processes order: pending → accepted → shipped → delivered
```
**Key implementations:**
- Webhook-based payment confirmation (prevents race conditions)
- Merchant-specific order splitting from global orders
- COD (Cash on Delivery) + Online payment support
- Invoice generation with shipping tracking
#### **Merchant Order Lifecycle**
Each merchant receives their own `MerchantOrder` with status tracking:
- `pending` → `accepted` → `processing` → `shipped` → `delivered`
- Refund handling with payment rollback
- Commission calculations ready (extendable)
---
## 🛠️ **Tech Stack**
### **Backend**
- **Laravel 12** – Latest framework features (PHP 8.2+)
- **Laravel Sanctum** – API authentication for mobile/SPA apps
- **Spatie Permission** – Role & permission management
- **Laravel Telescope** – Debug & monitoring (development)
### **Frontend**
- **Laravel Livewire 4** – Reactive components without heavy JS
- **Tailwind CSS** – Modern, responsive UI
- **Alpine.js** – Lightweight interactions
### **Database**
- **MySQL** – Relational database with 30+ migrations
- **Eloquent ORM** – Advanced relationships (polymorphic, many-to-many with pivot data)
### **Payments & Integrations**
- **Stripe PHP SDK** – Checkout Sessions + Webhooks
- **Astrotomic Translatable** – Database-level translations
- **Laravel Localization** – Route-based language switching
### **Development Tools**
- **Laravel Debugbar** – Performance profiling
- **PHPUnit** – Test suite ready
- **Composer Scripts** – `composer dev` for full dev environment
---
## 📦 **Key Features**
### **For Clients**
✔ Product browsing with filters (category, color, size)  
✔ Multi-merchant cart management  
✔ Real-time checkout with Livewire  
✔ Secure Stripe payments  
✔ Order tracking & history  
✔ Multiple shipping addresses  
✔ Product reviews & ratings  
### **For Merchants**
✔ Product CRUD with variants  
✔ Inventory management (SKU, stock levels)  
✔ Order dashboard with status updates  
✔ Sales analytics (extendable)  
✔ Shipping label integration ready  
### **For Admins**
✔ User/merchant/client management  
✔ Role & permission assignment  
✔ Order moderation  
✔ System-wide analytics  
✔ Payment reconciliation  
---
## 🚀 **Installation**
```bash
# Clone repository
git clone https://github.com/developerouafa/project2026.git
cd project2026
# Install dependencies & setup
composer setup
# This runs: composer install, .env setup, key generation, migrations, npm install & build
# Configure environment
cp .env.example .env
# Update database credentials, Stripe keys in .env
# Run migrations & seed (optional)
php artisan migrate --seed
# Start development server
composer dev
# Runs: Laravel server + queue worker + Vite + Pail (logs)
```
**Requirements:**
- PHP 8.2+
- MySQL 8.0+
- Composer 2.x
- Node.js 18+
---
## 🧪 **API Endpoints**
The project includes a RESTful API ready for mobile apps:
```php
POST   /api/registerapi    # Client registration
POST   /api/loginapi        # Authentication
GET    /api/user            # Get authenticated user (Sanctum)
POST   /api/logout          # Logout
// Protected routes (auth:sanctum)
GET    /api/sizesapi        # List all sizes
POST   /api/sizesapistore   # Create size (admin)
PUT    /api/sizesapiupdate/{id}
DELETE /api/sizesapidestroy/{id}
```
**Implemented:**
- API Resources for clean JSON responses
- Sanctum token authentication
- CORS configured for external apps
---
## 🎓 **What This Project Demonstrates**
### **Laravel Expertise**
- ✅ Complex Eloquent relationships (15+ models interconnected)
- ✅ Service layer pattern for business logic
- ✅ Resource transformers for API responses
- ✅ Event-driven architecture (webhooks)
- ✅ Query optimization (eager loading, scopes)
### **Real-World Skills**
- ✅ Payment gateway integration (Stripe)
- ✅ Multi-tenant architecture (merchant isolation)
- ✅ Stateful UI with Livewire (cart, checkout)
- ✅ Database design for e-commerce
- ✅ Security (CSRF, XSS protection, SQL injection prevention)
### **Production Readiness**
- ✅ Migration system for database versioning
- ✅ Environment-based configuration
- ✅ Error handling & logging
- ✅ Scalable file structure
- ✅ Ready for CI/CD integration
---
## 📈 **Future Enhancements**
This project is designed to be extended with:
🔹 **Admin Dashboard** – Full analytics with charts  
🔹 **Mobile Apps** – Using existing API endpoints  
🔹 **Multi-Currency** – International payment support  
🔹 **Advanced Search** – Elasticsearch/Meilisearch integration  
🔹 **Notifications** – Email/SMS for order updates  
🔹 **Inventory Alerts** – Low stock warnings  
# 🛒 منصة تجارة إلكترونية متعددة التجار
> **منصة متكاملة** مبنية بـ Laravel، تعرض معمارية على مستوى المؤسسات، علاقات قاعدة بيانات معقدة، وتكامل دفع حقيقي.
---
## 🎯 **نقاط القوة**
✅ **معمارية Laravel احترافية** – علاقات Eloquent متقدمة، query scopes، API resources  
✅ **منطق أعمال معقد** – نظام تسجيل متعدد الأدوار، دورة حياة طلبات التجار  
✅ **واجهة تفاعلية** – Livewire للدفع وإدارة السلة  
✅ **تكامل الدفع** – Stripe Checkout + Webhooks  
✅ **كود قابل للتوسع** – بنية نظيفة ومنظمة  
✅ **دعم متعدد اللغات** – العربية والإنجليزية  
---
## 🏗️ **المعمارية التقنية**
### **نظام متعدد الأدوار**
| الدور | المسؤوليات | المصادقة |
|------|------------|----------|
| **مدير النظام** | إدارة ومراقبة | `users` table |
| **التاجر** | إدارة المنتجات والطلبات | `merchants` مع routes خاصة |
| **العميل** | التسوق والدفع | `clients` مع auth منفصل |
### **نظام المنتجات المتقدم**
- **مخزون حسب المتغيرات** (لون + مقاس)
- **منتجات باكيج** (حزم)
- **صور متعددة** لكل منتج
- **نظام عروض وتخفيضات**
### **تدفق الطلب والدفع**
```
العميل → سلة → Livewire Checkout → إنشاء طلب + سجل دفع
  ↓
Stripe Checkout Session
  ↓
الدفع عبر Stripe
  ↓
Stripe Webhook → تحديث حالة الدفع → تقسيم طلبات التجار
  ↓
التاجر يعالج: قيد الانتظار → مقبول → جاري الشحن → تم التسليم
```
**التطبيقات الرئيسية:**
- تأكيد الدفع عبر Webhooks (يمنع التعارضات)
- تقسيم طلبات التجار تلقائيًا
- دعم الدفع عند الاستلام + الدفع أونلاين
- إنشاء فواتير مع تتبع الشحن
---
## 🛠️ **التقنيات المستعملة**
### **Backend**
- Laravel 12 | Sanctum | Spatie Permission | Telescope
### **Frontend**
- Livewire 4 | Tailwind CSS | Alpine.js
### **Database**
- MySQL | 30+ migrations | Eloquent ORM
### **الدفع والتكاملات**
- Stripe PHP SDK | Laravel Localization
---
## 📦 **المميزات الأساسية**
### **للعملاء**
✔ تصفح المنتجات مع الفلاتر  
✔ إدارة السلة  
✔ دفع آمن عبر Stripe  
✔ تتبع الطلبات  
✔ عناوين شحن متعددة  
✔ تقييم المنتجات  
### **للتجار**
✔ إدارة المنتجات والمتغيرات  
✔ إدارة المخزون (SKU، المخزون)  
✔ لوحة الطلبات  
✔ تحليلات المبيعات (قابلة للتوسع)  
### **للمدراء**
✔ إدارة المستخدمين  
✔ تعيين الأدوار والصلاحيات  
✔ مراقبة الطلبات  
✔ إحصائيات شاملة  
---
## 🚀 **التثبيت**
```bash
# استنساخ المشروع
git clone https://github.com/developerouafa/project2026.git
cd project2026
# تثبيت المكتبات والإعداد
composer setup
# تكوين البيئة
cp .env.example .env
# قم بتحديث بيانات قاعدة البيانات و Stripe keys
# تشغيل الخادم
composer dev
```
**المتطلبات:**
- PHP 8.2+
- MySQL 8.0+
- Composer 2.x
- Node.js 18+
---
## 🎓 **ما يعرضه هذا المشروع**
### **خبرة Laravel**
✅ علاقات Eloquent معقدة (15+ موديل مترابطة)  
✅ API Resources للاستجابات النظيفة  
✅ معمارية موجهة للأحداث (webhooks)  
✅ تحسين الاستعلامات (eager loading، scopes)  
### **مهارات عملية**
✅ تكامل بوابة دفع (Stripe)  
✅ معمارية متعددة المستأجرين  
✅ واجهة بحالة مع Livewire  
✅ تصميم قاعدة بيانات للتجارة الإلكترونية  
✅ الأمان (CSRF، XSS، SQL injection prevention)  
---
