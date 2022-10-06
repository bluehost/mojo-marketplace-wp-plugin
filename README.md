# Mojo Marketplace WordPress Plugin

[![Version Number](https://img.shields.io/github/v/release/bluehost/mojo-marketplace-wp-plugin?color=21a0ed&labelColor=333333)](https://github.com/bluehost/mojo-marketplace-wp-plugin/releases)
[![Lint PHP](https://github.com/bluehost/mojo-marketplace-wp-plugin/actions/workflows/lint-php.yml/badge.svg?branch=main)](https://github.com/bluehost/mojo-marketplace-wp-plugin/actions/workflows/lint-php.yml)
[![Lint YML](https://github.com/bluehost/mojo-marketplace-wp-plugin/actions/workflows/lint-yml.yml/badge.svg)](https://github.com/bluehost/mojo-marketplace-wp-plugin/actions/workflows/lint-yml.yml)
[![Build Plugin](https://github.com/bluehost/mojo-marketplace-wp-plugin/actions/workflows/upload-artifact-on-push.yml/badge.svg)](https://github.com/bluehost/mojo-marketplace-wp-plugin/actions/workflows/upload-artifact-on-push.yml)

WordPress plugin that integrates a WordPress site with Hosting and the Mojo Marketplace.

# Discontinued

New development on this plugin has been discontinued. It has been replaced with a newer plugin. It can be found at https://github.com/newfold-labs/wp-plugin-mojo/ This repo is still here to support existing sites running this plugin.

# Installation

Find the `mojo-marketplace-wp-plugin.zip` asset for your preferred version at: https://github.com/bluehost/mojo-marketplace-wp-plugin/releases/.

Alternatively, check the updater endpoint for the latest version at: https://hiive.cloud/workers/release-api/plugins/bluehost/mojo-marketplace-wp-plugin?file=mojo-marketplace.php, this also includes a download link to the latest zip file or use this link to access the latest download: https://hiive.cloud/workers/release-api/plugins/bluehost/mojo-marketplace-wp-plugin/download/?file=mojo-marketplace.php.

# Releasing Updates

This plugin has version number set in 2 places in 1 file (mojo-marketplace-wp-plugin/mojo-marketplace.php):

- the plugin header info
- the constant MM_VERSION
