=== Plugin Name ===
Contributors: marceljm
Donate link: https://donorbox.org/fifu
Tags: featured, image, url, video, woocommerce
Requires at least: 5.3
Tested up to: 5.7
Stable tag: 3.6.2
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Use an external image as featured image of a post or WooCommerce product. Includes image search, video, social tags, SEO, lazy load, gallery, automation etc.

== Description ==

### WordPress plugin for external featured image

Since 2015 FIFU has helped thousands of websites worldwide to save money on storage, processing and copyright.

If you are tired of wasting time and resources with thumbnail regeneration, image optimization and never-ending imports, this plugin is for you.

#### FEATURED IMAGE
Use an external image as featured image of your post, page or custom post type.

* External featured image
* Unsplash image search
* Default featured image
* Hide featured media
* Featured image in content
* Elementor widget
* Auto set image title
* Save image dimensions
* Featured image column
* **[PRO]** Save in the media library
* **[PRO]** Giphy image search
* **[PRO]** Unsplash image size
* **[PRO]** Same height
* **[PRO]** Hover effects
* **[PRO]** Replace not found image
* **[PRO]** Image validation

#### AUTOMATIC FEATURED MEDIA

* Auto set featured image/video using img/iframe tag from post content
* **[PRO]** Auto set featured image using post title and search engine
* **[PRO]** Auto set featured image using ISBN and books API
* **[PRO]** Auto set screenshot as featured image
* **[PRO]** Auto set featured image using web page address

#### PERFORMANCE

* CDN + optimized thumbnails
* Lazy load
* **[PRO]** Flickr thumbnails

#### SOCIAL

* Social tags
* **[PRO]** Media RSS tags
* **[PRO]** bbPress features

#### AUTOMATION

* WP-CLI integration
* **[PRO]** WP All Import add-on
* **[PRO]** WooCommerce import
* **[PRO]** WP REST API
* **[PRO]** WooCommerce REST API
* **[PRO]** Schedule metadata generation

#### WOOCOMMERCE

* External product image
* Lightbox and zoom
* Category image on grid
* **[PRO]** External image gallery
* **[PRO]** External video gallery
* **[PRO]** Auto set category images
* **[PRO]** Variable product
* **[PRO]** Variation image
* **[PRO]** Variation image gallery
* **[PRO]** Save images in the media library
* **[PRO]** FIFU product gallery

#### FEATURED VIDEO
Supports videos from YouTube, Vimeo, Imgur, 9GAG, Cloudinary, Tumblr, Publitio, JW Player, WordPress.com (Jetpack Video Hosting) and Sprout.

* **[PRO]** Featured video
* **[PRO]** Video thumbnail
* **[PRO]** Play button
* **[PRO]** Minimum width
* **[PRO]** Black background
* **[PRO]** Mouseover autoplay
* **[PRO]** Autoplay
* **[PRO]** Loop
* **[PRO]** Mute
* **[PRO]** Background video
* **[PRO]** Related videos
* **[PRO]** Gallery icon

#### WIDGETS

* **[PRO]** Featured media 
* **[PRO]** Featured grid 

#### OTHERS

* **[PRO]** Featured slider 
* **[PRO]** Featured shortcode 

#### INTEGRATION FUNCTION FOR DEVELOPERS

* fifu_dev_set_image(post_id, image_url)
* **[PRO]** fifu_dev_set_image_list(post_id, image_url_list)

#### LINKS

* **<a href="https://fifu.app/">Featured Image from URL PRO</a>**	
* **<a href="https://chrome.google.com/webstore/detail/fifu-scraper/pccimcccbkdeeadhejdmnffmllpicola">Google Chrome extension</a>**


== Installation ==

### INSTALL FIFU FROM WITHIN WORDPRESS

1. Visit the plugins page within your dashboard and select 'Add New';
1. Search for 'Featured Image from URL';
1. Activate FIFU from your Plugins page;

### INSTALL FIFU MANUALLY

1. Upload the 'featured-image-from-url' folder to the /wp-content/plugins/ directory;
1. Activate the FIFU plugin through the 'Plugins' menu in WordPress;


== Frequently Asked Questions ==

= Where is the external featured image box? =

* Next to the regular featured image box, in the post editor.

= Why isn't preview button working? =

* Your image URL is invalid. Take a look at FIFU Settings > Getting started.

= Does FIFU save the images in the media library? =

* No. Only the PRO version is capable of doing this, but it is optional. The plugin was designed to work with external images.

= Is any action necessary before removing FIFU?

* Access settings and clean the metadata.

= What's the metadata created by FIFU?

* Database registers that help WordPress components to work with the external images. FIFU can generate the metadata of ~50,000 image URLs per minute.

= What are the disadvantages of the external images?

* No image optimization or thumbnails. You can fix that with Jetpack plugin (performance settings).

= What are the advantages of the external images?

* You save money on storage, processing and copyright. And you can have extremely fast import processes.


== Screenshots ==

1. Just insert the image address or some keywords and click on preview button

2. If the image URL is correct, the image will be shown

3. Featured video

4. Featured slider

5. Featured image column

6. External featured media on home

7. External featured image on post

8. Featured video on post

9. Featured slider on post

10. Many settings

11. External image gallery

12. External video gallery

13. External featured media on WooCommerce shop

14. External featured media on cart

15. External image gallery

16. External featured image on lightbox

17. Zoom

18. Video gallery

19. Featured video on lightbox

20. Fullscreen


== Changelog ==

= 3.6.2 =
* Improvement: query optimizations (for sites with hundreds of thousands of URLs); improvement: CDN + Optimized Thumbnails (perfect image croppig for less style issues); improvement: Save Image Dimensions (150% faster, CLI integration); deprecated: CDN + Optimized Thumbnails > Shortpixel; fix: Lazy Load (conflict with AMP plugin).

= 3.6.1 =
* New: FIFU widgets for WordPress and Elementor.

= 3.6.0 =
* New features: for bbPress (Settings > Social > bbPress); improvement: Auto set featured image using post title and search engine (faster and unlimited now); improvement: Auto set featured image using ISBN and books API (faster and unlimited now); improvement: added FIFU fields to bbPress custom post types (Forum, Topic and Reply).

= 3.5.9 =
* New option: Featured slider > display images in the same height; new file: attached XML example for WP All Import plugin (Variations As Child XML Elements); new site: https://featuredimagefromurl.com/.

= others =
* [more](https://fifu.app/changelog)


== Upgrade Notice ==

= 3.6.2 =
* Improvement: query optimizations (for sites with hundreds of thousands of URLs); improvement: CDN + Optimized Thumbnails (perfect image croppig for less style issues); improvement: Save Image Dimensions (150% faster, CLI integration); deprecated: CDN + Optimized Thumbnails > Shortpixel; fix: Lazy Load (conflict with AMP plugin).
