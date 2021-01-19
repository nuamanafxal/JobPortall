=== ACF Frontend Form for Elementor - Add and edit posts, pages, users and more ===
Contributors: shabti, ronena
Tags: elementor, acf, acf form, frontend editing, acf elementor intergration
Requires at least: 4.6
Tested up to: 5.5.0
Stable tag: Stable
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

An ACF and Elementor extension that allows you to easily display ACF frontend forms for your users in the Elementor Editor so your users can edit content by themselves from the frontend.

== Description ==

An ACF and Elementor extension that allows you to easily display ACF frontend forms for your users in the Elementor Editor so your users can edit content by themselves from the frontend. 

This plugin needs to have both Elementor and Advanced Custom Fields installed and activated. You can create awesome forms in ACF which save custom meta data to pages, posts, users, and more. Then use this widget in Elementor to easily display the form for your users. This way you can pick and choose the data which you need them to be able to edit.  

So, what can this plugin do for you?

== FREE Features ==

1. No Coding Required
Give the end user the best content managment experience without having to open the ACF or Elementor documentations. It’s all ready to go right here. 

2. Edit Posts 
Let your users edit posts from the frontend of their site without having to access the WordPress dashboard. 

3. Add Posts 
Let your users publish new posts from the frontend using the “new post” widget

4. Delete Posts 
Let your users delete or trash posts from the frontend using the “trash button” widget

5. Edit User Profile
Allow users to edit their user data easily from the frontend.

6. User Registration Form
Allow new users to register to your site with a built in user registration form! You can even hide the WordPress dashboard from these new users.

7. Hide Admin Area 
Pick and chose which users have acess to the WordPress admin area.

8. Configure Permissions
Choose who sees your form based on user role or by specific users.

9. Modal Popup 
Display the form in a modal window that opens when clicking a button so that it won’t take up any space on your pages.


== PRO Features ==

1. Edit Global Options 
If you have global data – like header and footer data – you can create an options page using ACF and let your users edit from the frontend. (Option to add options pages without coding coming soon)

2. Limit Submits
Prevent all or specific users from submitting the form more than a number of times.

3. User Role Field 
Allow users to choose a role when editing their profile or registering.

4. Send Emails 
Set emails to be sent and map the ACF form data to display in the email fields such as the email address, the from address, subject, and message. 

5. Style Tab
Use Elementor to style the form and as well the buttons. 

6. Multi Step Forms 
Make your forms more engaging by adding multiple steps.

7. Stripe and Paypal 
Accept payments through Stripe or Paypal upon form submission. 

8. Woocommerce Intergration 
Easily add Woocomerce products from the frontend.
 

Purchase your copy here at the official website: [ACF Frontend website](https://www.frontendform.com/)


== Useful Links ==
Appreciate what we're doing? Want to stay updated with new features? Give us a like and follow us on our facebook page: 
[ACF Frontend Facebook page](https://www.facebook.com/acffrontend/)

The Pro version has even more cool features. Check it out at the official website:
[ACF Frontend website](https://www.frontendform.com/)

Check out our other plugin, which let's you dynamically query your posts more easily: 
[Advanced Post Queries for Elementor](https://wordpress.org/plugins/advanced-post-queries/)

Check out Elementor Pro. We highly recommend pro for anyone who is looking to get more out of WordPress and Elementor:
[Elementor Pro](https://elementor.com/pricing/)

Now is the time to buy ACF Pro before they take up the prices and no longer provide lifetime licences:
[Advanced Custom Fields Pro](https://www.advancedcustomfields.com/pro/)

== Installation ==

1. Make sure both Elementor and ACF are installed and activated. This plugin will not do anything without both of them. 
2. Upload the plugin files to the `/wp-content/plugins/acf-frontend-form-elements` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress
4. Create an ACF field group. It can be either active or not, it doesn't matter. 
5. Jump into the Elementor editor and search for "ACF frontend form" 
6. Choose the desired ACF field group or leave as is for the current post's default field group. You may also choose specific fields.
7. Configure the permisions, display, and form actions as you please.
8. Now you should an acf form on the frontend for editing a post, adding a post, or editing a user.


== Tutorials ==  

= Add and Edit a Real Estate Listing =
https://www.youtube.com/watch?v=iHx7krTqRN0

= Frontend Posting =
https://www.youtube.com/watch?v=lMkZzOVVra8&t=7s

== Frequently Asked Questions ==

= Can I send emails through this form? =

You can use a ACF "action hook" to send emails when this form is registered. See <a href="https://www.advancedcustomfields.com/resources/using-acf_form-to-create-a-new-post/"> here </a> for reference.

If you purchase our pro version, you will be able to configure this from the widget without any code. You will be able to send any number of emails upon form submission. 

= Can I add Featured Image field to the form? =

Yes. Simply open the post tab and turn on "Featured Image". 

If you want more control over the label and field settings, simply add an image field in your ACF field group and set the field name to “_thumbnail_id” with an underscore before each word. 

= Can I let users set post categories through this form? =

Yes. Add a taxonomy field in your ACF field group and set "save terms" and "load terms" to yes. 


== Screenshots ==

1. This is the basic usage. The form displays the post's default ACF field groups. In our case, this post has no ACF field groups so it displays just the title by default. The form is visible by default only to administrators and will edit the current post/page. 
2. In this screenshot, we changed the form title to Business Information, we removed the title field and chose an ACF field group named "FrontEnd Form" to display. 
3. Here we configured the permissions. We left the default administrator role and we added a dynamic option that let's you choose a meta field that gives an id of any given user who should see this. In this case we used "[author]" which allows the author of the post to see it.
4. In the form actions, we left the main form action as "edit post" and we chose to edit a specific post. We left the rest of the option default, but we turned on the delete button so that our users have the option to delete the post if they so wish.

== Changelog ==

= 2.6.11 =
* Fixed bug with edit user form
* Added option to add default featured image

= 2.6.10 =
* Fixed errors with multi step form

= 2.6.9 =
* Fixed issue with edit post form settings not saving
* Fixed issue with two ajax forms on same page

= 2.6.8 =
* Fixed ajax errors when updating Elementor
* Added Ajax success message when creating a new post in Pro

= 2.6.7 =
* Fixed issue with email user shortcodes
* Fixed issue with post status in multi step forms

= 2.6.6 =
* Fixed dynamic default value on new posts

= 2.6.5 =
* Fixed error

= 2.6.4 =
* Fixed issue that prevented title value from loading

= 2.6.3 =
* Fixed pot translation files
* Added option to hide admin area by role 
* Added option to disable the option to hide admin area by user
* Added option to redirect users from WP dashboard to any url 

= 2.6.2 =
* Fixed multi step conditional logic error
* Fixed email content error
* Added dynamic default value option to title field

= 2.6.1 =
* Fixed email shortcodes
* Fixed bug preventing submitting forms that don't require payment

= 2.6.0 =
* Added Stripe and Paypal Credit Card options for taking payments for new post submissions
* Added option to show success message

= 2.5.41 =
* Fixed Display Name field not saving
* Fixed Wyswyg styling errors

= 2.5.40 =
* Fixed repeater rows author filtering rows display by author
* Fixed H1 tag appearing on all pages

= 2.5.39 =
* Fixed bug with multi step new post form
* Added option to filter repeater rows based on row author

= 2.5.37 =
* Fixed bug not showing field labels on live page 

= 2.5.36 =
* Fixed field default value, placeholder and label not showing dynamic value

= 2.5.35 =
* Added default value option to text based fields
* Added read only option to text based fields
* Added disabled option to all fields
* Added option to hide a field from view
* Fixed Taxonomy fields not loading

= 2.5.34 =
* Added option to leave message for users who are not allowed to view form
* Added permissions options to steps

= 2.5.33 =
* Limited free 7 day trial notice to the ACF Frontend settings page
* Added option to choose which post gets deleted or trashed by the Trash Button
* Added more redirect options upon deleting or trashing a post/product 

= 2.5.32 =
* Fixed post drafts not publishing issue
* Fixed issue with post draft validation

= 2.5.31 =
* Fixed Anywhere Elementor conflict

= 2.5.30 =
* Fixed missing field groups issue
* Fixed missing taxonomy fields

= 2.5.29 =
* Fixed custom taxonomy field issue
* Fixed message field issue

= 2.5.28 =
* Fixed missing file error

= 2.5.27 =
* Fixed error with multi step new products form

= 2.5.26 =
* Fixed error on Elementor Pro single templates 

= 2.5.25 =
* Added option to allow users to update their usernames. Warning: this can affect your urls and their SEO ratings
* Added option to hide success message
* Added option to allow user manager to edit other user profiles
* Fixed bug with message field not showing on frontend
* Fixed bug with title structure

= 2.5.24 =
* Fixed Pro trial message not being dismissed
* Fixed multisite error

= 2.5.23 =
* Added missing "new post" in main action
* Fixed bug in new post form submission

= 2.5.21 =
* Added a styling tab to each field with margin, padding and width styles
* Added placeholder option for text-based fields
* Added option to add default display name
* Added option to add default username
* Fixed some bugs with the registration form


= 2.5.20 =
* Fixed previous step password fields causing validation errors
* Fixed text editor appearing on non Elementor pages

= 2.5.19 =
* Fixed confirm password field validation issue
* Added option to save User Email as Username

= 2.5.18 =
* Fixed field width issue on RTL sites

= 2.5.17 =
* Added option to display taxonomy, categories and tags fields in dropdowns or radio buttons
* Added option to add new terms in taxonomy, categories and tags fields 

= 2.5.16 =
* Fixed issue with user role field
* Fixed issue with user email sending notice when registering

= 2.5.15 =
* Fixed issue with Ajax validation
* Fixed missing submit spinner

= 2.5.14 =
* Fixed issue with last step of multi step form not redirecting
* Added all Woocommerce product inventory fields
* Added user nickname and user display name fields

= 2.5.13 =
* Fixed issue with duplicate fields saving in database
* Fixed product images field not saving images to product images 
* Added better suppoirt for Elementor popups

= 2.5.11 =
* Added ACF conditional logic support to multi step forms 
* Fixed last step of multi step forms not redirecting to custom url 
* Fixed user fields not loading saved value 
* Fixed taxonomy field type had no taxonomy selection

= 2.5.10 =
* Moved Local Avatar and Uploads Privacy settings to ACF Frontend admin page
* Added dynamic tag for user local avatars to replace the default gravatar ( requires Elementor Pro )
* Fixed two lines appearing after field groups
* Fixed issue that prevented trashing posts of custom type rather than deleting them

= 2.5.9 =
* Fixed error showing hidden input

= 2.5.8 =
* Fixed issue with multi step created new posts each step

= 2.5.7 =
* Fixed error with migration query

= 2.5.5 =
* Added option to trash posts instead of deleting them in the delete post button
* Optimized the migration of old widget setting to the widget settings
* Fixed repeating field groups issue
* Fixed field group tab issue

= 2.5.4 =
* Fixed error when saving widget in template
* Fixed step tabs

= 2.5.3 =
* Fixed Google Maps issue

= 2.5.2 =
* WARNING: this updates the database. Please back up your database before updating
* Restructured the fields selection so that all of the fields are in one place in the editor. Now you can reorder the fields
* Restructered the multi step option so that it is more similar to Elementor's multi step option
* Seperated confirm password and password strength check 
* Added option to add content inside the form
* Added multi step option to all the form widgets

= 2.4.19 =
* Fixed issue with excluding fields option

= 2.4.18 =
* Fixed issue with duplicating fields in latest update

= 2.4.16 =
* Added option to display choice fields and image fields to comments list widget 

= 2.4.15 =
* Fixed Url not showing right on localhost in the new Edit Button widget 

= 2.4.14 =
* Added Edit Button and Delete Button widgets to single template

= 2.4.13 =
* Fixed Comments List widget bugs
* Fixed label and instruction spacing styles not working

= 2.4.12 =
* Added Comments List widget in Pro

= 2.4.11 =
* Removed default value from the default post title option

= 2.4.9 =
* Added no page reload option in pro (still in development)

= 2.4.8 =
* Fixed bug when adding post and editing on same page
* Added Default title and default featrured image options to post and product actions/widgets
* Added some more frontend Woocommerce fields

= 2.4.7 =
* Added New Comment action and widget in pro

= 2.4.6 =
* Added Site Options, Add and Edit Product widgets in pro

= 2.4.5 =
* Added Edit User and New User Widgets
* Added ability to add url parameters to the redirect
* Added option to preview redirect
* Limited the editing privilage to post author when Post to Edit is set to URL Query in Edit Post action 
* Fixed the update message showing in all posts 

= 2.4.3 =
* Fixed widget bug

= 2.4.2 =
* Added "Edit Post Form" widget
* Added "New Post Form" widget
* Added redirect and icon options to Delete Post Button option and widget
* Added icon option to modal button

= 2.4.1 =
* Fixed issue with Modal button

= 2.4.0 =
* Added Paypal option to forms in pro (BETA)
* Added Paypal button widget (BETA)
* Added Category for Widgets

= 2.3.35 =
* Added option to either clear new post from form or edit it

= 2.3.34 =
* Fixed bug with custom password

= 2.3.33 =
* Fixed Confirm Password field errors
* Fixed error with multi step fields

= 2.3.31 =
* Fixed bug that was reloading page instead of redirecting users to new post when "new post url" was selected 

= 2.3.30 =
* Fixed error trying to call product action functions when Woocomerce not installed

= 2.3.28 =
* Fixed error with custom price fields
* Fixed error with Woocomerce categories and tags
* Added responsive width to all built-in fields
* Added Google reCaptcha field in Pro
* Tweaked the page reload on new posts and users to load the newly added post data in the form

= 2.3.27 =
* Fixed error with site tagline field

= 2.3.26 =
* Added Happy files integration to ACF file field, image field, and gallery field.
* Added custom "product images" field on frontend for Woocommerce users
* Added custom "product sale price" field on frontend for Woocommerce users
* Added option to edit a post based on a URL query
* Fixed issue with "title structure" option on new submissions
* Fixed issue that was creating two users during the multi step form

= 2.3.23 =
* Added option to exclude field from field groups selection for faster setup
* Added option to add default field groups faster setup

= 2.3.22 
* Fixed product categories field was loading WP categories
* Custom title structure was not saving on initial submission

= 2.3.21 =
* Tweak: Added automatic login option to registration form
* Added custom structure to title field
* Added custom post slug option for posts
* Added custom product price option to number fields
* Added New Product and Edit Product actions in pro. Woocommerce integration phase one.
* Fixed edit user action to be able to choose whether or not to require passwords
* Fixed validation error on default fields
* Fixed Site Title field not saving

= 2.3.20 =
* Fixed ACF tabs not working

= 2.3.19 =
* Fixed multi step previous button, which was activating the field validations
* Fixed confirm password bug not validating properly

= 2.3.17 =
* Fixed multi step tabs not showing properly on vertical align

= 2.3.16 =
* Fixed error of post titls not saving as slug for CPT
* Fixed error of not saving username

= 2.3.15 =
* Fixed error: Custom Post data fields were loading and saving the wrong data

= 2.3.14 = 
* Fixed error in multi form

= 2.3.13 = 
* Added options to default fields
* Removed custom post and user field selection from the widget settings
* Fixed some JS errors

= 2.3.7 = 
* Added Stripe action
* Added a Delete Post Button widget
* Added option to remove border between fields
* Optimized the assets to load only where needed

= 2.3.6 = 
* Fix: There was a bug on the edit user action that we squashed
* Tweak: Added Custom Labels for the built in user fields

= 2.3.5 = 
* Added Tabs Position option: side or top
* Added multi step tabs navigation to preview
* Emails in multi step form were sending in first step even when not specified
* Email user shorcodes fixed

= 2.3.1 = 
* Important: Changed the email shortcodes to be written without a underscore before it. For example: 'post_title' instead of '_post_title'
* Important: Changed the default site option fields to be deactivated by default. Activate them in the options tab if they are needed 
* Fix: multi step forms were not saving new posts properly 
* Tweak: Added validation to username to block illegal characters 
* Tweak: Added option to force strong password and confirm
* Tweak: Repositioned the save draft button and added styling options for it
* Tweak: Added email shortcode support for featured image and post url as well as fields with multiple values
* Tweak: Added option to show custom content or nothing for reached limit
* Coming soon: Stripe
* Coming soon: Woocomerce


= 2.2.15 = 
* Fix: multi step forms not showing some of the default user fields and not submitting to next step

= 2.2.14 = 
* Fix: Multi forms and custom labels were not working together
* Fix: Messages were always on edit screen

= 2.2.13 =  
* Fixed the Elementor select controls in the widget to comply with Elementor 2.9
* Fixed conflict with free Elementor version caused by autocomplete controls by replacing them with text field for inserting post, user, and term ids for Elementor free version only
* Fixed bug in query which was showing all drafts in the draft selection


= 2.2.12 = 
* Tweak: Added custom label options to default post fields so that you don't need to create a whole ACF field just to change the label. Available for post actions in free version and for edit options action in pro. Coming soon for user actions.
* Fix: fixed bug that was saving posts as drafts when save as draft was turned off
* Fix: fixed bug that was preventing saved drafts from showing when adding a post of a custom type

= 2.2.11 = 
* Fixed bug preventing featured images from saving on certain custom post types since 2.2.10
* Removed default ACF options page. Will return as option in 2.3
* Tweak: limited drafts shown in new post form to those submitted by author
* Tweak: fixed the save progress toggle to always show before submit button

= 2.2.10 = 
* Please note: Changed "set as title field" in ACF text field settings to save data from admin dashboard as well as frontend
* Please note: Changed "set as content field" in ACF wysiwig and textarea field settings to save data from admin dashboard as well as frontend
* Please note: Changed "set as excerpt field" in ACF textarea field settings to save data from admin dashboard as well as frontend
* Added a plugin admin page
* Optimized the widget in the Elementor editor by loading posts, users, and terms selections' values with autocomplete
* Added option to let users save a draft on new post action
* Added option to let users edit saved draft on new post action
* Added ACF options to allow you to create custom featured image field and to create read-only text fields
* Added default site option fields to allow users to edit site title, tagline, and logo in pro
* Added popover for email shortcodes in the editor in pro

= 2.2.9 = 
* Added default user fields: First Name, Last Name, and Biography
* Fixed bug in ACF settings when switching field type
* Fixed a bug with the ACF field selections
* Added option to create new post with many steps
* Added styles for steps in pro
* Added styles for ACF icons in pro
* Added more options to multi step in pro
 
= 2.2.8 = 
Changed required mark to show by default
* Fixed bug preventing the form from showing when "all users" is chosen in the permissions tab
* Fixed bug preventing field group names from showing in fields selection

= 2.2.7 = 
* Added hook that hides all default ACF Frontend fields from dynamic tags
Returned option to hide admin area to backend user forms
* Fixed permissions bug preventing form from appearing when first added

= 2.2.6 = 
* Fixed error with ACF image fields

= 2.2.5 = 
* Fixed bug in the logged in users setting in the permissions tab

= 2.2.4 = 
* Added tags setting to post actions
* Added post status setting to edit post action

= 2.2.3 = 
* Added default post categories and tags fields
* Added label display options
* Added styles for modal window, messages, fields, labels, and add more buttons in pro

= 2.2.2 = 
* Fixed error in dynamic selection setting in permissions tab

= 2.2.1 = 
* Added Freemius opt-in so that we can use shared data to make this plugin freaking awesome!
* Added promos for pro features.
* Added user auto-populate options and local ACF avatar




== Upgrade Notice ==





