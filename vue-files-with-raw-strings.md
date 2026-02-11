# Vue Files with Raw Strings (Not Using Multi-Lang Feature)

This document lists all Vue files imported in `resources/js/web.js` that contain raw string tags in templates that should be using multi-language features.

## Files with Raw Strings:

### 1. **resources/js/web/profile-payment/ProfilePayment.vue**
   - Line 118: `<label class="">Card Details</label>`
   - Line 140: `<h4 class="text-white">Order Summary</h4>`

### 2. **resources/js/web/components/Error.vue**
   - Line 12: `This field is required` (in `<span>` tag)

### 3. **resources/js/web/event-signup/Profile.vue**
   - Line 742: `<label class="">Card Details</label>`
   - Line 755: `<!-- Order Summary -->` (comment, but likely has corresponding heading)

### 4. **resources/js/web/signup/SocialMedia.vue**
   - Line 197: `<label class="">Card Details</label>`
   - Line 297: `<h4 class="text-white">Order Summary</h4>`

### 5. **resources/js/web/become-sponsor/BecomeSponsor.vue**
   - Line 401: `<label class="block text-sm  text-gray-700 mb-1 font-bold">Cardholder Name</label>`
   - Line 409: `<label class="block text-sm  text-gray-700 mb-1 font-bold">Card Details</label>`
   - Line 454: `aria-label="Submit Sponsorship"`
   - Line 465: `Processing...` (in button/span)

### 6. **resources/js/web/become-sponsor/AddSponsorshipForm.vue**
   - Line 133: `placeholder="John Doe"`
   - Line 142: `placeholder="email@example.com"`
   - Line 181: `placeholder="https://yourcompany.com"`
   - Line 289: `placeholder="John Doe"`
   - Line 290: `placeholder="John Doe"` (cardholder name)
   - Line 297: `<label class="block text-sm font-medium text-gray-700 mb-1">Card Details</label>`
   - Line 315: `Processing...` (in button/span)

### 7. **resources/js/web/become-sponsor/SponsorProfileEdit.vue**
   - Line 7: `Your Profile Status:`
   - Line 10: `"Live"`, `"Pending"`, `"Draft"` (status text)
   - Line 15: `View Public Profile`
   - Line 24: `<h3 class="text-lg font-semibold text-gray-800">Sponsorship Status</h3>`
   - Line 31: `'✓ Active'`, `'⏳ Pending'`, `"Inactive"` (status badges)
   - Line 38: `'💳 Paid'`, `"Payment Pending"`, `"Contact Request"` (payment status)
   - Line 43: `Sponsorship Amount`
   - Line 46: `Paid on` (date prefix)
   - Line 55: `Payment Method:`
   - Line 61: `Beneficiary:`
   - Line 69: `Upgrade your plan mid-cycle: we'll apply unused time from your current plan as credit toward the new one.`
   - Line 72: `Upgrade plan` (button text)
   - Line 82: `<h4 class="text-white">Company Information</h4>`
   - Line 88: `Company Name` (label)
   - Line 91: `:placeholder="'Your Company Inc.'"`
   - Line 97: `Contact Person` (label)
   - Line 100: `:placeholder="'John Doe'"`
   - Line 128: `:placeholder="'https://www.yourcompany.com'"`
   - Line 147: `:placeholder="'A brief overview of your company...'"`
   - Line 167: `:placeholder="'Any additional information...'"`
   - Line 299: `Confirm New Password` (label)
   - Line 325: `<strong>Note: </strong>Leave these fields blank to keep your current password. Only enter a new password if you wish to update it.`
   - Line 339-340: `Update Profile` (button text)
   - Line 363: `Your unused time on the current plan will be applied as credit. You pay: New plan price − credit.`
   - Line 381: `"Loading..." : "See upgrade cost"` (button text)
   - Line 385: `Unused credit from current plan:`
   - Line 386: `New plan price:`
   - Line 387: `Amount due today:`
   - Line 400: `<label class="block text-sm font-medium text-gray-700 mb-1">Cardholder Name</label>`
   - Line 401: `:placeholder="'John Doe'"`
   - Line 404: `<label class="block text-sm font-medium text-gray-700 mb-1">Card Details</label>`
   - Line 406: `Your credit covers this upgrade; card will be used for future renewals.`
   - Line 413: `Cancel` (button text)
   - Line 416: `"Submitting..." : "Submit downgrade request"` (button text)
   - Line 420: `'Processing...' : (upgradePreview.amount_due_today > 0 ? 'Confirm and pay' : 'Confirm upgrade')` (button text)
   - Line 438: `Processing...` (loading overlay)

### 8. **resources/js/web/become-sponsor/SponsorshipsList.vue**
   - Line 17: `Loading your sponsorships...`
   - Line 136: `Loading...` (loading overlay)
   - Line 559: `<label class="block text-sm font-medium text-gray-700 mb-1">Card Details</label>`
   - Line 601: `aria-label="Submit Sponsorship"`
   - Line 612: `Processing...` (button text)

### 9. **resources/js/web/coffee-wall/Create.vue**
   - Line 335: `"Card Details"` (fallback text in ternary)

### 10. **resources/js/web/event-signup/Create.vue**
   - Line 992: `CTA URL` (label)
   - Line 996: `placeholder="See explanation in the footnotes below"`
   - Line 1004: `'Step 4 of 4 - Social Media (Optional)'` (fallback text)

### 11. **resources/js/web/submit-content/SubmitContent.vue**
   - Line 157: `'Submitting...' : 'Submit Article'` (button text)
   - Line 200: `'Submitting...' : 'Submit Video'` (button text)

### 12. **resources/js/web/Webinars/MyWebinars.vue**
   - Line 22: `Loading...`
   - Line 193: `Loading...`
   - Line 215: `Loading...`

### 13. **resources/js/web/become-sponsor/SponsorManagement.vue**
   - Line 6: `Loading...` (loading state text)

### 14. **resources/js/web/Webinars/Index.vue**
   - Line 351: `"Submitting..." : "Submit registration"` (button text)

### 15. **resources/js/web/become-sponsor/SponsorProfile.vue**
   - Line 274: `aria-label="Submit Sponsor Profile"`
   - Line 285: `Processing...` (button/loading text)

## Additional Notes

**Note:** Many files also contain `aria-label="Candian Exporters"` or `aria-label="Canadian Exporters"` which are accessibility labels. While these could potentially be translated, they are less critical for user-facing content.

## Summary

**Total files with raw strings: 15**

These files contain hardcoded English text in labels, headings, buttons, placeholders, and other UI elements that should be using the multi-language system (either through `JSON.parse(payment_setting)`, `JSON.parse(eventsetting)`, `translate()` function, or similar translation mechanisms).

**Files that are correctly using multi-lang (for reference):**
- `contact-us/ContactUs.vue` - Uses `JSON.parse(contact_us)`
- `scam-alert/ScamAlert.vue` - Uses `JSON.parse(scam_alert_setting)`
- `testimonial/Testimonial.vue` - Uses `JSON.parse(testimonial_setting)`
- `success_stories/SuccessStories.vue` - Uses `JSON.parse(success_stories_setting)`
- `Rates/Index.vue` - Uses `JSON.parse(rates_setting)`

## Common Patterns Found:
- Payment-related labels: "Card Details", "Cardholder Name", "Order Summary"
- Button text: "Update Profile", "Submit", "Cancel", "Processing...", "Loading...", "Submitting..."
- Form labels: "Company Information", "Company Name", "Contact Person", "Confirm New Password"
- Status text: "Live", "Pending", "Draft", "Active", "Inactive"
- Placeholder text: "John Doe", "email@example.com", "https://yourcompany.com"
- Error messages: "This field is required"
- Loading states: "Loading...", "Processing...", "Submitting..."
