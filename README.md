# larkm Integration

## Introduction

Proof of concept Drupal 9 Module that integrates the larkm ARK manager.

Concept is that an ARK that uses a node's UUID as its identifier string can be assigned to a node before the ARK is minted in its resolver. This module does two things:

1. auto-populates a field (which you identify in the module's configuration settings) with an ARK using the node's UUID as the identifier string
1. provides a view that lists the title, UUID, and node ID of all nodes created on the specified day (see sample URL below)

The list can be consumed by a script that creates the ARKs in larkm as a daily batch. This batch-creation-of-ARKs-after-the-resource-is-created approachis an alternative to the more common create-PID-in-realtime approach.

## Requirements

* [Islandora 2](https://github.com/Islandora/islandora)
* An instance of the larkm ARK manager/resolver.

## Installation

You can install this module using Composer. Within your Drupal root directory, run the following:

1. `composer require mjordan/larkm_integration "dev-main"`
1. Enable the module either under the "Admin > Extend" menu or by running `drush en -y larkm_integration`.

If you're deploying Islandora via ISLE, install and enable this module using these two commands from within your isle-dc directory:

1. `docker-compose exec -T drupal with-contenv bash -lc "composer require mjordan/larkm_integration"`
2. `docker-compose exec -T drupal with-contenv bash -lc "drush en -y larkm_integration"`

## Configuration

1. Go to `/admin/config/larkm_integration/settings` and entery the machine name of the field to persist the ARKs to, your larkm hostname, NAAN, and shoulder. Only one shoulder is allowed. The field must be a simple text field.
1. Modify the "larkm daily node list" View to filter by the content type(s) you want to assign ARKs to. By default the View contains a `title`, `uuid`, and `nid` field; you can add additional fields that correspond to the "when" and "who" fields for the ARK metadata.

## Usage

Minting of ARKs is automatic, using the node's UUID as the identifier string in its ARK, and the configured larkm hostname, NAAN, and shoulder.

In order to create the ARKs using larkm, you will need a script similar to the larkm's "mint_arks_from_csv.py". The View that this module installs will provide a list of all the nodes created on the day specified in the `created_date` query parameter: `http://localhost:8000/larkm_daily_nodes?_format=json&created_date=20220215`, here the value of `created_date` is today's date in YYYYMMDD format. Using this request, you can generate a daily list of nodes to run through the ARK minting script.

## Current maintainer

* [Mark Jordan](https://github.com/mjordan)

## License

[GPLv2](http://www.gnu.org/licenses/gpl-2.0.txt)
