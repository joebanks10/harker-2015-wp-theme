module.exports = function(grunt) {

    // Load grunt tasks automatically
    require('load-grunt-tasks')(grunt);

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        watch: {
            src: {
                files: ['assets/src/scss/{,*/}*.{scss,sass}'],
                tasks: ['compile:css']
            },
            dist: {
                files: [
                    'assets/src/scss/{,*/}*.{scss,sass}',
                    'assets/src/js/{,*/}*.js',
                    'assets/src/fonts/{,*/}*',
                    'assets/src/img/{,*/}*.*'
                ],
                tasks: ['build']
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

        clean: {
            dist: {
                dot: true,
                src: [
                    'assets/dist/*',
                    '!assets/dist/.git*'
                ]
            },
            bower: ['assets/src/js/vendor/bower*.js'],
            css: ['assets/src/css/*']
        },

        // Concat Bower JS files. CSS styles are imported via SASS.
        bower_concat: {
            dist: {
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
            // css: {
            //     cssDest: 'assets/src/css/vendor/bower.css',
            //     exclude: [
            //         'foundation',
            //         'font-awesome'
            //     ]
            // }
        },

        concat: {
            js: {
                src: ['assets/src/js/vendor/*.js', 'assets/src/js/*.js'],
                dest: 'assets/dist/js/scripts.js'
            }
        },

        cssmin: {
            options: {
                banner: '/*! <%= pkg.title %> | <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            css: {
                expand: true,
                cwd: 'assets/dist/css',
                src: ['*.css', '!*.min.css'],
                dest: 'assets/dist/css',
                ext: '.min.css'
            }
        },

        imagemin: {
            dist: {
                files: [{
                    expand: true,
                    cwd: 'assets/src/img/',
                    src: ['**/*.{png,jpg,jpeg,gif}'],
                    dest: 'assets/src/img/'
                }]
            }
        },

        uglify: {
            options: {
                banner: '/*! <%= pkg.title %> | <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            js: {
                src: ['assets/dist/js/scripts.js'],
                dest: 'assets/dist/js/scripts.min.js'
            },
            modernizr: {
                src: 'assets/dist/js/vendor/modernizr.js',
                dest: 'assets/dist/js/vendor/modernizr.min.js'
            }
        },

        copy: {
            modernizr: {
                src: 'assets/src/bower_components/modernizr/modernizr.js',
                dest: 'assets/dist/js/vendor/modernizr.js'
            },
            bower: {
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
            css: {
                files: [{
                    expand: true,
                    cwd: 'assets/src',
                    dest: 'assets/dist',
                    src: ['css/*.css']
                }]
            },
            wp_style: {
                // move first stylesheet to root for WordPress theme stylesheet
                files: [{
                    src: 'assets/dist/css/styles-1.min.css',
                    dest: 'style.css'
                },
                {
                    src: 'assets/dist/css/styles-2.min.css',
                    dest: 'style-2.css'
                }]
            },
            dist: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: 'assets/src',
                    dest: 'assets/dist',
                    src: [
                        'fonts/*.*',
                        'fonts/vendor/*.*',
                        'img/**/*.{png,jpg,jpeg,gif}'
                    ]
                }]
            }
        }

    });

    grunt.registerTask('bower', [
        'clean:bower',
        'bower_concat',
        'copy:bower'
    ]);

    grunt.registerTask('compile:css', [
        'clean:css',
        'sass',
        'csssplit',
        'file_append'
    ]);

    grunt.registerTask('build', [
        'clean',
        'copy:bower',
        'sass',
        'csssplit',
        'file_append',
        'copy:css',
        'cssmin',
        'copy:wp_style',
        'bower_concat:dist',
        'concat',
        'copy:modernizr',
        'uglify',
        'copy:dist'
    ]);

    grunt.registerTask('default' [
        'build'
    ]);

};