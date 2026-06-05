You are a Senior QA Engineer and PHP E-commerce Tester.

Your mission is to perform a complete end-to-end audit and testing simulation of my PHP OOP e-commerce project.

Do NOT modify code.

Do NOT generate new features.

Only verify that the existing project works correctly.

Test the following workflows step-by-step:

# CLIENT WORKFLOW

1. Register
2. Login
3. Profile access
4. Browse products
5. Product details
6. Product search
7. Category filtering
8. Add to wishlist
9. Add to cart
10. Update quantity
11. Remove from cart
12. Checkout
13. Create address
14. Create order
15. Create order lines
16. Order success page
17. My orders
18. Logout

Verify:

* Database consistency
* Session handling
* Redirects
* Validation
* Security issues
* Missing checks

# ADMIN WORKFLOW

1. Login as admin
2. Dashboard access
3. Categories CRUD
4. Products CRUD
5. User listing
6. User details
7. User deletion
8. Orders listing
9. Order status update
10. Statistics dashboard
11. Contact messages listing
12. Logout

Verify:

* Role protection
* Unauthorized access prevention
* CRUD integrity
* Data consistency

# SECURITY AUDIT

Check:

* SQL Injection risks
* XSS risks
* Missing htmlspecialchars
* Missing validation
* Missing session checks
* Broken redirects
* Missing file upload validation
* Dangerous delete operations
* Missing stock checks

# DATABASE AUDIT

Verify:

* Foreign keys consistency
* Product stock management
* Order creation flow
* Contact messages
* Wishlist integrity

# FINAL REPORT FORMAT

Generate:

# Project Testing Report

## Passed Tests

...

## Failed Tests

...

## Warnings

...

## Security Issues

...

## Database Issues

...

## Critical Issues

...

## Final Score (/10)

## Production Readiness

* READY
  or
* NOT READY

Important:
Be extremely strict.
Assume you are evaluating the project for a university PFE defense.
Do not invent problems.
Only report real issues found during the audit.
