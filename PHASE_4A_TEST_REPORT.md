# Phase 4A Test Report

Date: 2026-06-11
Project: GST Invoice SaaS Platform
Phase under review: Phase 4A - Proforma Invoice Module

## Executive Summary

Phase 4A is functionally testable and the automated Laravel test suite passes.

However, Phase 4A is not fully complete against the original checklist. The main gaps are:

- No dedicated proforma PDF Blade view.
- No convert-proforma-to-GST-invoice stub route/action/button.
- No product search stub in the invoice builder.
- No clone-item control in the invoice builder.
- Per-item discount fields exist in DTO/request validation but are not exposed in the UI or applied in backend totals.
- Controller still performs direct model queries and DTO item mapping, which partially violates the architecture rule that controllers should only validate, call services, and return responses.
- Laravel Pint formatting check fails across many files.

## Commands Run

### Backend Test Suite

Command:

```bash
composer test
```

Result:

```text
PASS
Tests: 94 passed (236 assertions)
Duration: 7.70s
```

Coverage included:

- Auth feature tests.
- Company and company settings tests.
- Client management tests.
- GST calculation, GST validation, and place-of-supply unit tests.
- Invoice management tests.
- Proforma invoice feature tests.

### Frontend Production Build

Initial PowerShell command:

```bash
npm run build
```

Result:

```text
Failed because PowerShell execution policy blocked npm.ps1.
```

Windows-compatible command:

```bash
npm.cmd run build
```

Result:

```text
PASS
vite v7.3.3 built successfully.
62 modules transformed.
Output written to public/build.
```

### Code Style Check

Command:

```bash
vendor/bin/pint.bat --test
```

Result:

```text
FAIL
```

Pint reported formatting fixes needed across many files, including DTOs, controllers, requests, models, repositories, services, migrations, seeders, routes, and tests. This appears to be a broad project formatting issue rather than only a Phase 4A issue.

## Environment Observed

```text
PHP: 8.2.12
Node: v22.19.0
npm: 10.9.3 via npm.cmd
Laravel: 12.x from composer.json
PHPUnit: 11.5.x from composer.json
Test database: MySQL database gst_invoice_test from phpunit.xml
```

## Phase 4A Checklist Status

| Requirement | Status | Notes |
| --- | --- | --- |
| ProformaController index/create/store/show/edit/update/destroy | PASS | 7 routes registered under /proformas. |
| StoreProformaRequest and UpdateProformaRequest | PASS | Required fields, item validation, discounts, charges, dates, and status are covered. |
| InvoiceService createProforma | PASS | Creates invoice, generates PF number, persists items. |
| InvoiceService updateProforma | PASS | Updates draft proforma and replaces items. |
| InvoiceService calculateTotals | PARTIAL | Handles invoice-level percentage discount, GST, shipping, commission. Does not handle fixed discount correctly or per-item discounts. Uses hard-coded seller/buyer state values. |
| Dynamic item rows add/remove | PASS | Alpine builder supports add and remove. |
| Dynamic item rows clone | MISSING | No clone item action found. |
| Product search stub | MISSING | No product search UI/stub found. |
| Live calculation on quantity/price/GST/discount changes | PARTIAL | Quantity, price, GST rate, invoice discount, shipping, and commission recalculate. Per-item discount is missing. Frontend uses average GST rate, which can be inaccurate with mixed GST rates. |
| Proforma listing with filters | PASS | Status, date range, search, and client filter support exist via repository filters. |
| Create/edit proforma views | PASS | Blade views exist and build successfully. |
| Show proforma print-friendly view | PASS | Show view includes print CSS and print button. |
| Proforma PDF view | MISSING | No dedicated PDF Blade view found. |
| Percentage discount | PASS | Tested for creation path. |
| Fixed amount discount | PARTIAL | Request allows fixed, but service only passes percentage value to TaxBreakdownService, so fixed discount is not subtracted from totals. |
| Per-item discount support | MISSING | DTO/request support exists, but UI and backend total calculation do not apply it. |
| Shipping charges | PASS | Tested. |
| Commission | PASS | Tested. |
| Payment terms | PASS | Form/request/model support exists. |
| Logistics details | PARTIAL | Request/DTO/model support exists, but UI coverage appears limited. |
| Estimated delivery date | PASS | Create/edit fields and validation exist. |
| Convert proforma to GST invoice button stub | MISSING | No route/action/button found. |

## Automated Test Detail

The dedicated proforma test class passed all 12 tests:

- User can view proforma listing.
- User can create proforma invoice.
- Totals calculate for a simple 18 percent GST case.
- Percentage discount creation path succeeds.
- Shipping and commission are added.
- User can view proforma details.
- User can edit draft proforma.
- User cannot edit sent proforma.
- User can update proforma.
- User can delete draft proforma.
- Required fields validate.
- Minimum one item validates.

## Key Risks Before Phase 4B

1. Fixed discount bug.
   The service stores discount_amount from calculated totals, but TaxBreakdownService only accepts discountPercentage. For fixed discounts, the backend currently treats discount as zero.

2. Mixed GST rate inaccuracy.
   The frontend computes total GST using an average GST rate over the total taxable amount. This can be wrong when item values differ and GST rates differ.

3. Per-item discount gap.
   Requests and DTOs contain per-item discount fields, but totals ignore them.

4. Hard-coded state logic.
   InvoiceService::calculateTotals uses sellerState and buyerState as "24". Phase 4B will need real company/client state integration for CGST/SGST vs IGST.

5. Controller boundary drift.
   ProformaController directly queries Company and Client and maps request arrays into DTOs. To preserve the planned Next.js/API migration path, move this orchestration into service/DTO factory methods.

6. Missing handoff deliverables.
   PDF placeholder/view and convert-to-GST stub are required by Phase 4A but not present.

## Recommendation

Do not mark Phase 4A as fully complete yet. Mark it as:

```text
Automated tests passing, implementation partially complete.
```

Before starting Phase 4B, fix the checklist gaps above and add tests for:

- Fixed invoice discount calculation.
- Per-item percentage and fixed discount calculation.
- Mixed GST rates with different item values.
- Convert proforma to GST invoice stub route/action.
- PDF view route or renderer placeholder.
- Controller/service boundary for company/client lookup and DTO construction.

