module.exports = function (grunt) {

  // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                mangle: false
            },
            my_target: {
                files: [{
                    expand: true,
                    cwd: "js/",
                    src: '*.js',
                    dest: "../public/js"
                }]
            }
        },
        jade: {
            compile: {
                options: {
                    data: {
                        debug: false
                    }
                },
                files: [{
                    src: ["register.jade", "login.jade"],
                    dest: "../resources/views/auth",
                    ext: ".blade.php",
                    expand: true,
                    cwd: "jade/"
                }, {
                    src: ["*.jade", "!register.jade", "!login.jade"],
                    dest: "../resources/views",
                    ext: ".blade.php",
                    expand: true,
                    cwd: "jade/"
                }]
            }
        },
        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    '../public/css/stylesheet.css': 'scss/stylesheet.scss'
                }
            }
        },
        watch: {
            scripts: {
                files: ['js/*.js', 'jade/*.jade', 'jade/snippets/*.jade', 'jade/snippets/searches/*.jade', 'scss/*.scss'],
                tasks: ['jade', 'sass', 'uglify'],
                options: {
                    spawn: false
                }
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-jade');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    // Default task(s).
    grunt.registerTask('default', ['jade', 'sass', 'watch', 'uglify']);
};