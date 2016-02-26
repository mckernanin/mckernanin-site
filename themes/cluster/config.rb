require 'compass/import-once/activate'
# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
http_path = "/"
css_dir = "assets/css"
sass_dir = "assets/scss"
images_dir = "assets/img"
javascripts_dir = "assets/js"

output_style = :expanded
environment = :production

# To enable relative paths to assets via compass helper functions. Uncomment:
# relative_assets = true

line_comments = false
color_output = false

# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
preferred_syntax = :scss
# sass_options = { :debug_info => true }
# and then run:
# sass-convert -R --from scss --to sass assets/sass scss && rm -rf sass && mv scss sass


require 'fileutils'
on_stylesheet_saved do |file|
  if File.exists?(file) && File.basename(file) == "style.css"
    puts "Moving: #{file}"
    FileUtils.mv(file, File.dirname(file) + "/../../" + File.basename(file))
  end
end
