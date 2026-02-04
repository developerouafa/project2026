🛒 Multi-Vendor E-Commerce Platform

Laravel · Livewire · Tailwind · Stripe

🇬🇧 English
📌 Overview

This project is a full-stack multi-vendor e-commerce platform built primarily as a portfolio project to demonstrate advanced Laravel skills, while remaining open and scalable for real-world production use.

It showcases clean architecture, complex database relationships, and real business workflows, commonly required in modern e-commerce systems.

👥 User Types

The system is structured around three main roles:

Users / Admins – system management & moderation

Merchants – manage products, orders, and packages

Clients – browse products, place orders, and make payments

Each role has its own authentication flow, permissions, and responsibilities.

🌍 Multilingual & UI

Fully multilingual: Arabic 🇲🇦 & English 🇬🇧

Tailwind CSS responsive design

Clean, modern UI with scalable components

⚡ Livewire Integration

The project uses Laravel Livewire to build dynamic, reactive features without heavy JavaScript, especially for business-critical flows.

Livewire is mainly used for:

Checkout & order creation

Cart updates (real-time)

Form validation without page reload

Stateful components across the purchase flow

This keeps the frontend fast and interactive, while maintaining backend logic inside Laravel.

🔄 Checkout & Payment Flow (Livewire + Stripe)
Client
  ↓
Livewire Checkout Component
  ↓
Create Order + Payment
  ↓
Stripe Checkout Session (metadata)
  ↓
Redirect to Stripe
  ↓
Stripe Webhook
  ↓
Update Payment & Order Status

🧱 Core Features
🛍 Product System

Categories & subcategories (Sections)

Products with:

Colors

Color variants

Sizes

SKU & stock per variant

Simple & variant-based products

Package products (bundles)

🧑‍💼 Merchant System

Merchant-owned products

Merchant-specific orders

Merchant order lifecycle:

pending → accepted → processing → delivered

🛒 Cart & Orders

One cart per client & merchant

Convert cart → order

Order items & package items

Merchant orders split from global orders

💳 Payments & Accounting

Stripe Checkout integration

Webhook-based payment confirmation

Payments, invoices, refunds

Client accounts & fund tracking

COD & online payment ready

🚚 Shipping & Addresses

Multiple addresses per client

Shipping tracking per invoice

🧠 Architecture Highlights

Advanced Eloquent relationships

Extensive use of:

Query Scopes

Soft Deletes

Casts & Accessors

Clean separation of concerns

Highly readable & extendable codebase

🎯 Project Goal

This project is designed to be:

✅ A strong Laravel portfolio project

✅ A solid foundation for a real multi-vendor e-commerce platform

It can easily be extended with:

Admin dashboards

REST / API & mobile apps

Multi-currency support

Advanced analytics & reports

🛠 Tech Stack

Backend: Laravel

Reactive UI: Laravel Livewire

Frontend: Tailwind CSS

Auth & Roles: Laravel Auth + Spatie Roles

Payments: Stripe (Checkout & Webhooks)

Database: MySQL

Languages: Arabic & English

🇲🇦 العربية
📌 نظرة عامة

هذا المشروع عبارة عن منصة تجارة إلكترونية متعددة التجار، تم تطويرها أساسًا كـ مشروع Portfolio لعرض مستوى احترافي في Laravel، مع الحفاظ على بنية قابلة للتطوير والاستعمال في مشروع حقيقي.

المشروع يعكس تعاملًا واقعيًا مع أنظمة التجارة الإلكترونية من حيث التصميم، العلاقات، وتدفقات العمل.

👥 أنواع المستخدمين

المنصة تعتمد على ثلاثة أدوار رئيسية:

Users / Admins – إدارة النظام

Merchants (التجار) – إدارة المنتجات والطلبات

Clients (العملاء) – الشراء والدفع

كل دور عنده نظام تسجيل وصلاحيات مستقل.

🌍 تعدد اللغات والتصميم

دعم كامل للعربية والإنجليزية

تصميم متجاوب باستعمال Tailwind CSS

واجهة نظيفة وقابلة للتوسعة

⚡ استعمال Livewire

تم استعمال Laravel Livewire لبناء واجهات تفاعلية بدون JavaScript معقد، خصوصًا في المراحل الحساسة.

Livewire مستعمل في:

Checkout وإنشاء الطلبات

تحديث السلة مباشرة

Validation بدون Reload

Components بحالة (Stateful)

هذا يعطي تجربة استخدام سلسة مع الحفاظ على منطق العمل داخل Laravel.

🔄 مسار الشراء (Livewire + Stripe)
العميل
  ↓
Livewire Checkout
  ↓
إنشاء Order + Payment
  ↓
Stripe Checkout Session
  ↓
التحويل إلى Stripe
  ↓
Stripe Webhook
  ↓
تحديث حالة الدفع والطلب

🧱 المميزات الأساسية
🛍️ نظام المنتجات

أقسام وأقسام فرعية

منتجات تدعم:

الألوان

الفاريانت

المقاسات

SKU والمخزون

باكيجات المنتجات

🧑‍💼 نظام التجار

منتجات خاصة بكل تاجر

طلبات مستقلة للتجار

حالات الطلب (في الانتظار → مقبول → تم التسليم)

🛒 السلة والطلبات

سلة لكل عميل وتاجر

تحويل السلة إلى طلب

عناصر الطلب والباكيجات

💳 الدفع والمحاسبة

Stripe Checkout

Webhooks لتأكيد الدفع

فواتير، مدفوعات، Refunds

دعم الدفع عند الاستلام

🚚 الشحن والعناوين

عدة عناوين لكل عميل

تتبع الشحن حسب الفاتورة

🧠 نقاط القوة المعمارية

علاقات Eloquent متقدمة

استعمال Scopes و SoftDeletes

كود منظم وقابل للتطوير

هيكلة واضحة وسهلة الفهم

🎯 هدف المشروع

المشروع يهدف إلى:

✅ عرض مستوى احترافي في Laravel

✅ توفير قاعدة قوية لمشروع تجارة إلكترونية حقيقي

ويمكن توسيعه لاحقًا بإضافة:

Dashboard متقدم

API و Mobile Apps

تعدد العملات

تقارير وإحصائيات

🧰 التقنيات المستعملة

Backend: Laravel

Reactive UI: Livewire

Frontend: Tailwind CSS

Auth & Roles: Laravel + Spatie

Payments: Stripe

Database: MySQL

اللغات: العربية & الإنجليزية
