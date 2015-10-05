# Require any additional compass plugins here.
add_import_path "assets/src/bower_components/foundation/scss"
add_import_path "assets/src/bower_components/font-awesome/scss"
add_import_path "assets/src/bower_components/jQuery.mmenu/src/scss"
add_import_path "assets/assets/src/bower_components/slick-carousel/slick"

# Set this to the root of your project when deployed:
http_path = "/"
http_images_path = "http://www.harker.org/uploaded/themes/corporate-2015/img/css/"

css_dir = "assets/src/css"
sass_dir = "assets/src/scss"
images_dir = "assets/src/img/css"
javascripts_dir = "assets/src/js"
fonts_dir = "assets/src/fonts/vendor"

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed
# output_style = :expanded

# To enable relative paths to assets via compass helper functions. Uncomment:
relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
# line_comments = false

# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass
