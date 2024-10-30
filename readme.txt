=== InvoiceIT ===
Contributors: codesoup, iramljak
Tags: invoice, invoicing
Requires at least: 5.0
Tested up to: 5.7.2
Requires PHP: 7.1
Stable tag: 1.0.1
License: GPL v3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Free & Simple invoicing plugin.

== Description ==
This free plugin lets you create invoices, maintain a client base and choose a payment option to display on each invoice. Payment options are related to a Bank Account post type. Create as many invoices, clients or bank accounts as you need. No restrictions.

##Features##

#Branding#
- use your branding, attach company logo to invoice or a hand signature
- display company info such as address, contact and legal information
- option to use invoice prefix for numbering

#Client#
- addresses & contacts
- tax rate, NET period, VAT ID, currency

#Bank Account#
- display name
- simple details, in two columns if needed

#Invoice#
- automatic invoice number with prefix if prefix is set in plugin options
- choose a client & invoice status
- date and due date with NET period, NET is automatically pulled from selected Client settings
- choose payment option from user predefined Bank Accounts
- choose weather to show the global signature or not
- add invoice items: title, description, quantity, unit, rate & discount - totals are calculated automatically
- add a note to be displayed at the bottom of invoice

#General#
- set global note for each invoice or per invoice
- display a global one-line note in page footer for each page
- print stylesheet included if you need to print an invoice or export in PDF

== Installation ==
1. In the WordPress Dashboard go to Plugins, then click the Add Plugins button and search the WordPress Plugins Directory for 'invoiceit'. Alternatively you can download the plugin from here and upload manually.
2. Activate the plugin through the 'Plugins' screen in WordPress.

== Screenshots ==
1. Company Info - Branding
2. Company Info - Address
3. Company Info - Contact
4. Company Info - Legal
5. Company Info - Invoice Options
6. New Bank Account Setup
7. New Client Setup
8. New Invoice Setup
9. Rendered Invoice

== Changelog ==
1.0.0 - First release

1.0.1
- Fix: On plugin activation update plugin meta option for first invoice number
- Update: Set a default value in admin plugin options for first invoice number
- Update: Remove debug log for reload_permalinks_structure function
- Update: Plugin Author