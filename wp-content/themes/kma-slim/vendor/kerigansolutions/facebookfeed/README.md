# KMA WordPress Facebook Feed
Easily pull posts and events into your WordPress Site from a Facebook page that you manage.
## Installation
`composer require kerigansolutions/facebookfeed`
## Setup
### Get your Facebook Page ID and Access token
- Facebook Page ID
    + Open your Facebook Page
    + Click "About"
    + Scroll down to the "More Info" section
    + Under Page ID, you will find your page ID
- App Access Token
    + Create a new app in the [Facebook Developer Console](https://developers.facebook.com/apps/)
    + Use the [Access Token tool](https://developers.facebook.com/tools/accesstoken/) to retrieve your App Access Token

- Add your Facebook Page ID and Access Token to `wp-config.php`
```
define('FACEBOOK_PAGE_ID', 'YOUR FACEBOOK PAGE ID HERE');
define('FACEBOOK_ACCESS_TOKEN', 'YOUR FACEBOOK TOKEN HERE');
```
## Quick Start
```php

$facebookFeed  = new KeriganSolutions\FacebookFeed\FacebookFeed();
$numberOfPosts = 5;

$results = $facebookFeed->fetch($numberOfPosts);

echo '<pre>',print_r($results),'</pre>';

```
## Pagination
This package uses the default cursor-based pagination that is returned by the Facebook Graph API. Let's take a look at how to implement this in our WordPress site:
### Make the API call and retrieve the results:
```php
$facebookFeed  = new KeriganSolutions\FacebookFeed\FacebookFeed();
$numberOfPosts = 5;

$results = $facebookFeed->fetch($numberOfPosts);
```
We've covered this already. So far, so good. Let's look at the returned data:
```
stdClass Object
(
    [posts] => Array
        (
            [0] => stdClass Object
                (
                    [permalink_url] => https://www.facebook.com/XXXXXXXX/posts/1989865411030718
                    [full_picture] => https://scontent.xx.fbcdn.net/v/t31.0-8/s720x720/24958917_1989865411030718_66...
                    [object_id] => 1989865411030718
                    [type] => photo
                    [status_type] => added_photos
                    [created_time] => 2017-12-10T22:51:24+0000
                    [link] => https://www.facebook.com/XXXXXX/photos/a.1989861894364403.1...
                    [attachments] => stdClass Object
                        (
                            [data] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [target] => stdClass Object
                                                (
                                                    [url] => https://www.facebook.com/media/set/?set=ms.c.eJxNV1...
                                                )

                                            [media] => stdClass Object
                                                (
                                                    [image] => stdClass Object
                                                        (
                                                            [height] => 478
                                                            [src] => https://scontent.xx.fbcdn.net/v/t31.0-8/s720x72..
                                                            [width] => 720
                                                        )

                                                )

                                        )

                                )

                        )

                    [id] => 167644949919449_1989865411030718
                )

        )

    [paging] => stdClass Object
        (
            [cursors] => stdClass Object
                (
                    [before] => Q2c4U1pXNTBYM0YxWlhKNVgzTjBiM0o1WDJ....
                    [after] => Q2c4U1pXNTBYM0YxWlhKNVgzTjBiM0o1WDJs...
                )

            [next] => https://graph.facebook.com/v2.11/167644949919449/posts?access_token=3119470492897...
        )

)
```

From the [Facebook Graph API docs](https://developers.facebook.com/docs/graph-api/using-graph-api):
>    `before` : This is the cursor that points to the start of the page of data that has been returned. 
>
>    `after` : This is the cursor that points to the end of the page of data that has been returned.
>
>    `next` : The Graph API endpoint that will return the next page of data. If not included, this is the last page of data. Due to how pagination works with visibility and privacy, it is possible that a page may be empty but contain a 'next' paging link. Stop paging when the 'next' link no longer appears.
>
>    `previous` : The Graph API endpoint that will return the previous page of data. If not included, this is the first page of data.

### What does this mean?
Now we know where the data starts and stops so we can get our next five results by passing some new arguments to the `fetch` function. Observe:
```php
$facebookFeed  = new KeriganSolutions\FacebookFeed\FacebookFeed();
$numberOfPosts = 5;
$before        = null;
$after         = 'Q2c4U1pXNTBYM0YxWlhKNVgzTjBiM0o1WDJs...';

$results = $facebookFeed->fetch($numberOfPosts, $before, $after);

echo '<pre>',print_r($results),'</pre>';

```
*NOTE: Cursors can change frequently and without warning from Facebook. DO NOT STORE cursors. Grab them dynamically and pass them to the next page using GET variables or another similar method*

## Embedded videos
In order to handle embedding videos from your Facebook statuses on to your WordPress page, you'll need to conditionally check if the `post->type` is `video`, set up a standard iframe and pass the returned `link` value for the post into the `src` attribute. The package currently handles embedded Facebook, Vimeo, and Youtube videos. 

## Events
Events are handled similarly to posts.
```php
$fb     = new KeriganSolutions\FacebookFeed\FacebookEvents();
$before = null;
$after  = null;
$events = $fb->fetch(10, $before, $after);

echo '<pre>',print_r($events),'</pre>';
```

Docs are a work in progress and a more in-depth guide will be coming soon.

