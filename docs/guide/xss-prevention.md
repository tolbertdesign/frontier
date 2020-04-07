XSS Prevention
Contents
1	Laravel
1.1	When displaying non-html user input
1.2	When displaying html containing user input
1.3	When displaying user input inside of JSON
2	VueJS
2.1	When displaying non-html user input
2.2	When displaying html containing user input
Laravel
When displaying non-html user input
Use the Blade {{ }} syntax to display the variable.

When displaying html containing user input
Use a HTML Purifier (we currently use this library: https://github.com/stevebauman/purify). And then display the variable using the non-escaped Blade {!! !!} syntax.

When displaying user input inside of JSON
Use json_encode with the following options: JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS.

VueJS
When displaying non-html user input
Use the Vue {{ }} syntax to display the variable.

When displaying html containing user input
Make sure server side we are using a HTML Purifier (we currently use this library: https://github.com/stevebauman/purify). And then display the variable using the non-escaped v-html tag.
