# ExpressionEngine Freshness Filter

Check the freshness of ExpressionEngine channel content.

Given a list of channel names and an optional age and unit of time (default: 1 year), return a json-encoded array of channel names whose content is newer than the cutoff date.

## Examples

To check channels whose content has been updated within the last year, simply supply a list of pipe-separated channel names:

```handlebars
{exp:freshness_filter channels="foo|bar|baz"}
```

You may supply a different cutoff age and/or unit of time. Allowed time units are "year", "month", and "day".
You may also filter by entry date instead of the default edit date.

```handlebars
{exp:freshness_filter channels="foo|bar|baz" age="2" unit="month" allow_edits="false"}
```

In all cases, Freshness Filter returns a json-encoded array of channel names:

```json
["foo", "baz"]
```

## Installation

1. Clone the repository as `freshness_filter`.
2. Copy the repo contents to your user addons directory (e.g., `system/user/addons/freshness_filter/`).
3. From the control panel, install Freshness Filter.

## Changelog

### 1.1.0

- Allow filtering by edit date (default) or entry date.

### 1.0.1

- Order results by channel title.

### 1.0.0

- Initial release.
