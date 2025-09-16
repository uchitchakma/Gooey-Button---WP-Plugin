<?php
/**
 * Plugin Name: UCD Gooey Button
 * Description: Gooey animated CTA button: shortcode + Elementor widget. Use the admin page for shortcode builder or the Elementor widget directly.
 * Version: 1.1.0
 * Author: Uchit Chakma
 * License: GPLv2 or later
 */

if (!defined('ABSPATH')) exit;

/* ---------------------------
 Register Shortcode
----------------------------*/
// Primary shortcode name (lowercase canonical)
add_shortcode('uc-gooey-btn', 'tgx_tecko_shortcode');
// Backward compatibility: previous mixed-case and legacy forms
add_shortcode('UC-Gooey-btn', 'tgx_tecko_shortcode');
add_shortcode('tecko_goo_button', 'tgx_tecko_shortcode');
add_shortcode('uc_gooey_btn', 'tgx_tecko_shortcode');
function tgx_tecko_shortcode($atts) {
    $a = shortcode_atts([
        'label' => 'Know How',
        'color' => '#1D4770',
        'text_color' => '#ffffff',
    'color_hover' => '',
    'text_color_hover' => '',
        'height' => '51',      // px
        'width' => '200',      // px
        'href' => '#',
    'popup_id' => '',
    'id' => '',
    'class' => '',
    'font_size' => '',
    'font_weight' => '',
        'move' => '20'         // px move distance
    ], $atts);

    // ensure safe values
    $label = esc_html($a['label']);
    $color = esc_attr($a['color']);
    $text_color = esc_attr($a['text_color']);
  $color_hover = $a['color_hover'] !== '' ? esc_attr($a['color_hover']) : '';
  $text_color_hover = $a['text_color_hover'] !== '' ? esc_attr($a['text_color_hover']) : '';
    $height = intval($a['height']);
    $width = intval($a['width']);
  $href = esc_url($a['href']);
  $popup_id = sanitize_key($a['popup_id']);
    $html_id = $a['id'] !== '' ? sanitize_html_class($a['id']) : '';
    $extra_class = $a['class'] !== '' ? preg_replace('/[^A-Za-z0-9_\- ]/','', $a['class']) : '';
    $font_size = $a['font_size'] !== '' ? preg_replace('/[^0-9\.]/','', $a['font_size']) : '';
    $font_weight = $a['font_weight'] !== '' ? preg_replace('/[^0-9]/','', $a['font_weight']) : '';
    $move = intval($a['move']);

    // unique id to avoid collisions if multiple buttons on page
    $uid = 'tgx-btn-' . wp_unique_id();

    ob_start();
    ?>
    <div class="tgx-tecko-wrap">
    <a <?php if($html_id) echo 'id="'. esc_attr($html_id) .'"'; ?> class="tgx-tecko-button <?= esc_attr($uid) ?><?php if($extra_class) echo ' '. esc_attr($extra_class); ?>" href="<?= $popup_id ? '#' : $href ?>"<?= $popup_id ? ' data-tgx-popup="'. esc_attr($popup_id) .'"' : '' ?>
      style="--tgx-btn-color: <?= $color ?>; --tgx-text-color: <?= $text_color ?>;<?php if($color_hover) echo ' --tgx-btn-color-hover: '. $color_hover . ';'; ?><?php if($text_color_hover) echo ' --tgx-text-color-hover: '. $text_color_hover . ';'; ?><?php if($font_size) echo ' --tgx-font-size: '. $font_size .'px;'; ?><?php if($font_weight) echo ' --tgx-font-weight: '. $font_weight .';'; ?> --tgx-btn-h: <?= $height ?>px; --tgx-btn-w: <?= $width ?>px; --tgx-move: <?= $move ?>px;">
        <span class="tgx-button-text"><?= $label ?></span>
        <span class="tgx-button-icon" aria-hidden="true">
           <!-- arrow svg -->
           <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
             <path d="M7 17L17 7"></path>
             <path d="M7 7h10v10"></path>
           </svg>
        </span>
      </a>
    </div>

    <style>
    /* Scoped-ish CSS — selectors rely on unique class per button */
    .tgx-tecko-wrap { display:inline-block; }
    .tgx-tecko-button {
      display:inline-flex;
      position:relative;
      filter:url(#tgx-goo);
      -webkit-filter:url(#tgx-goo);
      height:var(--tgx-btn-h);
      color:var(--tgx-text-color);
      text-decoration:none;
      align-items:center;
      background:transparent; /* background applied on children for proper goo merge */
    }
    .tgx-button-text, .tgx-button-icon { display:flex; align-items:center; justify-content:center; background:var(--tgx-btn-color); transition:background .35s ease, color .35s ease; }
    .tgx-button-text {
      padding:0 20px;
      border-radius:9999px;
      width:var(--tgx-btn-w);
      color:var(--tgx-text-color);
      height:var(--tgx-btn-h);
      display:flex;
      align-items:center;
      font-size: var(--tgx-font-size, inherit);
      font-weight: var(--tgx-font-weight, inherit);
    }
    .tgx-button-icon {
      width:var(--tgx-btn-h);
      height:var(--tgx-btn-h);
      border-radius:9999px;
      transition:transform 0.9s cubic-bezier(0.135,0.9,0.15,1);
      color:var(--tgx-text-color);
      margin-left:-3px; /* reduced overlap for slimmer goo join */
      display:flex; align-items:center; justify-content:center;
    }
    .tgx-button-icon svg { transition: transform 0.9s cubic-bezier(0.135,0.9,0.15,1); }
   .tgx-tecko-button:hover .tgx-button-icon,
   .tgx-tecko-button:focus .tgx-button-icon { transform:translateX(var(--tgx-move)); }
    .tgx-tecko-button.is-hover .tgx-button-icon { transform:translateX(var(--tgx-move)); }
    .tgx-tecko-button:hover .tgx-button-icon svg,
    .tgx-tecko-button:focus .tgx-button-icon svg,
    .tgx-tecko-button.is-hover .tgx-button-icon svg { transform: rotate(45deg); }
   /* Hover color swap if vars provided */
   .tgx-tecko-button:hover .tgx-button-text,
   .tgx-tecko-button:focus .tgx-button-text,
   .tgx-tecko-button.is-hover .tgx-button-text,
   .tgx-tecko-button:hover .tgx-button-icon,
   .tgx-tecko-button:focus .tgx-button-icon,
   .tgx-tecko-button.is-hover .tgx-button-icon {
     background: var(--tgx-btn-color-hover, var(--tgx-btn-color));
     color: var(--tgx-text-color-hover, var(--tgx-text-color));
   }
    </style>

    <script>
    (function(){
      // Touch support for each button
      var btn = document.querySelector('.<?= $uid ?>');
      if(!btn) return;
      // Optional popup trigger integration (Elementor or custom) via data attribute
      var popupId = btn.getAttribute('data-tgx-popup');
      if(popupId){
        btn.addEventListener('click', function(e){
          // If a popup library defines a global trigger function, call it.
          // Developers can hook window.tgxOpenPopup = function(id) { ... };
          if(typeof window.tgxOpenPopup === 'function'){
            e.preventDefault();
            window.tgxOpenPopup(popupId);
          }
        });
      }
      var supportsTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
      if(!supportsTouch) return;
      btn.addEventListener('touchstart', function(e){
        if(!btn.classList.contains('is-hover')) {
          e.preventDefault();
          btn.classList.add('is-hover');
          setTimeout(function(){ btn.classList.remove('is-hover'); }, 900);
        }
      }, {passive:false});
    })();
    </script>
    <?php
    return ob_get_clean();
}

/* ---------------------------
 Enqueue nothing globally — plugin injects inline styles per-button for portability
----------------------------*/

/* ---------------------------
 Elementor widget (if Elementor active)
----------------------------*/
add_action('init', function(){
  // register Elementor widget only if Elementor is present
  if (defined('ELEMENTOR_PATH') && class_exists('\Elementor\Widget_Base')) {
    add_action('elementor/widgets/register', 'tgx_register_elementor_widget');
  }
});

function tgx_register_elementor_widget($widgets_manager) {
  // load widget class from closure to keep single-file
}

/* Because we can't create a second file in this one-file plugin response,
   we'll define the widget class dynamically via eval-like approach if Elementor asks for it.
   For safety and clarity, let's hook earlier to create the class when Elementor loads.
*/

add_action('elementor/widgets/register', function($widgets_manager){
  if(class_exists('TGX_Elementor_Goo_Button')) return;

  class TGX_Elementor_Goo_Button extends \Elementor\Widget_Base {
    public function get_name() { return 'tgx_goo_button'; }
  public function get_title() { return 'UCD Gooey Button'; }
    public function get_icon() { return 'eicon-button'; }
    public function get_categories() { return ['general']; }

    public function get_script_depends() { return []; }

    protected function register_controls(){
      $this->start_controls_section('content_section', ['label' => 'Content']);
      $this->add_control('label', [
        'label' => 'Label',
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'Know How',
      ]);
      $this->add_control('href', [
        'label' => 'Link',
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => '#',
        'default' => ['url' => '#'],
        'dynamic' => [ 'active' => true ],
      ]);
      $this->add_control('popup_id', [
        'label' => __('Popup ID (optional)','tgx'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'description' => __('Enter a popup slug/ID to trigger instead of a link. Provides data-tgx-popup attribute.','tgx'),
        'default' => '',
      ]);
      $this->end_controls_section();

      $this->start_controls_section('style_section', ['label' => 'Style']);
        // State tabs (Normal / Hover) for colors like standard Elementor widgets
        $this->start_controls_tabs('tabs_colors');

        $this->start_controls_tab('tab_colors_normal', ['label' => __('Normal','tgx')]);
        $this->add_control('color', [
          'label' => __('Background','tgx'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'default' => '#1D4770',
        ]);
        $this->add_control('text_color', [
          'label' => __('Text','tgx'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'default' => '#ffffff',
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('tab_colors_hover', ['label' => __('Hover','tgx')]);
        $this->add_control('color_hover', [
          'label' => __('Background','tgx'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'default' => '',
        ]);
        $this->add_control('text_color_hover', [
          'label' => __('Text','tgx'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'default' => '',
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
      // Slider controls for sizing
      $this->add_control('height', [
        'label' => 'Height',
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [ 'px' => ['min' => 30, 'max' => 140] ],
        'default' => [ 'unit' => 'px', 'size' => 51 ],
      ]);
      $this->add_control('width', [
        'label' => 'Pill Width',
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [ 'px' => ['min' => 80, 'max' => 500] ],
        'default' => [ 'unit' => 'px', 'size' => 200 ],
      ]);
      $this->add_control('move', [
        'label' => 'Move Distance',
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [ 'px' => ['min' => 5, 'max' => 120] ],
        'default' => [ 'unit' => 'px', 'size' => 20 ],
      ]);

      // Typography group control for button text
      if ( class_exists('Elementor\\Group_Control_Typography') ) {
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
          'name' => 'typography',
          'selector' => '{{WRAPPER}} .tgx-tecko-button .tgx-button-text',
        ]);
      }
      $this->end_controls_section();
    }

    protected function render(){
      $settings = $this->get_settings_for_display();
      $label = esc_html($settings['label']);
      $href = esc_url($settings['href']['url'] ?? '#');
      $color = esc_attr($settings['color']);
      $text_color = esc_attr($settings['text_color']);
      // Slider values may come as array ['size'=>value,'unit'=>'px'] or plain number fallback
      $height = isset($settings['height']['size']) ? intval($settings['height']['size']) : intval($settings['height']);
      $width  = isset($settings['width']['size']) ? intval($settings['width']['size'])   : intval($settings['width']);
      $move   = isset($settings['move']['size']) ? intval($settings['move']['size'])     : intval($settings['move']);
      // Use shortcode renderer to avoid duplicating output logic
      $popup_id = sanitize_key($settings['popup_id'] ?? '');
      $shortcode = sprintf('[uc-gooey-btn label="%s" color="%s" text_color="%s" height="%d" width="%d" href="%s" move="%d"',
        $label, $color, $text_color, $height, $width, $href, $move
      );
      if($popup_id){ $shortcode .= ' popup_id="' . esc_attr($popup_id) . '"'; }
      if(!empty($settings['color_hover'])) { $shortcode .= ' color_hover="' . esc_attr($settings['color_hover']) . '"'; }
      if(!empty($settings['text_color_hover'])) { $shortcode .= ' text_color_hover="' . esc_attr($settings['text_color_hover']) . '"'; }
      $shortcode .= ']';
      echo do_shortcode( $shortcode );
    }
  }

  // register widget
  $widgets_manager->register( new TGX_Elementor_Goo_Button() );
});

/* Output a single global SVG filter once (safer than repeating per button) */
if(!function_exists('tgx_output_global_goofilter')) {
  function tgx_output_global_goofilter(){
    static $done = false; if($done) return; $done = true;
    echo '<svg xmlns="http://www.w3.org/2000/svg" style="position:absolute; width:0; height:0; overflow:hidden" aria-hidden="true" focusable="false"><defs><filter id="tgx-goo"><feGaussianBlur in="SourceGraphic" stdDeviation="3.6" result="blur"/><feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -8" result="goo"/><feComposite in="SourceGraphic" in2="goo" operator="atop"/></filter></defs></svg>';
  }
  add_action('wp_footer','tgx_output_global_goofilter');
}

/* ---------------------------
 Admin Menu: Shortcode Builder
----------------------------*/
add_action('admin_menu', function(){
  $icon = 'dashicons-editor-code';
  $svg_path = plugin_dir_path(__FILE__) . 'UCDREAMS LOGO.svg';
  if(file_exists($svg_path)) {
    $svg_raw = file_get_contents($svg_path);
    if($svg_raw && strpos($svg_raw,'<svg') !== false) {
      // sanitize minimal: strip scripts
      $svg_sanitized = preg_replace('/<script.*?<\/script>/is','',$svg_raw);
      $svg_base64 = base64_encode($svg_sanitized);
      $icon = 'data:image/svg+xml;base64,' . $svg_base64;
    }
  }
  add_menu_page(
    'UCD Gooey Button',
    'UCD Gooey Button',
    'manage_options',
    'uc-gooey-button',
    'tgx_uc_gooy_admin_page',
    $icon,
    56
  );
});

function tgx_uc_gooy_admin_page(){
  if(!current_user_can('manage_options')) return;
  ?>
  <div class="wrap">
    <?php
      $svg_path = plugin_dir_path(__FILE__) . 'UCDREAMS LOGO.svg';
      $logo_inline = '';
      if(file_exists($svg_path)) {
        $logo = file_get_contents($svg_path);
        if($logo && strpos($logo,'<svg') !== false) {
          $logo = preg_replace('/<svg([^>]*?)\swidth="[^"]*"/i','<svg$1',$logo,1);
          $logo = preg_replace('/<svg([^>]*?)\sheight="[^"]*"/i','<svg$1',$logo,1);
          $logo = preg_replace('/<svg(?![^>]*style=)([^>]*)>/i','<svg$1 style="width:40px;height:auto;max-width:40px;display:block;">',$logo,1);
          if(strpos($logo,'style="') !== false && strpos($logo,'width:40px') === false) {
            $logo = preg_replace('/<svg([^>]*?)style="([^"]*)"/i','<svg$1style="$2;width:40px;max-width:40px;height:auto;display:block;"',$logo,1);
          }
          $logo_inline = '<span class="ucd-gooey-logo" style="display:inline-block;width:40px;line-height:0;">' . $logo . '</span>';
        }
      }
    ?>
    <h1 style="display:flex;align-items:center;gap:12px;margin:8px 0 14px;"><?php echo $logo_inline; ?> <span>UCD Gooey Button <small style="font-size:14px;font-weight:400;opacity:.7;">Shortcode Builder</small></span></h1>
    <p>This interface is for shortcode users (any page builder). Elementor users should use the <strong>UCD Gooey Button</strong> widget directly for richer controls. When the Elementor widget is used its settings override shortcode styling.</p>
    <hr/>
    <form id="uc-gooey-form" onsubmit="return false;" style="max-width:760px;">
      <table class="form-table"><tbody>
        <tr><th scope="row"><label>Label</label></th><td><input type="text" name="label" value="Know How" class="regular-text"></td></tr>
        <tr><th scope="row"><label>Link (href)</label></th><td><input type="text" name="href" value="#" class="regular-text"></td></tr>
        <tr><th scope="row"><label>Popup ID</label></th><td><input type="text" name="popup_id" value="" class="regular-text" placeholder="optional"></td></tr>
        <tr><th scope="row"><label>Width (px)</label></th><td><input type="number" name="width" value="200" min="50" max="600"></td></tr>
        <tr><th scope="row"><label>Height (px)</label></th><td><input type="number" name="height" value="51" min="30" max="200"></td></tr>
        <tr><th scope="row"><label>Move Distance (px)</label></th><td><input type="number" name="move" value="20" min="5" max="200"></td></tr>
        <tr><th scope="row"><label>Background Color</label></th><td><input type="text" name="color" value="#1D4770" class="regular-text" placeholder="#hex"></td></tr>
        <tr><th scope="row"><label>Text Color</label></th><td><input type="text" name="text_color" value="#ffffff" class="regular-text" placeholder="#hex"></td></tr>
        <tr><th scope="row"><label>Background Hover</label></th><td><input type="text" name="color_hover" value="" class="regular-text" placeholder="#hex optional"></td></tr>
        <tr><th scope="row"><label>Text Hover</label></th><td><input type="text" name="text_color_hover" value="" class="regular-text" placeholder="#hex optional"></td></tr>
        <tr><th scope="row"><label>HTML id</label></th><td><input type="text" name="id" value="" class="regular-text" placeholder="optional"></td></tr>
        <tr><th scope="row"><label>Extra CSS classes</label></th><td><input type="text" name="class" value="" class="regular-text" placeholder="space separated"></td></tr>
        <tr><th scope="row"><label>Font Size (px)</label></th><td><input type="number" name="font_size" value="" min="8" max="120" placeholder="inherit"></td></tr>
        <tr><th scope="row"><label>Font Weight</label></th><td><input type="number" name="font_weight" value="" min="100" max="900" step="100" placeholder="inherit"></td></tr>
      </tbody></table>
      <p><button type="button" class="button button-primary" id="uc-generate">Generate Shortcode</button></p>
      <h2>Shortcode</h2>
  <textarea id="uc-shortcode-output" class="large-text code" rows="3" readonly>[uc-gooey-btn label="Know How"]</textarea>
      <p class="description">Copy and paste into any editor or builder that supports shortcodes.</p>
      <h2>Example Usage (PHP)</h2>
  <code>&lt;?php echo do_shortcode('[uc-gooey-btn label="Know How"]'); ?&gt;</code>
      <h2>CSS Targeting</h2>
      <p>Base class: <code>.tgx-tecko-button</code>. Add your own class via the form for custom styling. Per-button unique class is auto-generated (e.g. <code>.tgx-btn-123</code>).</p>
    </form>
    <hr style="margin-top:40px;"/>
    <p style="font-size:11px;opacity:.7;margin-top:8px;">Developed by <a href="https://ucdreams.com" target="_blank" rel="noopener noreferrer">UCD</a>.</p>
  </div>
  <script>
  (function($){
    function esc(val){ return (val+"").replace(/"/g,'&quot;'); }
    function build(){
      var f = document.getElementById('uc-gooey-form');
      var data = {};
      Array.prototype.forEach.call(f.querySelectorAll('[name]'), function(inp){ data[inp.name] = inp.value.trim(); });
  var parts = ['[uc-gooey-btn'];
      ['label','color','text_color','color_hover','text_color_hover','height','width','href','popup_id','move','id','class','font_size','font_weight'].forEach(function(k){
        if(data[k] !== '' && !(k==='href' && data.popup_id)){ parts.push(k+'="'+esc(data[k])+'"'); }
        if(k==='href' && data.popup_id){ /* skip href if popup specified? keep for fallback */ }
      });
      parts.push(']');
      document.getElementById('uc-shortcode-output').value = parts.join(' ');
    }
    document.getElementById('uc-generate').addEventListener('click', build);
  })(window.jQuery || document.querySelector.bind(document));
  </script>
  <?php
}

