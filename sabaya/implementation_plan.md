# Refactor Sabaya Project for HTML5 Semantics

The goal of this task is to refactor all 19 frontend PHP files in the "Sabaya" project to use semantic HTML5 tags while perfectly preserving the underlying PHP business logic, database interactions, session management, and routing.

## User Review Required

Please review this implementation plan. Since the instructions stipulate that *no PHP logic* should be modified and *all forms/tables/semantics* should be updated, I will process each file individually and ensure that:
- `<div class="header">` is replaced with `<header>`
- Navigation areas are wrapped in `<nav>`
- The main content area is wrapped in `<main>`
- Independent content/cards are wrapped in `<article>`
- Sidebar content in `<aside>`
- Footer in `<footer>`
- Forms receive proper semantic grouping and `<label for="...">` without changing IDs/Names
- Tables receive `<thead>`, `<tbody>`, and `<caption>`
- Images get meaningful `alt` attributes
- Accessibility improvements are made (e.g. preserving labels, using `aria-label` only when necessary)
- Global document structure matches: `<header><nav></nav></header> <main><section>...</section></main> <footer>...</footer>`

Are there any specific files you want me to prioritize or exclude, or can I proceed with processing all 19 files?

## Open Questions

- Should I add a basic `index.php` shell if it is currently completely empty? (For now, I will skip the empty `index.php` and focus on the files that output HTML).

## Proposed Changes

### Files to Modify
I will apply the HTML5 semantic refactoring to the following files:

#### [MODIFY] wishlist.php
#### [MODIFY] products.php
#### [MODIFY] product-details.php
#### [MODIFY] order-success.php
#### [MODIFY] my-orders.php
#### [MODIFY] checkout.php
#### [MODIFY] cart.php
#### [MODIFY] register.php
#### [MODIFY] profile.php
#### [MODIFY] login.php
#### [MODIFY] dashboard.php
#### [MODIFY] edit.php (admin/products)
#### [MODIFY] list.php (admin/products)
#### [MODIFY] add.php (admin/products)
#### [MODIFY] update-status.php (admin/orders)
#### [MODIFY] list.php (admin/orders)
#### [MODIFY] list.php (admin/categories)
#### [MODIFY] edit.php (admin/categories)
#### [MODIFY] add.php (admin/categories)

## Verification Plan

### Manual Verification
- All 19 pages should render identically to their previous versions but with the new HTML5 structure.
- Forms should continue to function perfectly as `name` and `id` attributes will not be altered.
- Database logic and routing will remain completely unaffected.
