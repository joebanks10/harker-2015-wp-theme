module.exports = function(grunt) {

    // Load grunt tasks automatically
    require('load-grunt-tasks')(grunt);

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        clean: {
            bower: ['assets/src/js/vendor/bower.js'],
            css_src: ['assets/src/css/*'],
            css_dist: ['style.css', 'style-2.css'],
            css_tmp: ['assets/src/css/tmp'],
            scripts_dist: ['assets/js/*', '!assets/js/vendor'],
            scripts_tmp: ['assets/src/js/tmp'],
            img_dist: ['assets/img/*'],
            fonts_dist: ['assets/fonts/*'],
        },

        bower_concat: {
            js: {
                dest: 'assets/src/js/vendor/bower.js',
                exclude: [
                    'modernizr',
                    'jquery',
                    'hologram-github-theme'
                ],
                mainFiles: {
                    'waypoints': [
                        'lib/jquery.waypoints.js',
                        'lib/shortcuts/sticky.js',
                        'lib/shortcuts/inview.js',
                    ],
                    'foundation': [
                        'js/foundation/foundation.js',
                        'js/foundation/foundation.dropdown.js',
                        'js/foundation/foundation.equalizer.js',
                        'js/foundation/foundation.magellan.js'
                    ]
                }
            }
        },

        sass: {
            src: {
                options: {
                    sourcemap: 'none',
                    style: 'expanded',
                    compass: true,
                    loadPath: [
                        'assets/src/bower_components/foundation/scss',
                        'assets/src/bower_components/font-awesome/scss',
                        'assets/src/bower_components/jQuery.mmenu/src/scss',
                        'assets/src/bower_components/slick-carousel/slick'
                    ]
                },
                files: [{
                    expand: true,
                    cwd: 'assets/src/scss',
                    src: ['*.{scss,sass}'],
                    dest: 'assets/src/css',
                    ext: '.css'
                }]
            }
        },

        csssplit: {
            src: {
                src: ['assets/src/css/styles.css'],
                dest: 'assets/src/css/styles.css',
                options: {
                    maxSelectors: 3500, // 4095,
                    maxPages: 3,
                    suffix: '-'
                }
            },
        },

        file_append: {
            csssplit: {
                files: [{
                    prepend: '@charset "UTF-8";\n',
                    input: 'assets/src/css/styles-2.css',
                    output: 'assets/src/css/styles-2.css'
                }]
            }
        },

        cssmin: {
            options: {
                banner: '/*! <%= pkg.title %> | <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            css: {
                expand: true,
                cwd: 'assets/src/css/tmp',
                src: ['*.css', '!*.min.css'],
                dest: 'assets/src/css/tmp',
                ext: '.min.css'
            }
        },

        concat: {
            scripts: {
                src: ['assets/src/js/vendor/*.js', 'assets/src/js/*.js'],
                dest: 'assets/src/js/tmp/scripts.js'
            }
        },

        uglify: {
            options: {
                banner: '/*! <%= pkg.title %> | <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            scripts: {
                src: ['assets/src/js/tmp/scripts.js'],
                dest: 'assets/src/js/tmp/scripts.min.js'
            },
            modernizr: {
                src: 'assets/js/vendor/modernizr.js',
                dest: 'assets/js/vendor/modernizr.min.js'
            }
        },

        copy: {
            bower_fonts: {
                files: [{
                    expand: true,
                    cwd: 'assets/src/bower_components/font-awesome/fonts/',
                    dest: 'assets/src/fonts/vendor',
                    src: '*.*'
                },
                {
                    expand: true,
                    cwd: 'assets/src/bower_components/slick-carousel/slick/fonts',
                    dest: 'assets/src/fonts/vendor',
                    src: '*.*'
                }]
            },
            modernizr: {
                src: 'assets/src/bower_components/modernizr/modernizr.js',
                dest: 'assets/js/vendor/modernizr.js'
            },
            css_tmp: {
                files: [{
                    expand: true,
                    cwd: 'assets/src/css/',
                    dest: 'assets/src/css/tmp',
                    src: ['*.css']
                }]
            },
            css_dist: {
                // move first stylesheet to root for WordPress theme stylesheet
                files: [{
                    src: 'assets/src/css/tmp/styles-1.min.css',
                    dest: 'style.css'
                },
                {
                    src: 'assets/src/css/tmp/styles-2.min.css',
                    dest: 'style-2.css'
                }]
            },
            scripts: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: 'assets/src/js/tmp',
                    dest: 'assets/js',
                    src: ['{,*/}*.js']
                }]
            },
            img: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: 'assets/src/img/',
                    dest: 'assets/img/',
                    src: [
                        '**/*.{png,jpg,jpeg,gif,ico}'
                    ]
                }]
            },
            fonts: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: 'assets/src/fonts/',
                    dest: 'assets/fonts/',
                    src: [
                        '*.*',
                        'vendor/*.*'
                    ]
                }]
            }
        },

        watch: {
            css: {
                files: ['assets/src/scss/{,*/}*.{scss,sass}'],
                tasks: ['compile:css']
            },
            scripts: {
                files: ['assets/src/js/{,*/}*.js'],
                tasks: ['compile:scripts']
            },
            img: {
                files: ['assets/src/img/{,*/}*.*'],
                tasks: ['compile:img']
            },
            fonts: {
                files: ['assets/src/fonts/{,*/}*'],
                tasks: ['compile:fonts']
            }
        },

    });

    grunt.registerTask('compile:bower', [
        'clean:bower', // remove bower.js
        'bower_concat:js', // copy/concat component js files into src
        'copy:bower_fonts' // copy component fonts
    ]);

    grunt.registerTask('compile:sass', [
        'clean:css_src', // clean src/css folder
        'sass', // compile sass files
        'csssplit', // split css file for <IE8 support
        'file_append', // append UTF-8 header
    ]);

    grunt.registerTask('compile:css', [
        'compile:sass', // compile sass files to css
        'clean:css_dist',
        'copy:css_tmp', // copy css files to tmp folder
        'cssmin', // minify css
        'copy:css_dist', // copy css files to dist folder
        'clean:css_tmp' // delete tmp directory
    ]);

    grunt.registerTask('compile:scripts', [
        'clean:scripts_dist', // clean dist folder
        'concat:scripts', // concat into tmp directory
        'uglify:scripts',
        'copy:scripts', // move files to dist folder
        'clean:scripts_tmp' // delete tmp directory
    ]);

    grunt.registerTask('compile:modernizr', [
        'copy:modernizr',
        'uglify:modernizr'
    ]);

    grunt.registerTask('compile:img', [
        'clean:img_dist',
        'copy:img'
    ]);

    grunt.registerTask('compile:fonts', [
        'clean:fonts_dist',
        'copy:fonts'
    ]);

    grunt.registerTask('compile', [
        'compile:bower',
        'compile:css',
        'compile:scripts',
        'compile:modernizr',
        'compile:img',
        'compile:fonts'
    ]);

    grunt.registerTask('default' [
        'compile'
    ]);

};