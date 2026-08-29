# Changelog

# 3.0.0 / 2026-08-29
- Requires htmx 4.x (HyperPress "HTMX Version: 4.x"). htmx 2.x is no longer supported.
- Removed the `hx-ext` body attribute: htmx 4 extensions auto-register on load.
- Replaced the WP_DEBUG `debug` extension with the htmx 4 `logAll` config flag.
- `hx-boost` on body now uses the `hx-boost:inherited` modifier (htmx 4 has no implicit attribute inheritance).
- Renamed `hx-disabled-elt` to `hx-disable` in demo templates.
- htmx-config meta keys renamed: `timeout` -> `defaultTimeout`, `globalViewTransitions` -> `transitions`.
- Demo event listeners moved from `document.body` to `document` with capture (htmx 4 events no longer bubble to the body).
- Filter `hxtheme/meta/globalTransitions` renamed to `hxtheme/meta/transitions` (boolean).

# 2.0.3 / 2026-04-24
- Renamed theme to HTMX Theme for WordPress.
- Updated logic to use HyperPress plugin function names and option keys.
- Clarified focus on HTMX and Alpine Ajax.

# 2.0.2 / 2025-06-06
- Maintenance update.

# 1.0.0 / 2024-02-20
- First public release.
