<?php
if (!defined("ABSPATH")) {
    exit(); // Exit if accessed directly.
}

/**
 * Elementor Custom Audio Player Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_Custom_Audio_Player_Widget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $js_path = plugin_dir_url(__FILE__) . "/js/script.js";
        $css_path = plugin_dir_url(__FILE__) . "/css/style.css";

        wp_register_script(
            "custom-audio-player-script",
            $js_path,
            ["elementor-frontend"],
            "1.0.0",
            true
        );
        wp_register_style("custom-audio-player-style", $css_path);
    }

    public function get_script_depends()
    {
        return ["custom-audio-player-script"];
    }
    public function get_style_depends()
    {
        return ["custom-audio-player-style"];
    }

    /**
     * Get widget name.
     *
     * Retrieve Custom Audio Player widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name()
    {
        return "custom_audio_player";
    }

    /**
     * Get widget title.
     *
     * Retrieve Custom Audio Player widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__(
            "Custom Audio Player",
            "elementor-custom-audio-player-widget"
        );
    }

    /**
     * Get widget icon.
     *
     * Retrieve Custom Audio Player widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return "eicon-code";
    }

    /**
     * Get custom help URL.
     *
     * Retrieve a URL where the user can get more information about the widget.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget help URL.
     */
    public function get_custom_help_url()
    {
        return "https://developers.elementor.com/docs/widgets/";
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ["general"];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the oEmbed widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ["audio player", "url", "link"];
    }

    /**
     * Register Custom Audio Player widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->start_controls_section("content_section", [
            "label" => esc_html__(
                "Content",
                "elementor-custom-audio-player-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);

		$this->add_control("url", [
		    "label" => esc_html__(
		        "URL to embed",
		        "elementor-custom-audio-player-widget"
		    ),
		    "type" => \Elementor\Controls_Manager::URL,
		    "input_type" => "media",
		    "placeholder" => esc_html__(
		        "https://your-link.com",
		        "elementor-custom-audio-player-widget"
		    ),
		    "dynamic" => [
		        "active" => true,
		    ],
		]);

		$this->add_control("title", [
		    "label" => esc_html__(
		        "Title of audio",
		        "elementor-custom-audio-player-widget"
		    ),
		    "type" => \Elementor\Controls_Manager::TEXT,
		    "input_type" => "text",
		    "placeholder" => esc_html__(
		        "Title on player",
		        "elementor-custom-audio-player-widget"
		    ),
		    "dynamic" => [
		        "active" => true,
		    ],
		]);

		$this->add_control("subtitle", [
		    "label" => esc_html__(
		        "Subtitle of audio",
		        "elementor-custom-audio-player-widget"
		    ),
		    "type" => \Elementor\Controls_Manager::TEXT,
		    "input_type" => "text",
		    "placeholder" => esc_html__(
		        "Subtitle on player",
		        "elementor-custom-audio-player-widget"
		    ),
		    "dynamic" => [
		        "active" => true,
		    ],
		]);

        $this->end_controls_section();

        $this->start_controls_section("style_section", [
            "label" => esc_html__(
                "Style",
                "elementor-custom-audio-player-widget"
            ),
            "tab" => \Elementor\Controls_Manager::TAB_STYLE, //TAB_CONTENT,
        ]);

		$this->start_controls_tabs("player_styles_tabs", [
		    "label" => esc_html__(
		        "Style1",
		        "elementor-custom-audio-player-widget"
		    ),
		]);

			$this->start_controls_tab("title_ctrl_tab", [
			    "label" => esc_html__(
				"Title",
				"elementor-custom-audio-player-widget"
			    ),
			]);
				$this->add_group_control(
				    \Elementor\Group_Control_Typography::get_type(),
				    [
					"label" => "Typography",
					"name" => "content_typography_title",
					"selector" => "{{WRAPPER}} .audio-title",
				    ]
				);
				$this->add_control("title_color", [
				    "label" => esc_html__(
					"Color",
					"elementor-custom-audio-player-widget"
				    ),
				    "type" => \Elementor\Controls_Manager::COLOR,
				    "default" => "#fff",
				    "selectors" => [
					"{{WRAPPER}} .audio-title" => "color: {{VALUE}}",
				    ],
				]);
        		$this->end_controls_tab();

			$this->start_controls_tab("subtitle_ctrl_tab", [
			    "label" => esc_html__(
				"Subtitle",
				"elementor-custom-audio-player-widget"
			    ),
			]);
				$this->add_group_control(
				    \Elementor\Group_Control_Typography::get_type(),
				    [
					"label" => "Typography",
					"name" => "content_typography_subtitle",
					"selector" => "{{WRAPPER}} .audio-subtitle",
				    ]
				);

				$this->add_control("subtitle_color", [
				    "label" => esc_html__(
					"Color",
					"elementor-custom-audio-player-widget"
				    ),
				    "type" => \Elementor\Controls_Manager::COLOR,
				    "default" => "#fff",
				    "selectors" => [
					"{{WRAPPER}} .audio-subtitle" => "color: {{VALUE}}",
				    ],
				]);
        		$this->end_controls_tab();

			$this->start_controls_tab("time_ctrl_tab", [
			    "label" => esc_html__(
				"Timer",
				"elementor-custom-audio-player-widget"
			    ),
			]);

				$this->add_group_control(
				    \Elementor\Group_Control_Typography::get_type(),
				    [
					"label" => "Typography",
					"name" => "content_typography_time",
					"selector" => "{{WRAPPER}} .audio-time-container",
				    ]
				);

				$this->add_control("time_color", [
				    "label" => esc_html__(
					"Color",
					"elementor-custom-audio-player-widget"
				    ),
				    "type" => \Elementor\Controls_Manager::COLOR,
				    "default" => "#fff",
				    "selectors" => [
					"{{WRAPPER}} .audio-time-container" => "color: {{VALUE}}",
				    ],
				]);
        		$this->end_controls_tab();

			$this->start_controls_tab("player_ctrl_tab", [
			    "label" => esc_html__(
				"Player",
				"elementor-custom-audio-player-widget"
			    ),
			]);

				$this->add_control("playedcolor", [
				    "label" => esc_html__(
					"Played Background Color",
					"elementor-custom-audio-player-widget"
				    ),
				    "type" => \Elementor\Controls_Manager::COLOR,
				    "default" => "#f2673c",
				    "selectors" => [
					"{{WRAPPER}} .audio-timeline-pass" => "background: {{VALUE}}",
				    ],
				]);

				$this->add_control("defaultcolor", [
				    "label" => esc_html__(
					"Background Color",
					"elementor-custom-audio-player-widget"
				    ),
				    "type" => \Elementor\Controls_Manager::COLOR,
				    "default" => "#cfcfcf",
				    "selectors" => [
					"{{WRAPPER}} .audio-timeline-container" =>
					    "background: {{VALUE}}",
				    ],
				]);

				$this->add_control("playicon", [
				    "label" => esc_html__(
					"Play Icon",
					"elementor-custom-audio-player-widget"
				    ),
				    "type" => \Elementor\Controls_Manager::MEDIA,
				    "media_types" => ["image", "svg"],
				    "selectors" => [
					"{{WRAPPER}} .audio-play-container>img.play" =>
					    "content: url({{URL}})",
				    ],
				]);

				$this->add_control("pauseicon", [
				    "label" => esc_html__(
					"Pause Icon",
					"elementor-custom-audio-player-widget"
				    ),
				    "type" => \Elementor\Controls_Manager::MEDIA,
				    "media_types" => ["image", "svg"],
				    "selectors" => [
					"{{WRAPPER}} .audio-play-container>img.pause" =>
					    "content: url({{URL}})",
				    ],
				]);

        		$this->end_controls_tab();

        	$this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Render Custom Audio Player widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $url = $settings["url"]["url"];
        if ( !$url ):
            $url = "https://allmp3.su/stream/mym/aHR0cHM6Ly9tb29zaWMubXkubWFpbC5ydS9maWxlLzc0ZGNmNTViN2I2NDdiNmQzMTFjOTM4N2IzNDk4YWMxLm1wMw==";
        endif;
        $title = $settings["title"];
        $subtitle = $settings["subtitle"];
        $outerHTML = <<<PLAYER

		<div class="audio-container">
			<div id="circle"></div>
			<div class="audio-timeline-container" id="audio-timeline-container">
				<div class="audio-timeline-pass" id="audio-timeline-pass"></div>
			</div>
			<div class="audio-info">
				<a class="audio-play-container" id="audio-play-container">
				<img src="" class="play" />
				<img src="" class="pause" style="display:none;" />
				</a>
				<div class="audio-text-container">
					<span class="audio-title">$title</span>
					<span class="audio-subtitle">$subtitle</span>
				</div>
				<div class="audio-time-container">
					<span class="pass-time">00:00:00</span>/<span class="all-time"
						>00:00:00</span
						>
				</div>
			</div>
		</div>
		<audio id="music" class="music">
			<source src="$url" />
		</audio>

PLAYER;
        echo $outerHTML;
    }
}

