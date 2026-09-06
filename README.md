# Arda Editorial Journal

A WordPress child theme for `ardabasoglu.com`, based on Twenty Twenty-Five.

## What it changes

- Warm editorial paper-like background
- Fraunces/Inter typography pairing
- Homepage hero with two-column editorial layout
- Framed hero image
- Recent writing grid
- Cleaner post cards with shorter excerpts
- Improved single post/page readability
- Styled code blocks for technical posts
- Simple header/footer template parts

## Parent theme

Requires the WordPress **Twenty Twenty-Five** theme to be installed.

## Install

1. Create a ZIP of the `arda-editorial-journal/` folder, or use the packaged ZIP if available locally.
2. In WordPress admin, go to **Appearance → Themes → Add New → Upload Theme**.
3. Upload the ZIP.
4. If replacing an older version, choose **Replace current with uploaded**.
5. Activate **Arda Editorial Journal**.
6. Clear LiteSpeed/browser cache after activation.

## Development

The actual theme lives in:

```text
arda-editorial-journal/
```

Useful local checks:

```bash
php -l arda-editorial-journal/functions.php
python3 -m json.tool arda-editorial-journal/theme.json >/dev/null
zip -r arda-editorial-journal.zip arda-editorial-journal
```

## Notes

This theme does not delete content, change posts, modify plugins, or touch the database.

## License

GPL-2.0-or-later.
