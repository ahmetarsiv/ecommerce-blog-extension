# eCommerce Blog Extension
[![License](https://poser.pugx.org/bagisto/bagisto-gdpr/license)](https://github.com/ahmetarsiv/ecommerce-blog-extension/blob/master/LICENSE)

## 1. Introduction:

With the help of this module, the store owner can add a blog on the bagisto store. Since Blogs play a vital role in increasing the traffic on your site and also improves your website SEO, therefore, this module will be a gem to your website

* Multi-language support in blog post, category & tag
* Multi-channel support in a blog post only.
* SEO friendly URL eg: blog/page/{PAGE_NUMBER} blog/{PRIMARY_CATEGORY}/{POST_SLUG}
* Responsive image support
* Option to disable comment widget for individual post
* Post like button (only for theregisterd customer)
* Display categories and tags list with the number of posts count (option to disable post counts)
* The number of widgets such as show previous and next post in post detail page, recent posts in homepage, related posts in detail page, recent posts & comment with nested replies support etc.
* Option to limit the number of posts to display per page, related posts & recent post.
* Option to enable/disable author page, comment widget (globally), guest comment, comment moderation, email notification for a new comment to post’s author & Google reCaptcha for comment form to protect from spam
* Control the maximum nested comment depth


## 2. Requirements:

* **PHP**: 7.3 or higher.
* **Bagisto**: v1.4.*
* **Composer**: 1.6.5 or higher.

## 3. Installation:

Create packages/Webkul/Blog/ folders then follow the steps below

Open ‘app.php’ file inside ‘config’ folder & add your service provider inside the ‘providers’ array.

```
Webkul\Blog\Providers\BlogServiceProvider::class,
```

Goto ‘composer.json’ file and add following line under psr-4
```
"Webkul\\Blog\\": "packages/Webkul/Blog/src"
```
 
```
composer dump-autoload
```
Thank you to all our backers! 🙏

<a href="https://opencollective.com/arsivpro#contributors" target="_blank"><img src="https://opencollective.com/arsivpro/backers.svg?width=890"></a>
