# Harker WordPress Theme 2015

Genesis child theme for Harker's public-facing WordPress websites. Built off the Genesis Theme Framework. Sample site: [http://news.harker.org](http://news.harker.org)

## Dependencies

* Ruby 1.9+
* [Node.js](http://nodejs.org)
* [compass](http://compass-style.org/): `gem install compass`
* [bower](http://bower.io): `npm install bower -g`
* [grunt](http://gruntjs.com/): `npm install -g grunt-cli`
* [Genesis Theme Framework](http://my.studiopress.com/themes/genesis/)

## Getting Started

1. Add the Genesis theme framework and this child theme folder to your theme folder.
2. In the child theme, run `npm install` to install dev dependencies for project
3. Run `bower install` to install plugins and libraries
4. Run `grunt compile` to compile files to dist folder. Run `grunt watch` to watch for changes in src folder.

### Fixing mixin naming conflict between Foundation and Compass

The transition mixin isn't namespaced in Foundation, so it will conflict with Compass's version of the transition mixin when you compile. To fix, go to `bower_components/foundation/scss/foundation/components/_global.scss` and rename the transition mixin to something else (e.g. _transition). You'll need to also update the include statement in the single-transition mixin. 

Unfortunately, this edit will be overwritten on updates, but it's a temporary solution. Zurb is aware of the conflict.

## WordPress Plugins used with Theme

    * [Aesop Story Engine](https://wordpress.org/plugins/aesop-story-engine/): Longform story UI components
    * [Default featured image](https://wordpress.org/plugins/default-featured-image/) : Default featured image for stories
    * [Genesis Layout Extras](https://wordpress.org/plugins/genesis-layout-extras/): Used to set layout of home page and other templates
    * [Jetpack](https://wordpress.org/plugins/jetpack/): Used for infinite scroll
    * [Top 10](https://wordpress.org/plugins/top-10/): Used for trending stories widget
    * [Flow Flow](http://flow.looks-awesome.com/): Used for social feed widget 
    * [Image Widget](https://wordpress.org/plugins/image-widget/): Used to place logos/images in sidebar or top banner
