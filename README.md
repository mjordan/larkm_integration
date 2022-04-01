# larkm Integration

## Introduction

Proof of concept Drupal module that integrates the larkm ARK manager.

Concept is that an ARK that uses a node's UUID as its identifier string can be assigned to a node before the ARK is persisted in its resolver. This module does two things:

1. auto-populates a field (which you identify in the module's configuration settings) with an ARK using the node's UUID as the identifier string
1. provides a View that lists the title, UUID, and node ID of all nodes created or modified on the specified day (see sample URL below)

Minting of ARKs, and persisting them to a field in the node, occurs automatically on creation or updating of the node. The View exposes the list of nodes created or updated on the current day; this list is intended to be consumed by a script that creates the ARKs in larkm as a daily batch. This asynchronous, batch-creation-of-ARKs-after-the-resource-is-created approach is an alternative to the more common synchronous, create-PID-in-realtime-on-node-creation approach.

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

1. Go to `/admin/config/larkm_integration/settings` and enter:
   * the machine name of the field to persist the ARKs to. The field must be a simple text field, but it can be a multivalued field.
   * the node content types that you want to mint ARKs for.
   * your larkm hostname, NAAN, and shoulder. Only one shoulder is allowed.
   * the content types you want to create ARKs for.
1. Modify the "larkm daily node list" View to filter on the field identified in the module config's "ARK fieldname" setting, and so that field "Starts with" the hostname in the module config's "larkm hostname" setting.

By default the View contains a `title`, `uuid`, and `nid` field; you can add additional fields that correspond to the "when" and "who" fields for the ARK metadata (see below for more information).

## Usage

Minting of ARKs is automatic, using the node's UUID as the identifier string in its ARK, and the configured larkm resolver hostname, NAAN, and shoulder.

In order to create and pesist the ARKs so that larkm can resolve them, you will need a script similar to the larkm's "mint_arks_from_csv.py". The View that this module installs will provide a list of all the nodes created/modified on the day specified in the `date` query parameter: `http://localhost:8000/larkm_daily_nodes?_format=json&date=20220215`, here the value of `date` is today's date in YYYYMMDD format. Using this request, you can generate a daily list of nodes to run through your ARK minting script. The View only contains three fields, `title`, `uuid`, and `nid`. This is enough data for your script to create larkm identifiers (from `uuid` values), "erc_what" values (from `title` values), and target URLs and "erc_where" values (from `nid` values). If you want your ARKs to contain "erc_when", "erc_who", and "policy" values, you will need to add to the View the Drupal fields that your script will map to those ARK metadata fields.

## Current maintainer

* [Mark Jordan](https://github.com/mjordan)

## License

[GPLv2](http://www.gnu.org/licenses/gpl-2.0.txt)
