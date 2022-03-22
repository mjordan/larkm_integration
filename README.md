# larkm Integration

## Introduction

Proof of concept Drupal 9 Module that integrates the larkm ARK manager.

Concept is that an ARK that uses a node's UUID as its identifier string can be assigned to a node before the ARK is minted in its resolver. This module does two things:

1. auto-populates the field `field_ark` with an ARK using the node's UUID as the identifier string
1. provides a view that lists the title, UUID, and node ID of all nodes created on the specified day (see sample URL below)

The list can be consumed by a script that creates the ARKs in larkm as a daily batch.

## Requirements

* [Islandora 9](https://github.com/Islandora/islandora)
* An instance of the larkm ARK manager/resolver.

## Configuration

## Usage

`http://localhost:8000/larkm_daily_nodes?_format=json&created_date=20220215`

where the value of `created_date` is today in YYYYMMDD format.

## What's missing

* Config form to set the ARK fieldname, resolver hostname, NAAN, and shoulder to use in the ARKs.

## Current maintainer

* [Mark Jordan](https://github.com/mjordan)

## License

[GPLv2](http://www.gnu.org/licenses/gpl-2.0.txt)
