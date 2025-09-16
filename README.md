# UCD Gooey Button

**Gooey animated CTA button for WordPress.**  
Shortcode + Elementor widget.  
Developed by [Uchit Chakma](https://uchitchakma.com) at [UC Dreams](https://ucdreams.com).

---

## Features

- Animated "gooey" button effect for call-to-action.
- Use via shortcode or Elementor widget.
- Inline style injection for portability.
- Customizable colors, size, font, hover effects.
- Optional popup trigger integration.
- Admin page with shortcode builder.

---

## Installation

1. Download or clone this repository.
2. Place the plugin folder in your WordPress `/wp-content/plugins/` directory.
3. Activate **UCD Gooey Button** from the WordPress admin.

---

## Usage

### Shortcode

Insert the shortcode anywhere shortcodes are supported:

```php
[uc-gooey-btn label="Know How" color="#1D4770" text_color="#ffffff" href="https://example.com"]
```

**Parameters:**

- `label` – Button text
- `color` – Background color
- `text_color` – Text color
- `color_hover` – Hover background color (optional)
- `text_color_hover` – Hover text color (optional)
- `height` – Button height (px)
- `width` – Button width (px)
- `href` – Link URL
- `popup_id` – Popup ID (optional, triggers popup instead of link)
- `id` – HTML id (optional)
- `class` – Extra CSS classes (optional)
- `font_size` – Font size (px, optional)
- `font_weight` – Font weight (optional)
- `move` – Arrow move distance on hover (px)

### Elementor Widget

If Elementor is active, use the **UCD Gooey Button** widget for visual controls.

---

## Admin Shortcode Builder

Go to **UCD Gooey Button** in the WordPress admin menu to generate shortcodes with a visual form.

---

## Customization

- Each button gets a unique class (e.g. `.tgx-btn-123`) for targeting.
- Add your own classes via the shortcode or admin builder.
- CSS variables are used for easy style overrides.

---

## Credits

Developed by [Uchit Chakma](https://uchitchakma.com)  
Company: [UC Dreams](https://ucdreams.com)

---

## License

GPLv2 or later.