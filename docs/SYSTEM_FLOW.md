# Proden System Flow

Date: 2026-03-18

## 1. Landing and Navigation
- Public landing page is `/`.
- Main customer navigation includes:
  - Home
  - Shop
  - Become a Distributor
  - Cart
- Login link is hidden on customer-facing pages.

## 2. Product Browsing and Cart
- Customer browses products at `/shop` and `/product/{slug}`.
- Add-to-cart supports AJAX updates.
- Cart badge in navbar updates immediately after adding an item.
- Cart is tied to a persistent session cart id.

## 3. Checkout and Order Creation
- Checkout routes:
  - `GET /checkout`
  - `POST /checkout`
- Customer provides:
  - Name
  - Phone
  - Address
  - Payment method/network
- Order is created with:
  - `payment_status = pending`
  - `order_status = pending`

## 4. Pending Order Resume (No Duplicate Orders)
- Before creating a new order, system checks for existing unpaid pending/processing order.
- Matching sources:
  - Session pending order id
  - Customer phone number (normalized phone matching)
- If existing pending order exists, customer is redirected to continue same order.

## 5. Flexible Phone Matching
- Phone matching ignores non-digit characters.
- Supports format differences such as:
  - `+256 772 494618`
  - `256772494618`
  - `0772494618`
- Matching uses normalized digits and a last-9-digit fallback.

## 6. Cart Lock Rule
- If customer has unpaid and undelivered order:
  - Cart clear action is blocked.
  - Customer sees warning to complete payment/delivery process first.

## 7. Cart Phone Lookup
- On `/cart`, customer can enter phone number to fetch order history.
- Result groups:
  - Pending orders: includes `Continue Payment` action
  - Delivered/completed orders: includes `View Receipt`

## 8. Receipt and Payment CTA
- Receipt route: `GET /order/{orderId}/receipt`.
- If payment is pending, receipt shows `Pay Now` button.
- `Pay Now` routes customer to continue payment flow on the same order.

## 9. Distributor Recruitment Flow
- Public application form:
  - `GET /become-distributor`
  - `POST /become-distributor`
- Form captures applicant and business details.
- On successful submission:
  - Redirect to landing page `/`
  - Success message displayed on landing hero section.

## 10. Admin Distributor Management
- Admin routes:
  - `GET /admin/distributors`
  - `PATCH /admin/distributors/{application}/status`
- Admin can view and update distributor lead status:
  - `new`
  - `contacted`
  - `approved`
  - `rejected`

## 11. Admin Operations
- Dashboard: `/admin/dashboard`
- Orders list/details/status updates
- Inventory production/adjustments/reporting
- Product CRUD
- Distributor list integrated in admin sidebar

## 12. Currency and Branding
- Currency display is standardized as `UGX`.
- Company brand references standardized to `Proden`.

## 13. Key Customer Routes
- `/`
- `/shop`
- `/product/{slug}`
- `/cart`
- `/checkout`
- `/order/{orderId}/success`
- `/order/{orderId}/receipt`
- `/become-distributor`

## 14. Notes for Next Iteration
- Integrate real payment gateway callback to auto-update `payment_status`.
- Add SMS/WhatsApp resume links for pending orders.
- Add optional order tracking page by phone + order number.
