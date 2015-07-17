#Tiny JSON API

This plugin lets your site handle `Accept:  application/json` headers.

##Setup

Activate. Visit `Settings > Permalinks` to flush rewrite rules. Then ask for JSON.

    curl http://mywpsite.com/hello-world -H 'Accept: application/json'
    => {title: "Hello World!", content: "Welcome to WordPress..."}

Want more data in your JSON? Filter `tjapi_before_encoding`. For privacy, filter `tjapi_available`.

##Filters

    apply_filters( 'tjapi_before_encoding', $json, $post )

Runs before the JSON is encoded so you can add or remove properties from the output.

    apply_filters( 'tjapi_available', true, $post )

Runs before any JSON is served. To restrict to logged in users:

    add_filter( 'tjapi_available', function() { return is_user_logged_in() } );
