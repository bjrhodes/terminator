module.exports = function(grunt) {
  require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    phplint:{
      app: ['src/**/*.php', 'tests/**/*.php']
    },

    phpcs: {
      application: {
        dir: 'src'
      },
      options: {
        standard: 'build/PHPCS/ruleset.xml',
        bin: 'vendor/bin/phpcs'
      }
    },

    phpunit: {
      classes: {
        dir: 'tests/'
      },
      options: {
        configuration: 'tests/phpunit.xml',
        colors: true,
        stopOnFailure: true,
        followOutput: true,
        bin: 'vendor/bin/phpunit'
      }
    },

    phpmd: {
      application: {
        dir: 'src',
      },
      options: {
        reportFormat: 'text',
        rulesets: 'build/phpmd.xml',
        bin: 'vendor/bin/phpmd'
      }
    },

    clean: {
      coverage: ['coverage']
    },

    shell: {
      testautoload: {
        options: {
          stdout: true,
          failOnError: true
        },
        command: 'phpab -o tests/Autoload.php tests src'
      },
      autoload: {
        options: {
          stdout: true,
          failOnError: true
        },
        command: 'phpab -o src/Autoload.php src'
      },
      composer: {
        options: {
          stdout: true,
          stderr: true,
          failOnError: true
        },
        command: 'composer install'
      }
    },

    watch: {
      src: {
        files: ['src/**/*', '!**/vendor/**', '!**/Autoload.php'],
        tasks: ['code_quality', 'test'],
        options: {
          event: ['changed']
        }
      },
      tests: {
        files: ['tests/**/*', '!**/vendor/**', '!**/Autoload.php'],
        tasks: ['test'],
        options: {
          event: ['changed']
        }
      },
      newstuff: {
        files: ['src/**/*', 'tests/**/*', '!**/vendor/**', '!**/Autoload.php'],
        tasks: ['build_deps'],
        options: {
          event: ['added', 'deleted']
        }
      }
    }
  });

  // Default task(s).
  grunt.registerTask('build_deps', ['shell:autoload', 'shell:composer', 'shell:testautoload']);
  grunt.registerTask('code_quality', ['phplint', 'phpcs', 'phpmd']);
  grunt.registerTask('test', ['phpunit']);

  grunt.registerTask(
    'default',
    ['build_deps', 'code_quality', 'test']
  );
};
