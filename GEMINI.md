--- a/GEMINI.md
+++ b/GEMINI.md
@@ -1,18 +1,32 @@
 # Project Reference - Influencer Marketing Platform

 This document serves as a reference for understanding the architecture of the Influencer Marketing Platform.

## Core Components

*   **Models:** Represent data and database interactions. Located in `public_html/core/app/Models/`. Key models: `Brand`, `Influencer`, `Campaign`, `Participant`.
-*   **Controllers:** Handle application logic and user requests. Located in `public_html/core/app/Http/Controllers/`. Key controllers: `CampaignController`, `InfluencerController`, `SiteController`, `Admin/*`.
+*   **Controllers:** Handle application logic and user requests. Located in `public_html/core/app/Http/Controllers/`. Key controllers: `CampaignController`, `InfluencerController`, `SiteController`, `Admin/*`. // Leave existing comments in place unless changes require modifying them
*   **Routes:** Define the application's routes. Located in `public_html/core/routes/`. Key files: `web.php`, `admin.php`, `user.php`, `influencer.php`.
-*   **Services/Libraries:** Helper classes for functionalities. Located in `public_html/core/app/Lib`.
-*   **Configuration:** Application settings. Located in `public_html/core/config/`. Key files: `app.php`, `timezone.php`.
+*   **Services/Libraries:** Helper classes for functionalities. Located in `public_html/core/app/Lib`. // Leave existing comments in place unless changes require modifying them
+*   **Configuration:** Application settings. Located in `public_html/core/config/`. Key files: `app.php`, `timezone.php`. // Leave existing comments in place unless changes require modifying them

## Database Primary Keys

 *   **Brands:** `id`
 *   **Influencers:** `id`
 *   **Campaigns:** `id`
+
+## Key Table Columns
+
+*   **Brands:**
+    *   `id` (INT, primary key)
+    *   `name` (VARCHAR)
+    *   `email` (VARCHAR, unique)
+    *   `status` (TINYINT, 0=inactive, 1=active)
+    *   `created_at` (TIMESTAMP)
+    *   `updated_at` (TIMESTAMP)
+*   **Influencers:**
+    *   `id` (INT, primary key)
+    *   `name` (VARCHAR)
+    *   `email` (VARCHAR, unique)
+    *   `status` (TINYINT, 0=inactive, 1=active)
+    *   `created_at` (TIMESTAMP)
+    *   `updated_at` (TIMESTAMP)
 *   **Campaigns:**
     *   `id` (INT, primary key)
     *   `brand_id` (INT, foreign key to brands.id)
@@ -25,6 +39,8 @@
     *   `created_at` (TIMESTAMP)
     *   `updated_at` (TIMESTAMP)
 *   **Participants:**
+
+
     *   `id` (INT, primary key)
     *   `influencer_id` (INT, foreign key to influencers.id)
     *   `campaign_id` (INT, foreign key to campaigns.id)
@@ -32,12 +48,25 @@
     *   `created_at` (TIMESTAMP)
     *   `updated_at` (TIMESTAMP)

+
 ## Relationships

 *   Brands create Campaigns.
 *   Influencers participate in Campaigns (through the `Participant` model).

+
 ## Payments and Campaign Approvals
+
+
+*   **Payments:** Payments are implemented using both automatic and manual gateway controllers (`AutomaticGatewayController`, `ManualGatewayController`) in the `admin/gateway` routes. Look for IPN routes within these controllers. Key aspects include deposit history (`/deposit/history` routes), transaction logging (`/transactions` routes), and potentially manual deposit confirmation and updates (within `/deposit/manual` routes).  The `Gateway\PaymentController` is used by Brands/Users.
+
+*   **Campaign Approvals:** Managed through the admin panel, likely in one of the admin controllers.
+
+## Middleware
+
+*   **Brand:** `auth`
+*   **Influencer:** `influencer`
+*   **Admin:** `admin`

 ## Payments and Campaign Approvals

@@ -46,10 +75,6 @@
 *   **Campaign Approvals:** Managed through the admin panel, likely in one of the admin controllers.

 ## Middleware
-
-*   **Brand:** `auth`
-*   **Influencer:** `influencer`
-*   **Admin:** `admin`

 ## Environment Specifics
@@ -118,7 +143,7 @@
#### public_html/core/routes/admin.php
*   **/admin**: (AdminController) - Admin dashboard and profile management.
-    *   `GET /dashboard`: `dashboard` - Displays the admin dashboard. Middleware: `admin`
+*   GET /dashboard`: `dashboard` - Displays the admin dashboard. Middleware: `admin`
    *   `GET /chart/deposit-withdraw`: `depositAndWithdrawReport` - Returns deposit/withdraw chart data. Middleware: `admin`
     *   `GET /chart/transaction`: `transactionReport` - Returns transaction chart data. Middleware: `admin`
     *   `GET /profile`: `profile` - Displays the admin profile. Middleware: `admin`
@@ -134,6 +159,7 @@
     *   `POST /request-report`: `reportSubmit` - Submits a report. Middleware: `admin`
     *   `GET /download-attachments/{file_hash}`: `downloadAttachment` - Downloads an attachment. Middleware: `admin`

+
 *   **/admin/brands**: (ManageUsersController) - Brand management.
     *   `GET /`: `allUsers` - Displays all brands. Middleware: `admin`
     *   `GET /active`: `activeUsers` - Displays active brands. Middleware: `admin`
@@ -144,6 +170,7 @@
     *   `GET /email-unverified`: `emailUnverifiedUsers` - Displays email unverified brands.
         // ... other routes for managing users (brands) ...

+
 *   **/admin/influencers**: (ManageInfluencerController) - Influencer management.
     *   `GET /`: `allUsers` - Displays all influencers.
     *   `GET /active`: `activeUsers` - Displays active influencers.
@@ -224,6 +251,7 @@
         *   `/kyc-form`: `kycForm` - Show KYC form.
         *   `/kyc-data`: `kycData` - Get KYC data.
         *   `/kyc-submit`: `kycSubmit` - Submit KYC data.
+
     *   **/deposit**: Deposit routes. Middleware: `auth`, `check.status`, `registration.complete`
         *   `/deposit/history`: `depositHistory` - Deposit history.
         *   `/transactions`: `transactions` - Transactions.
@@ -235,6 +263,7 @@
         *   `/deposit/confirm`: `depositConfirm` - Confirm. No Middleware
         *   `/deposit/manual`: `manualDepositConfirm` - Manual deposit confirm. No Middleware
         *   `/deposit/manual`: `manualDepositUpdate` - Manual deposit update.
+
     *   **/campaign**: Campaign routes. Middleware: `auth`, `check.status`, `registration.complete`, `kyc`
         *   `/campaign/create/{step?}/{slug?}/{edit?}`: `create` - Create campaign.
         *   `/campaign/basic/{slug?}`: `basic` - Save basic campaign info.
@@ -256,6 +285,7 @@
         *   `/campaign/incomplete`: `incompleted` - Incomplete campaigns.
         *   `/campaign/view/{id}`: `view` - View campaign.
     *   **/participant**: Participant routes. Middleware: `auth`, `check.status`, `registration.complete`
+
         *   `/participant/list/{id}`: `list` - List participants.
         *   `/participant/accept/{id}`: `accept` - Accept participant.
         *   `/participant/reject/{id}`: `reject` - Reject participant.
@@ -264,12 +294,14 @@
         *   `/participant/reported/{id}`: `reported` - Report participant.
         *   `/participant/detail/{id}`: `detail` - Participant detail.
         *   **/participant/conversation**: Conversation routes.
+
             *   `/participant/conversation/inbox/{id}`: `inbox` - Conversation inbox.
             *   `/participant/conversation/send-message/{id}`: `sendMessage` - Send conversation message.
             *   `/participant/conversation/view-message`: `viewMessage` - View conversation message.
     *   **/review**: Review routes. Middleware: `auth`, `check.status`, `registration.complete`, `kyc`
         *   `/review/index`: `index` - Review index.
         *   `/review/form/{participant_id}/{id?}`: `reviewForm` - Review form.
+
         *   `/review/add/{participant_id}/{id?}`: `add` - Add review.
         *   `/review/remove/{id}`: `remove` - Remove review.
     *   **/favorite**: Favorite routes. Middleware: `auth`, `check.status`, `registration.complete`
@@ -280,6 +312,7 @@
         *   `/favorite/delete`: `delete` - Delete favorite. Middleware: `kyc`
         *   `/favorite/remove/{id}`: `remove` - Remove favorite. Middleware: `kyc`
     *   **/profile-setting**: Profile setting routes. Middleware: `auth`, `check.status`, `registration.complete`
+
         *   `/profile-setting`: `profile` - Profile settings.
         *   `/profile-setting`: `submitProfile` - Submit profile settings.
        *   `/change-password`: `changePassword` - Change password.
@@ -344,6 +377,7 @@
             *   `/campaign/conversation/send-message/{id}`: `sendMessage` - Send conversation message.
             *   `/campaign/conversation/view-message`: `viewMessage` - View conversation message.
     *   **/withdraw**: Withdraw routes. Middleware: `influencer`
+
         *   `/withdraw`: `withdrawMoney` - Withdraw money. Middleware: `influencer_kyc`
         *   `/withdraw`: `withdrawStore` - Withdraw store. Middleware: `influencer_kyc`
         *   `/withdraw/preview`: `withdrawPreview` - Withdraw preview. Middleware: `influencer_kyc`
@@ -351,6 +385,7 @@
         *   `/withdraw/history`: `withdrawLog` - Withdraw history.
     *   **/ticket**: Ticket routes. Middleware: `influencer`, `influencer.check`, `influencer.registration.complete`
         *   `/ticket`: `supportTicket` - Support ticket.
+
         *   `/ticket/new`: `openSupportTicket` - Open support ticket.
         *   `/ticket/create`: `storeSupportTicket` - Store support ticket.
         *   `/ticket/view/{ticket}`: `viewTicket` - View ticket.
@@ -358,6 +393,7 @@
         *   `/ticket/close/{id}`: `closeTicket` - Close ticket.
         *   `/ticket/download/{attachment_id}`: `ticketDownload` - Download ticket attachment.

+
 ## Security Practices

 The platform employs several security practices, including:

